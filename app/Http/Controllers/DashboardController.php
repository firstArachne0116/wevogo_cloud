<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        return view('dashboard.index');
    }
}
