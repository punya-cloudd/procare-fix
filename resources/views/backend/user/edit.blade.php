@extends('backend.app')
@section('title', 'Edit Data User')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Data User</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('user.update', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-3 d-flex align-items-stretch">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Username</label>
                                            <input type="text" name="username" class="form-control"
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Password <small>(Biarkan kosong jika tidak
                                                    ingin mengubah)</small></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Role</label>
                                            <select class="form-control select2-with-bg" id="bg-multiple" multiple
                                                name="roles[]">

                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}"
                                                        {{ in_array($role, $userRole) ? 'selected' : '' }}>

                                                        {{ $role }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>
                                        <div class="mb-3" id="peserta-group" style="display:none;">
                                            <label class="form-label fw-bold">Peserta</label>

                                            <select name="peserta_id" class="form-control">
                                                <option value="">-- Pilih Peserta --</option>

                                                @foreach ($pesertas as $peserta)
                                                    <option value="{{ $peserta->id }}"
                                                        {{ old('peserta_id', $user->peserta_id) == $peserta->id ? 'selected' : '' }}>

                                                        {{ $peserta->no_rm }} - {{ $peserta->nama }}

                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Peran</label>
                                            <select name="unit_layanan_id" class="form-control" required>
                                                <option value="">Pilih Unit Layanan</option>
                                                @foreach ($jenisLayanans as $layanan)
                                                    <option value="{{ $layanan->id }}"
                                                        {{ old('unit_layanan_id', $user->unit_layanan_id) == $layanan->id ? 'selected' : '' }}>
                                                        {{ $layanan->unit_layanan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Foto</label>
                                            <input type="file" name="foto" class="form-control">
                                            @if ($user->foto)
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">Foto Saat Ini:</small>
                                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="User Photo"
                                                        width="100" class="rounded">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2-with-bg').select2({
            width: '100%'
        });

        function cekRole() {
            let role = $('#bg-multiple').val();

            if (role && role.includes('Pasien')) {
                $('#peserta-group').show();
            } else {
                $('#peserta-group').hide();
                $('select[name="peserta_id"]').val('');
            }
        }

        $('#bg-multiple').on('change', function() {
            cekRole();
        });

        cekRole();
    </script>
@endsection
