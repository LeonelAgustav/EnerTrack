<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class UserController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function getUsername(Request $request)
    {
        try {
            $token = $request->bearerToken();
            
            if (!$token) {
                return response()->json([
                    'message' => 'Unauthorized - No token provided'
                ], 401);
            }

            $response = Http::withToken($token)
                ->get(config('app.api_url') . '/api/username');

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'message' => 'Failed to fetch username'
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching username',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserProfile(Request $request)
    {
        try {
            // Get user from session
            $user = session('user');
            if (!$user || !isset($user['token'])) {
                return response()->json([
                    'message' => 'Unauthorized - No token provided'
                ], 401);
            }

            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ]);

            $response = $client->get($this->apiBaseUrl . '/api/user-profile', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return response()->json(json_decode($response->getBody(), true));
            }

            return response()->json([
                'message' => 'Failed to fetch user profile'
            ], $response->getStatusCode());

        } catch (\Exception $e) {
            Log::error('Error fetching user profile:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'An error occurred while fetching user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'fullname' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            // Get user from session
            $user = session('user');
            if (!$user || !isset($user['token'])) {
                return response()->json([
                    'message' => 'Unauthorized - No token provided'
                ], 401);
            }

            $client = new Client([
                'timeout' => 10,
                'connect_timeout' => 10,
                'verify' => false
            ]);

            $response = $client->put($this->apiBaseUrl . '/api/user-profile/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $user['token']
                ],
                'json' => [
                    'fullname' => $request->fullname,
                    'username' => $request->username,
                    'email' => $request->email,
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                // Update session data if needed
                if (isset($user['username'])) {
                    $user['username'] = $request->username;
                    session(['user' => $user]);
                }

                return response()->json(json_decode($response->getBody(), true));
            }

            return response()->json([
                'message' => 'Failed to update profile'
            ], $response->getStatusCode());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating user profile:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'An error occurred while updating profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 