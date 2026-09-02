<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = \App\Models\Buku::all();
        return view('index', compact('buku'));
    }
}
