<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.index', compact('user'));
    }

    public function cuaca()
    {
        $user = Auth::user();
        return view('dashboard.cuaca', compact('user'));
    }

    public function rekomendasi()
    {
        $user = Auth::user();
        return view('dashboard.rekomendasi', compact('user'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('dashboard.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name     = $request->name;
        $user->phone    = $request->phone;
        $user->location = $request->location;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
