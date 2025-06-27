<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL', 'http://localhost:8082');
    }

    public function register(Request $request)
    {
        // Debug: Log incoming request
        Log::info('Registration attempt:', [
            'email' => $request->email,
            'session_id' => $request->session()->getId()
        ]);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'confirmPassword'));
        }

        $client = new Client([
            'timeout' => 5,
            'connect_timeout' => 5,
            'verify' => false
        ]);

        try {
            $response = $client->post($this->apiBaseUrl . '/api/register', [
                'json' => [
                    'fullname' => $request->fullName,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => $request->password,
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            Log::info('Register API response:', ['data' => $responseData]);

            if ($responseData['success']) {
                return redirect('/login')
                    ->with('success', 'Registration successful! Please login to continue.');
            }

            Log::warning('Registration failed:', ['message' => $responseData['message'] ?? 'Registration failed']);
            return back()
                ->withErrors(['error' => $responseData['message'] ?? 'Registration failed'])
                ->withInput($request->except('password', 'confirmPassword'));
        } catch (ConnectException $e) {
            Log::error('Backend connection error: ' . $e->getMessage());
            return back()
                ->withErrors([
                    'error' => 'Unable to connect to the backend server. Please make sure the server is running at ' . $this->apiBaseUrl
                ])
                ->withInput($request->except('password', 'confirmPassword'));
        } catch (RequestException $e) {
            Log::error('Backend request error: ' . $e->getMessage());
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody(), true);
                Log::error('Error response:', ['data' => $response]);
                
                // Handle duplicate entry errors
                if (isset($response['message']) && (
                    str_contains(strtolower($response['message']), 'duplicate') ||
                    str_contains(strtolower($response['message']), 'already exists')
                )) {
                    if (str_contains(strtolower($response['message']), 'email')) {
                        return back()
                            ->withErrors(['email' => 'This email is already registered. Please use a different email address.'])
                            ->withInput($request->except('password', 'confirmPassword'));
                    } elseif (str_contains(strtolower($response['message']), 'username')) {
                        return back()
                            ->withErrors(['username' => 'This username is already taken. Please choose a different username.'])
                            ->withInput($request->except('password', 'confirmPassword'));
                    }
                }
                
                return back()
                    ->withErrors(['error' => $response['message'] ?? 'Registration failed'])
                    ->withInput($request->except('password', 'confirmPassword'));
            }
            return back()
                ->withErrors(['error' => 'An error occurred while processing your request'])
                ->withInput($request->except('password', 'confirmPassword'));
        } catch (\Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'An unexpected error occurred. Please try again later.'])
                ->withInput($request->except('password', 'confirmPassword'));
        }
    }
} 