<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonials = Testimoni::latest()->get();
        return view('pages.testimoni', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'peran'   => 'nullable|string|max:100',
            'pesan'   => 'required|string|max:1000',
            'bintang' => 'required|integer|min:1|max:5',
        ]);

        Testimoni::create([
            'nama'    => $request->nama,
            'peran'   => $request->peran ?? 'Pengguna Atamagri',
            'pesan'   => $request->pesan,
            'bintang' => $request->bintang,
        ]);

        return back()->with('success', 'Testimoni berhasil dikirim! Terima kasih 🌾');
    }
}
