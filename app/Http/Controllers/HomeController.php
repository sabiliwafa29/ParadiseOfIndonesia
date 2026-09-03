<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TravelService;

class HomeController extends Controller
{
    public function index()
    {
        $travelServices = TravelService::latest()->get();

        return view('home', compact('travelServices'));
    }
}