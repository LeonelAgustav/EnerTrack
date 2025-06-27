<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class HistoryController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function index(Request $request)
    {
        // Check if user is logged in
        if (!$request->session()->has('user')) {
            return redirect('/login')->with('error', 'Please login to access history');
        }

        // Get user data from session
        $user = $request->session()->get('user');
        
        return view('history', [
            'user' => $user
        ]);
    }

    public function getCalculations(Request $request)
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

            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ]);

            // Build query parameters
            $queryParams = [];
            if ($request->has('search')) {
                $queryParams['search'] = $request->input('search');
            }
            if ($request->has('category')) {
                $queryParams['category'] = $request->input('category');
            }
            if ($request->has('page')) {
                $queryParams['page'] = $request->input('page');
            }

            // Make request to external API
            $response = $client->get($this->apiBaseUrl . '/api/devices/history', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ],
                'query' => $queryParams
            ]);

            $data = json_decode($response->getBody(), true);

            // Format the response to match frontend expectations
            $formattedCalculations = collect($data)->map(function($calc) {
                // Safely get values with defaults
                $monthlyCost = isset($calc['monthly_cost']) ? $calc['monthly_cost'] : '0';
                
                // Safely convert monthlyCost to float, removing 'Rp. ' if present.
                if (is_string($monthlyCost)) {
                    $monthlyCost = floatval(str_replace('Rp. ', '', $monthlyCost));
                } else {
                    $monthlyCost = floatval($monthlyCost);
                }

                return [
                    'id' => $calc['id'] ?? 0,
                    'date' => $calc['tanggalInput'] ?? date('Y-m-d'),
                    'appliance' => $calc['name'] ?? 'Unknown Device',
                    'model' => $calc['brand'] ?? 'Unknown Brand',
                    'category' => $calc['category'] ?? 'Other',
                    'power' => $calc['power'] ?? 0,
                    'usage_hours' => $calc['duration'] ?? 0,
                    'daily_kwh' => $calc['daily_usage'] ?? 0,
                    'monthly_kwh' => $calc['monthly_usage'] ?? 0,
                    'cost' => $monthlyCost,
                    'billing_type' => $calc['jenisPembayaran'] ?? 'Unknown',
                    'power_capacity' => $calc['besarListrik'] ?? '0 VA'
                ];
            });

            // Apply search filter
            if ($request->has('search') && !empty($request->input('search'))) {
                $searchTerm = strtolower($request->input('search'));
                $formattedCalculations = $formattedCalculations->filter(function($calc) use ($searchTerm) {
                    return str_contains(strtolower($calc['appliance']), $searchTerm) ||
                           str_contains(strtolower($calc['model']), $searchTerm) ||
                           str_contains(strtolower($calc['category']), $searchTerm);
                });
            }

            // Apply category filter
            if ($request->has('category') && !empty($request->input('category'))) {
                $category = $request->input('category');
                $formattedCalculations = $formattedCalculations->filter(function($calc) use ($category) {
                    return $calc['category'] === $category;
                });
            }

            $perPage = 5;
            $currentPage = $request->input('page', 1);

            $total = $formattedCalculations->count();
            $lastPage = ceil($total / $perPage);

            // Ensure currentPage does not exceed lastPage
            if ($currentPage > $lastPage && $lastPage > 0) {
                $currentPage = $lastPage;
            } else if ($lastPage === 0 && $currentPage > 1) { // If no data, force to page 1
                 $currentPage = 1;
            }

            // Manually paginate the collection
            $paginatedCalculations = $formattedCalculations->skip(($currentPage - 1) * $perPage)->take($perPage)->values()->all();

            // Calculate start and end entry numbers for display
            if ($total === 0) {
                $start = 0;
                $end = 0;
            } else {
                $start = ($currentPage - 1) * $perPage + 1;
                // 'end' is the lesser of (currentPage * perPage) or total
                $end = min($currentPage * $perPage, $total);
                // If on the last page, adjust 'end' to reflect the actual number of items on this page
                if ($currentPage == $lastPage && count($paginatedCalculations) < $perPage) {
                    $end = ($currentPage - 1) * $perPage + count($paginatedCalculations);
                }
            }
            

            return response()->json([
                'success' => true,
                'data' => [
                    'calculations' => $paginatedCalculations,
                    'pagination' => [
                        'total' => $total,
                        'per_page' => $perPage,
                        'current_page' => $currentPage,
                        'last_page' => $lastPage,
                        'start' => $start,
                        'end' => $end
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching device history:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching device history: ' . $e->getMessage()
            ], 500);
        }
    }
} 