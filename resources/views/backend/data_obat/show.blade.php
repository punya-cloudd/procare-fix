@extends('backend.app')

@section('title', 'Detail Data Obat')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Detail Data Obat</h4>
                        <a href="{{ route('data_obat.index') }}" class="btn text-white shadow-sm px-4 py-2"
                            style="background: linear-gradient(to right, #667eea, #764ba2); border: none; font-weight: 500;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Tabel Detail Data Obat -->
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Nama Obat</th>
                                            <td>{{ $obat->nama_obat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Obat</th>
                                            <td>{{ $obat->jenis_obat == 1 ? 'Injeksi' : 'Oral' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok</th>
                                            <td>{{ $obat->stok }}</td>
                                        </tr>
                                        <tr>
                                            <th>Satuan</th>
                                            <td>{{ $obat->satuan->nama_satuan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gudang</th>
                                            <td>{{ $obat->gudang->nama_gudang ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Kadaluarsa</th>
                                            <td>{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>BPOM</th>
                                            <td>{{ $obat->bpom ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Gambar Obat</th>
                                            <td>
                                                @if ($obat->gambar_obat)
                                                    <img src="{{ asset('images/' . $obat->gambar_obat) }}" alt="Gambar Obat" width="100%">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>{{ $obat->keterangan ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-start mt-3">
                            <button type="button" class="btn shadow-sm px-4 py-2 text-white" data-bs-toggle="modal" data-bs-target="#updateStokModal"
                                style="background: linear-gradient(to right, #36d1dc, #5b86e5); border: none; font-weight: 500;">
                                <i class="fas fa-sync-alt me-2"></i>Update Stok Obat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel History -->
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="card-title">Histori Obat {{ $obat->nama_obat }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-head-bg-info">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Unit Layanan</th>
                                {{-- <th>Tanggal Masuk</th> --}}
                                <th>Tanggal</th>
                                <th>Jumlah Awal</th>
                                <th>Jumlah Pesan</th>
                                <th>Sisa Stok</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($obat->histories->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada riwayat perubahan stok.</td>
                                </tr>
                            @else
                                @foreach ($obat->histories as $index => $history)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $history->order->unitLayanan->unit_layanan ?? '-' }}</td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($history->tanggal_masuk)->format('d-m-Y') ?? '-' }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($history->tanggal_keluar)->format('d-m-Y') ?? '-' }}</td>
                                        <td>{{ $history->jumlah_awal }}</td>
                                        <td>{{ $history->jumlah_baru }}</td>
                                        <td>{{ $history->jumlah_akhir }}</td>
                                        <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Stok -->
<div class="modal fade" id="updateStokModal" tabindex="-1" aria-labelledby="updateStokLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('update.stok.obat', $obat->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStokLabel">Update Stok Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tambahan_stok" class="form-label">Jumlah Tambahan Stok</label>
                        <input type="number" class="form-control" id="tambahan_stok" name="tambahan_stok" value="" required min="1" placeholder="Masukkan jumlah tambahan...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary shadow-sm px-4 py-2" style="background: linear-gradient(to right, #4facfe, #00f2fe); border: none;">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <button type="button" class="btn btn-danger shadow-sm px-4 py-2" data-bs-dismiss="modal" style="background: linear-gradient(to right, #f85032, #e73827); border: none;">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
