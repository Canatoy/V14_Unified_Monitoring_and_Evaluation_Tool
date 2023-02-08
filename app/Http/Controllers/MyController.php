<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MyController extends Controller
{
    public function index()
    {
        return view('filament.login');
    }
}
