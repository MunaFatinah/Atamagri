<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Testimoni;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'petani')->count(),
            'aktif'          => User::where('role', 'petani')->where('status', 'aktif')->count(),
            'nonaktif'       => User::where('role', 'petani')->where('status', 'nonaktif')->count(),
            'total_testimoni'=> Testimoni::count(),
        ];
        return view('admin.index', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::where('role', 'petani');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%")
                   ->orWhere('location', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:aktif,nonaktif',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'location' => $request->location,
            'status'   => $request->status,
            'role'     => 'petani',
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
            'status'   => 'required|in:aktif,nonaktif',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'location' => $request->location,
            'status'   => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function stats()
    {
        $stats = [
            'users_by_month' => User::where('role', 'petani')
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'total'    => User::where('role', 'petani')->count(),
            'aktif'    => User::where('role', 'petani')->where('status', 'aktif')->count(),
            'nonaktif' => User::where('role', 'petani')->where('status', 'nonaktif')->count(),
        ];

        return view('admin.stats', compact('stats'));
    }
}
