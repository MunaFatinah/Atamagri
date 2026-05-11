@extends('layouts.dashboard')
@section('title', 'Profil Saya')

@section('extra-styles')
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:500;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input{width:100%;padding:.7rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;outline:none;transition:border-color .2s;}
.form-group input:focus{border-color:var(--green-light);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.status-badge{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .75rem;border-radius:100px;font-size:.78rem;font-weight:600;}
.status-badge.aktif{background:var(--green-pale);color:var(--green-mid);}
@endsection

@section('sidebar-menu')
<div class="sidebar-section">Menu</div>
<a class="sidebar-item" href="{{ route('dashboard.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.cuaca') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91l-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91l1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z"/></svg>
  <span>Cuaca</span>
</a>
<a class="sidebar-item" href="{{ route('dashboard.rekomendasi') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 0 0 8 20c9 0 14-8 14-8-1 2-4 5-5 5-3 0-3-2.5-5-2.5S9 17 6 17c1-3 4-8 11-9z"/></svg>
  <span>Rekomendasi</span>
</a>
<a class="sidebar-item active" href="{{ route('dashboard.profil') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
  <span>Profil Saya</span>
</a>
@endsection

@section('content')
<div class="main-header">
  <div><h1>Profil Saya</h1><p>Kelola informasi akun Anda.</p></div>
</div>
<div class="main-body">
  @if($errors->any())
  <div style="background:#ffebee;color:#c62828;border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.9rem;">{{ $errors->first() }}</div>
  @endif

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
 
    <div class="card">
      <div class="card-header"><h3>Informasi Pribadi</h3></div>
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--gray-200);">
          <div style="width:64px;height:64px;background:var(--green-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.4rem;color:var(--green-dark);flex-shrink:0;">{{ $user->initials }}</div>
          <div>
            <div style="font-weight:700;font-size:1.1rem;color:var(--green-dark);">{{ $user->name }}</div>
            <div style="font-size:.85rem;color:var(--gray-500);">{{ $user->email }}</div>
            <span class="status-badge aktif">● Aktif</span>
          </div>
        </div>
        <div style="display:grid;gap:.75rem;">
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">No. HP</span><span style="font-size:.85rem;font-weight:500;">{{ $user->phone ?: '-' }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Lokasi</span><span style="font-size:.85rem;font-weight:500;">{{ $user->location ?: '-' }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Bergabung</span><span style="font-size:.85rem;font-weight:500;">{{ $user->created_at->format('d M Y') }}</span></div>
          <div style="display:flex;justify-content:space-between;"><span style="font-size:.85rem;color:var(--gray-500);">Role</span><span style="font-size:.85rem;font-weight:500;">{{ ucfirst($user->role) }}</span></div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>Edit Profil</h3></div>
      <div class="card-body">
        <form method="POST" action="{{ route('dashboard.profil.update') }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required/>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>No. HP</label>
              <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxx"/>
            </div>
            <div class="form-group">
              <label>Kota/Lokasi</label>
              <input type="text" name="location" value="{{ old('location', $user->location) }}" placeholder="Surakarta"/>
            </div>
          </div>
          <div style="border-top:1px solid var(--gray-200);padding-top:1.25rem;margin-top:.5rem;">
            <div style="font-size:.85rem;font-weight:600;color:var(--green-dark);margin-bottom:1rem;">Ganti Password <span style="color:var(--gray-500);font-weight:400;">(opsional)</span></div>
            <div class="form-group">
              <label>Password Baru</label>
              <input type="password" name="password" placeholder="Minimal 8 karakter"/>
            </div>
            <div class="form-group">
              <label>Konfirmasi Password</label>
              <input type="password" name="password_confirmation" placeholder="Ulangi password baru"/>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
