<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function dashboard(Request $request) {
        // Debug: Log session data
        Log::info('Dashboard access attempt:', [
            'session_id' => $request->session()->getId(),
            'user' => $request->session()->get('user'),
            'has_user' => $request->session()->has('user'),
            'all_session' => $request->session()->all()
        ]);

        // Check if user is logged in
        if (!$request->session()->has('user')) {
            Log::warning('Unauthorized dashboard access attempt - No user in session');
            return redirect('/login')->with('error', 'Please login to access the dashboard');
        }

        // Get user data from session
        $user = $request->session()->get('user');
        Log::info('User accessing dashboard:', ['user' => $user]);

        return view('dashboard', ['user' => $user]);
    }

    public function analysis(Request $request) {
        if (!$request->session()->has('user')) {
            return redirect('/login');
        }
        return view('analysis', ['user' => $request->session()->get('user')]);
    }

    public function calculator(Request $request) {
        if (!$request->session()->has('user')) {
            return redirect('/login');
        }
        return view('calculator', ['user' => $request->session()->get('user')]);
    }

    public function history(Request $request) {
        if (!$request->session()->has('user')) {
            return redirect('/login');
        }
        return view('history', ['user' => $request->session()->get('user')]);
    }

    public function login() {
        return view('login');
    }

    public function register() {
        return view('register');
    }

    public function profile(Request $request) {
        if (!$request->session()->has('user')) {
            return redirect('/login');
        }
        return view('profile', ['user' => $request->session()->get('user')]);
    }

    public function welcome(Request $request) {
        //first page the user sees
        return view('welcome');
    }
}
