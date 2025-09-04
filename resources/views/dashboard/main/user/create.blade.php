@extends('dashboard.index')

@section('content')

<section class="roles-section" id="create-user">
    <div class="roles-header">
        <h1>Tambah User</h1>
        <a href="/showuser" class="back-button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Kembali
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-create">
        <form action="{{ route('create.user') }}" method="POST" class="form-container">
            @csrf

            <div class="form-group">
                <label for="id_card" class="form-label">ID Card:</label>
                <input type="text" name="id_card" id="id_card" class="form-control" placeholder="Masukkan ID Card" required>
            </div>

            <div class="form-group">
                <label for="jabatan" class="form-label">Jabatan:</label>
                <input type="text" name="jabatan" class="form-control" placeholder="Masukkan Jabatan" required>
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi Password" required>
            </div>

            <div class="button-group">
                <button class="primary-button" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</section>
@endsection