<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
        // Set PHP timeout to 60 seconds
        set_time_limit(60);
    }

    public function login(Request $request)
    {
        Log::info('Login attempt', ['request' => $request->all()]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => 10,
                'connect_timeout' => 5,
                'http_errors' => false
            ]);

            $response = $client->post($this->apiBaseUrl . '/api/auth/login', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            Log::info('Login API response', [
                'status' => $statusCode,
                'body' => $body
            ]);

            if ($statusCode === 200 && isset($body['token'])) {
                $token = $body['token'];
                $userId = $body['user_id'] ?? null;
                $email = $body['email'] ?? $request->email;

                // Store user data in session
                session([
                    'user' => [
                        'id' => $userId,
                        'email' => $email,
                        'token' => $token
                    ]
                ]);

                // Set remember me cookie if requested
                if ($request->has('remember')) {
                    Cookie::queue('remember_token', $token, 60 * 24 * 30); // 30 days
                }

                return redirect()->intended('/dashboard');
            }

            Log::warning('Login failed', [
                'status' => $statusCode,
                'body' => $body
            ]);

            return back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput($request->except('password'));
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('API Connection error', [
                'message' => $e->getMessage(),
                'url' => $this->apiBaseUrl . '/api/auth/login'
            ]);

            return back()->withErrors([
                'email' => 'Unable to connect to the server. Please check if the API server is running.',
            ])->withInput($request->except('password'));
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('API Request error', [
                'message' => $e->getMessage(),
                'url' => $this->apiBaseUrl . '/api/auth/login'
            ]);

            return back()->withErrors([
                'email' => 'Server error. Please try again later.',
            ])->withInput($request->except('password'));
        } catch (\Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors([
                'email' => 'An unexpected error occurred. Please try again.',
            ])->withInput($request->except('password'));
        }
    }
}