<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Testimoni;

class LandingController extends Controller
{
    public function index()
    {
        $testimoniList = Testimoni::latest()->take(3)->get();
        return view('pages.landing', compact('testimoniList'));
    }
}
