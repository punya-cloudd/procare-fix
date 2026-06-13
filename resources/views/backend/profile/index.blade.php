@extends('backend.app')

@section('title', 'Edit Data User')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Data User</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3 d-flex align-items-stretch">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Foto Profil</label>
                                        <input type="file" name="foto" class="form-control">
                                        @if($user->foto)
                                            <img src="{{ asset('storage/'.$user->foto) }}" width="100" class="mt-2 rounded">
                                        @endif
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Password Baru</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
 