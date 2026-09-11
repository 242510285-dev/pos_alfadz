<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TentangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('tentang.index', compact('user'));
    }
}