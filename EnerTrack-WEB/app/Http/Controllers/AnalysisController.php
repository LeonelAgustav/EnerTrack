<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class AnalysisController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function getDailyStatistics()
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

            // Make request to external API
            $response = $client->get($this->apiBaseUrl . '/api/statistics/daily', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Format the response to match frontend expectations
            $formattedStats = collect($data)->map(function($stat) {
                return [
                    'date' => $stat['date'],
                    'consumption' => round($stat['consumption'], 2)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedStats
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching daily statistics:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching daily statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCategoryCounts()
    {
        try {
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

            $response = $client->get($this->apiBaseUrl . '/api/category-counts', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching category counts:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching category counts: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getWeeklyCostStatistics()
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

            // Request ke endpoint backend baru
            $response = $client->get($this->apiBaseUrl . '/api/weekly-cost-statistics', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Format response jika perlu
            $formattedStats = collect($data)->map(function($stat) {
                return [
                    'week' => $stat['week'] ?? $stat['weekLabel'] ?? '',
                    'cost' => round($stat['cost'] ?? 0)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedStats
            ]);
            Log::info('Weekly cost statistics:', ['data' => $formattedStats]);

        } catch (\Exception $e) {
            Log::error('Error fetching weekly cost statistics:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error fetching weekly cost statistics: ' . $e->getMessage()
            ], 500);
        }
    }
} 