@extends('layouts.dashboard')
@section('title', 'Kelola Pengguna')

@section('extra-styles')
.table-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
th{background:var(--gray-100);font-size:.78rem;font-weight:700;color:var(--gray-700);text-transform:uppercase;letter-spacing:.05em;padding:.75rem 1rem;text-align:left;}
td{padding:.9rem 1rem;border-bottom:1px solid var(--gray-200);font-size:.875rem;vertical-align:middle;}
.table-avatar{width:32px;height:32px;background:var(--green-light);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;color:var(--green-dark);margin-right:.6rem;}
.status-badge{padding:.25rem .7rem;border-radius:100px;font-size:.75rem;font-weight:600;}
.status-badge.aktif{background:var(--green-pale);color:var(--green-mid);}
.status-badge.nonaktif{background:#ffebee;color:#c62828;}
.table-toolbar{padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;border-bottom:1px solid var(--gray-200);}
.table-toolbar input,.table-toolbar select{padding:.55rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.85rem;outline:none;}
.table-toolbar input:focus,.table-toolbar select:focus{border-color:var(--green-light);}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;}
.modal-overlay.open{display:flex;}
.modal{background:var(--white);border-radius:20px;padding:2rem;width:100%;max-width:500px;margin:1rem;max-height:90vh;overflow-y:auto;}
.modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}
.modal-header h3{font-family:var(--font-display);font-size:1.4rem;font-weight:700;color:var(--green-dark);}
.modal-close{width:32px;height:32px;border-radius:50%;border:none;background:var(--gray-100);cursor:pointer;font-size:1.1rem;}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:.85rem;font-weight:500;color:var(--gray-700);margin-bottom:.5rem;}
.form-group input,.form-group select{width:100%;padding:.7rem 1rem;border-radius:var(--radius);border:1.5px solid var(--gray-200);font-family:var(--font-body);font-size:.9rem;outline:none;transition:border-color .2s;}
.form-group input:focus,.form-group select:focus{border-color:var(--green-light);}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.page-btn{padding:.35rem .7rem;border-radius:6px;border:1.5px solid var(--gray-200);background:var(--white);cursor:pointer;font-size:.8rem;}
.page-btn:hover,.page-btn.active{background:var(--green-dark);color:var(--white);border-color:var(--green-dark);}
@endsection

@section('sidebar-menu')
<div class="sidebar-section">Admin Panel</div>
<a class="sidebar-item" href="{{ route('admin.index') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
  <span>Dashboard</span>
</a>
<a class="sidebar-item active" href="{{ route('admin.users') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
  <span>Kelola Pengguna</span>
</a>
<a class="sidebar-item" href="{{ route('admin.stats') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
  <span>Statistik</span>
</a>
<a class="sidebar-item" href="{{ route('landing') }}">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H7l5-8v4h4l-5 8z"/></svg>
  <span>Lihat Website</span>
</a>
@endsection

@section('content')
<div class="main-header">
  <div><h1>Kelola Pengguna</h1><p>Manajemen akun petani terdaftar.</p></div>
  <button class="btn btn-primary" onclick="document.getElementById('add-user-modal').classList.add('open')">+ Tambah Pengguna</button>
</div>
<div class="main-body">
  <div class="card">
    <div class="table-toolbar">
      <form method="GET" style="display:flex;gap:.75rem;flex:1;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, lokasi..."/>
        <select name="status">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button class="btn btn-outline btn-sm" type="submit">Filter</button>
        @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm">Reset</a>
        @endif
      </form>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Pengguna</th><th>No. HP</th><th>Lokasi</th><th>Bergabung</th><th>Status</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
          <tr>
            <td>
              <span class="table-avatar">{{ $u->initials }}</span>
              {{ $u->name }}<br>
              <span style="font-size:.78rem;color:var(--gray-500);">{{ $u->email }}</span>
            </td>
            <td>{{ $u->phone ?: '-' }}</td>
            <td>{{ $u->location ?: '-' }}</td>
            <td>{{ $u->created_at->format('d M Y') }}</td>
            <td><span class="status-badge {{ $u->status }}">{{ ucfirst($u->status) }}</span></td>
            <td>
              <div style="display:flex;gap:.5rem;">
                <button class="btn btn-outline btn-sm" onclick="openEdit({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}', '{{ $u->phone }}', '{{ $u->location }}', '{{ $u->status }}')">Edit</button>
                <form method="POST" action="{{ route('admin.users.delete', $u) }}" onsubmit="return confirm('Hapus {{ $u->name }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;color:var(--gray-500);padding:2rem;">Tidak ada pengguna ditemukan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div style="padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
      <span style="font-size:.82rem;color:var(--gray-500);">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna</span>
      <div style="display:flex;gap:.35rem;">{{ $users->links('vendor.pagination.simple-custom') }}</div>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal-overlay" id="add-user-modal">
  <div class="modal">
    <div class="modal-header">
      <h3>Tambah Pengguna</h3>
      <button class="modal-close" onclick="document.getElementById('add-user-modal').classList.remove('open')">×</button>
    </div>
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      <div class="form-group"><label>Nama</label><input type="text" name="name" required/></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required/></div>
      <div class="form-row">
        <div class="form-group"><label>No. HP</label><input type="tel" name="phone"/></div>
        <div class="form-group"><label>Lokasi</label><input type="text" name="location"/></div>
      </div>
      <div class="form-group"><label>Password</label><input type="password" name="password" required/></div>
      <div class="form-group">
        <label>Status</label>
        <select name="status"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Tambah</button>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal-overlay" id="edit-user-modal">
  <div class="modal">
    <div class="modal-header">
      <h3>Edit Pengguna</h3>
      <button class="modal-close" onclick="document.getElementById('edit-user-modal').classList.remove('open')">×</button>
    </div>
    <form method="POST" id="edit-form" action="">
      @csrf @method('PUT')
      <div class="form-group"><label>Nama</label><input type="text" name="name" id="edit-name" required/></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" id="edit-email" required/></div>
      <div class="form-row">
        <div class="form-group"><label>No. HP</label><input type="tel" name="phone" id="edit-phone"/></div>
        <div class="form-group"><label>Lokasi</label><input type="text" name="location" id="edit-location"/></div>
      </div>
      <div class="form-group"><label>Password Baru <span style="color:var(--gray-500)">(kosongkan jika tidak diubah)</span></label><input type="password" name="password"/></div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" id="edit-status"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openEdit(id, name, email, phone, location, status) {
  document.getElementById('edit-name').value     = name;
  document.getElementById('edit-email').value    = email;
  document.getElementById('edit-phone').value    = phone;
  document.getElementById('edit-location').value = location;
  document.getElementById('edit-status').value   = status;
  document.getElementById('edit-form').action    = `/admin/users/${id}`;
  document.getElementById('edit-user-modal').classList.add('open');
}
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});
</script>
@endsection