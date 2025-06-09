<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function index()
    {
        return view('dashboard');
    }

    public function getRecentCalculations()
    {
        try {
            // Get user from session
            $user = session('user');
            if (!$user || !isset($user['token'])) {
                Log::error('Dashboard: No auth token found in session');
                return response()->json([
                    'error' => 'Authentication required. Please login again.'
                ], 401);
            }

            Log::info('Dashboard: Starting getRecentCalculations request');
            Log::info('Dashboard: API Base URL: ' . $this->apiBaseUrl);

            $client = new Client([
                'timeout' => 5,
                'connect_timeout' => 5,
                'verify' => false
            ]);

            $response = $client->get($this->apiBaseUrl . '/api/recent-calculations', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                Log::info('Dashboard: Successfully fetched recent calculations', ['count' => count($data)]);
                return response()->json($data);
            } else {
                $errorMessage = sprintf('Failed to fetch data from API. Status: %d, Response: %s', 
                    $response->getStatusCode(), 
                    $response->getBody()->getContents()
                );
                Log::error('Dashboard: API response error', ['error' => $errorMessage]);
                return response()->json([
                    'error' => 'Failed to fetch dashboard data. Please try again later.'
                ], $response->getStatusCode());
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('Dashboard: Connection to API failed', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Failed to connect to energy API. Please ensure the backend server is running.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Dashboard: Unexpected error fetching recent calculations', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
} 