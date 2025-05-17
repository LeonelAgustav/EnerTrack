<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard() {
        return view('dashboard');
    }

    public function analysis() {
        return view('analysis');
    }

    public function calculator() {
        return view('calculator');
    }

    public function history() {
        return view('history');
    }
}
