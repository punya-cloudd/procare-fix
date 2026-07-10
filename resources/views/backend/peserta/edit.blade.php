@extends('backend.app')

@section('title', 'Edit Data Peserta')

@section('content')

    <div class="container">
        <div class="page-inner">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card shadow">

                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">

                                <h4 class="card-title mb-0">
                                    Edit Data Peserta Prolanis
                                </h4>

                                <a href="{{ route('peserta.index') }}" class="btn text-white shadow-sm px-4 py-2"
                                    style="background: linear-gradient(to right,#667eea,#764ba2); border:none;">

                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali

                                </a>

                            </div>
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

                            <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">

                                @csrf
                                @method('PUT')

                                <div class="row">

                                    {{-- No RM --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            No. Rekam Medis
                                        </label>

                                        <input type="text" class="form-control" value="{{ $peserta->no_rm }}" readonly>

                                    </div>

                                    {{-- No BPJS --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            No. BPJS
                                        </label>

                                        <input type="text" name="no_bpjs" class="form-control"
                                            value="{{ old('no_bpjs', $peserta->no_bpjs) }}">

                                    </div>

                                    {{-- NIK --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            NIK
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="nik" class="form-control"
                                            value="{{ old('nik', $peserta->nik) }}" required>

                                    </div>

                                    {{-- Nama Peserta --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Nama Peserta
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" name="nama" class="form-control"
                                            value="{{ old('nama', $peserta->nama) }}" required>

                                    </div>

                                    {{-- Jenis Kelamin --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Jenis Kelamin
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="jk" class="form-select" required>

                                            <option value="">
                                                -- Pilih Jenis Kelamin --
                                            </option>

                                            <option value="L" {{ old('jk', $peserta->jk) == 'L' ? 'selected' : '' }}>
                                                Laki-laki
                                            </option>

                                            <option value="P" {{ old('jk', $peserta->jk) == 'P' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>

                                        </select>

                                    </div>

                                    {{-- Tanggal Lahir --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Tanggal Lahir
                                        </label>

                                        <input type="date" name="tgl_lahir" class="form-control"
                                            value="{{ old('tgl_lahir', $peserta->tgl_lahir) }}">

                                    </div>
                                    {{-- No HP --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            No. HP
                                        </label>

                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp', $peserta->no_hp) }}">

                                    </div>

                                    {{-- Dokter Penanggung Jawab --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Dokter Penanggung Jawab
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="dokter_id" class="form-select" required>

                                            <option value="">
                                                -- Pilih Dokter --
                                            </option>

                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('dokter_id', $peserta->dokter_id) == $item->id ? 'selected' : '' }}>

                                                    {{ $item->nama }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    {{-- Jenis Penyakit --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Jenis Penyakit
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="jenis_penyakit_id" class="form-select" required>

                                            <option value="">
                                                -- Pilih Jenis Penyakit --
                                            </option>

                                            @foreach ($jenisPenyakit as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('jenis_penyakit_id', $peserta->jenis_penyakit_id) == $item->id ? 'selected' : '' }}>

                                                    {{ $item->nama_penyakit }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label">
                                            Status
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="status" class="form-select" required>

                                            <option value="">
                                                -- Pilih Status --
                                            </option>

                                            <option value="1"
                                                {{ old('status', $peserta->status) == 1 ? 'selected' : '' }}>
                                                Aktif
                                            </option>

                                            <option value="0"
                                                {{ old('status', $peserta->status) == 0 ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>

                                        </select>

                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-md-12 mb-3">

                                        <label class="form-label">
                                            Alamat
                                        </label>

                                        <textarea name="alamat" rows="4" class="form-control">{{ old('alamat', $peserta->alamat) }}</textarea>

                                    </div>

                                </div>
                                <div class="d-flex justify-content-end mt-4">

                                    <a href="{{ route('peserta.index') }}" class="btn btn-secondary me-2">

                                        <i class="fas fa-arrow-left me-2"></i>
                                        Kembali

                                    </a>

                                    <button type="submit" class="btn text-white"
                                        style="background: linear-gradient(to right,#36d1dc,#5b86e5); border:none;">

                                        <i class="fas fa-save me-2"></i>
                                        Update Data Peserta

                                    </button>

                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
