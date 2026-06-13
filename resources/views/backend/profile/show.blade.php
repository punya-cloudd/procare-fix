@extends('backend.app')

@section('title', 'Detail Data User')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title">Detail Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 d-flex align-items-stretch">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama</label>
                                    <div>{{ $user->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <div>{{ $user->email }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Username</label>
                                    <div>{{ $user->username }}</div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal Bergabung</label>
                                    <div>{{ $user->created_at->format('d M Y') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Foto Profil</label><br>
                                    <img 
                                        src="{{ $user->foto ? asset('storage/' . $user->foto) : url('backend/assets/img/ccep.jpg') }}" 
                                        class="rounded shadow-sm" 
                                        width="100" 
                                        alt="Foto Profil">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('backend.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
