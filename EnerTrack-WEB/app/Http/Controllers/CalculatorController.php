<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPerangkat;
use Illuminate\Support\Str;

class CalculatorController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function index()
    {
        return view('calculator');
    }

    public function getBrands()
    {
        try {
            $client = new Client([
                'timeout' => 5,
                'connect_timeout' => 5,
                'verify' => false
            ]);

            $response = $client->get($this->apiBaseUrl . '/api/brands', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

            $brands = json_decode($response->getBody(), true);
            return response()->json($brands);
        } catch (\Exception $e) {
            Log::error('Error fetching brands:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to fetch brands'], 500);
        }
    }

    public function submitAndAnalyze(Request $request)
    {
        try {
            // Get auth token from session
            $user = session('user');
            if (!$user || !isset($user['token'])) {
                Log::error('No auth token found in session');
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required. Please login again.'
                ], 401);
            }

            // Validate the request
            $validated = $request->validate([
                'billing_type' => 'required|in:token,pascabayar',
                'electricity' => 'required|array',
                'electricity.amount' => 'required|numeric',
                'electricity.kwh' => 'required|numeric',
                'devices' => 'required|array',
                'devices.*.brand' => 'required|string',
                'devices.*.name' => 'required|string',
                'devices.*.category' => 'required|string',
                'devices.*.power' => 'required|numeric',
                'devices.*.duration' => 'required|numeric|min:1|max:24',
                'devices.*.quantity' => 'required|numeric|min:1',
                'devices.*.jenis_pembayaran' => 'required|string',
                'devices.*.besar_listrik' => 'required|string',
                'installed_power_va' => 'required|numeric|min:450|max:22000' // Validate installed power VA
            ]);

            // Calculate total energy consumption
            $totalConsumption = 0;
            $totalCost = 0;
            $deviceAnalysis = [];

            // Get tariff rate based on installed power VA and billing type
            $tariffRate = $this->getTariffRate(
                $request->installed_power_va,
                $request->billing_type === 'pascabayar' ? $request->installed_power_va . ' VA' : ''
            );

            foreach ($request->devices as $device) {
                $dailyConsumption = ($device['power'] * $device['duration'] * $device['quantity']) / 1000; // Convert to kWh
                $monthlyConsumption = $dailyConsumption * 30; // Approximate monthly consumption
                $monthlyCost = $monthlyConsumption * $tariffRate; // Calculate monthly cost
                
                $totalConsumption += $monthlyConsumption;
                $totalCost += $monthlyCost;

                $deviceAnalysis[] = [
                    'name' => $device['name'],
                    'brand' => $device['brand'],
                    'category' => $device['category'],
                    'power' => $device['power'],
                    'duration' => $device['duration'],
                    'quantity' => $device['quantity'],
                    'jenis_pembayaran' => $device['jenis_pembayaran'],
                    'besar_listrik' => $device['besar_listrik'],
                    'daily_consumption' => round($dailyConsumption, 2),
                    'monthly_consumption' => round($monthlyConsumption, 2),
                    'monthly_cost' => round($monthlyCost, 2)
                ];
            }

            // Calculate percentage of total consumption
            foreach ($deviceAnalysis as &$device) {
                $device['percentage'] = round(($device['monthly_consumption'] / $totalConsumption) * 100, 1);
            }

            // Submit to external API
            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ]);

            $submitResponse = $client->post($this->apiBaseUrl . '/api/devices/submit', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ],
                'json' => [
                    'billing_type' => $request->billing_type,
                    'electricity' => [
                        'kwh' => $request->electricity['kwh']
                    ],
                    'devices' => $deviceAnalysis
                ]
            ]);

            $submitData = json_decode($submitResponse->getBody(), true);
            if (!isset($submitData['id_submit']) || !isset($submitData['riwayat_id'])) {
                Log::error('Failed to submit device data or missing riwayat_id in response.', $submitData);
                throw new \Exception('Failed to submit device data or invalid response structure.');
            }
            $riwayatId = $submitData['riwayat_id'];

            // Add a small delay to ensure database commit is visible
            sleep(1); // 1-second delay

            // Get AI analysis
            $response = $client->get($this->apiBaseUrl . '/api/analyze?riwayat_id=' . $riwayatId . '&installed_power_va=' . $request->installed_power_va, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            $aiResponse = json_decode($response->getBody(), true);
            if (!isset($aiResponse['analysis'])) {
                throw new \Exception('Invalid response from AI service');
            }

            // Store the final analysis in session for later use by getAnalysis method
            session([
                'device_analysis' => $deviceAnalysis,
                'total_consumption' => $totalConsumption,
                'total_cost' => $totalCost,
                'ai_analysis' => $aiResponse['analysis']
            ]);

            return response()->json([
                'success' => true,
                'device_analysis' => $deviceAnalysis,
                'total_consumption' => round($totalConsumption, 2),
                'total_cost' => round($totalCost, 2),
                'ai_response' => $aiResponse['analysis']
            ]);

        } catch (\Exception $e) {
            Log::error('Calculator analysis error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error analyzing data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function brands()
    {
        try {
            $client = new Client([
                'timeout' => 5,
                'connect_timeout' => 5,
                'verify' => false
            ]);

            $response = $client->get($this->apiBaseUrl . '/api/brands', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

            $brands = json_decode($response->getBody(), true);
            return response()->json($brands);
        } catch (\Exception $e) {
            Log::error('Error fetching brands:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to fetch brands'], 500);
        }
    }

    public function submit(Request $request)
    {
        try {
            $client = new Client([
                'timeout' => 5,
                'connect_timeout' => 5,
                'verify' => false
            ]);

            $response = $client->post($this->apiBaseUrl . '/api/devices/submit', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $request->all()
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            Log::error('Error submitting device data:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to submit device data'], 500);
        }
    }

    public function analyze(Request $request)
    {
        try {
            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ]);

            // Data needed for external AI API call
            $deviceAnalysis = $request->input('device_analysis');
            $billingType = $request->input('billing_type');
            $electricityKwh = $request->input('electricity_kwh');

            Log::info('Analyze method received data:', [
                'deviceAnalysis' => $deviceAnalysis,
                'billingType' => $billingType,
                'electricityKwh' => $electricityKwh,
            ]);

            if (!$deviceAnalysis || !$billingType || !$electricityKwh) {
                Log::error('Missing data for external AI analysis in analyze method.', [
                    'deviceAnalysis' => $deviceAnalysis,
                    'billingType' => $billingType,
                    'electricityKwh' => $electricityKwh,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Missing data for AI analysis. Please submit devices first.'
                ], 400);
            }

            // Get auth token from session
            $user = session('user');
            if (!$user || !isset($user['token'])) {
                Log::error('No auth token found in session');
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required. Please login again.'
                ], 401);
            }

            // First, submit the devices to get an ID
            $submitResponse = $client->post($this->apiBaseUrl . '/api/devices/submit', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ],
                'json' => [
                    'billing_type' => $billingType,
                    'electricity' => [
                        'kwh' => $electricityKwh
                    ],
                    'devices' => array_map(function($device) {
                        return [
                            'name' => $device['name'],
                            'brand' => $device['brand'] ?? 'Unknown',
                            'power' => $device['power'] ?? 0,
                            'duration' => $device['duration'] ?? 0,
                            'quantity' => $device['quantity'] ?? 1
                        ];
                    }, $deviceAnalysis)
                ]
            ]);

            $submitData = json_decode($submitResponse->getBody(), true);
            if (!isset($submitData['id_submit'])) {
                throw new \Exception('Failed to submit device data');
            }

            // Now get the analysis
            $response = $client->get($this->apiBaseUrl . '/api/analyze', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            $aiResponse = json_decode($response->getBody(), true);

            if (!isset($aiResponse['analysis'])) {
                throw new \Exception('Invalid response from AI service');
            }

            // Return the AI response
            return response()->json([
                'success' => true,
                'ai_response' => $aiResponse['analysis']
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating AI analysis:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false, 
                'message' => 'Error generating analysis: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAnalysis(Request $request)
    {
        try {
            $deviceAnalysis = session('device_analysis');
            $totalConsumption = session('total_consumption');
            $totalCost = session('total_cost');
            $aiAnalysis = session('ai_analysis');

            if (!$deviceAnalysis || !$aiAnalysis) {
                return response()->json([
                    'success' => false,
                    'message' => 'No analysis data found in session. Please submit data first.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'device_analysis' => $deviceAnalysis,
                'total_consumption' => round($totalConsumption, 2),
                'total_cost' => round($totalCost, 2),
                'ai_response' => $aiAnalysis
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting analysis from session: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error retrieving analysis: ' . $e->getMessage()], 500);
        }
    }

    private function getTariffRate($installedPowerVA, $besarListrik = '')
    {
        switch (intval($installedPowerVA)) {
            case 450:
                return 415.0; // R-1/TR bersubsidi
            case 900:
                // Check if it's subsidized or non-subsidized
                if (strpos($besarListrik, 'bersubsidi') !== false) {
                    return 605.0; // R-1/TR bersubsidi
                }
                return 1352.0; // R-1/TR Rumah Tangga Mampu / non-subsidi
            case 1300:
            case 2200:
                return 1444.70; // R-1/TR
            case 3500:
            case 4400:
            case 5500:
                return 1699.53; // R-2/TR
            case 6600:
            case 7700:
            case 9000:
            case 10600:
            case 13200:
            case 16500:
            case 22000:
                return 1699.53; // R-3/TR
            default:
                return 1444.70; // Default to R-1/TR rate
        }
    }
} 