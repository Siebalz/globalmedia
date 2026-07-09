<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Tampilkan halaman dashboard setelah user login
        return view('dashboard');
    }
}
