@extends('backend.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Detail Transaksional #{{ $order->id }}</h4>
                    <a href="{{ route('transaksional.index') }}" class="btn btn-secondary btn-sm ms-auto">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="w-40">Unit Layanan</th>
                                    <td>{{ $order->unitLayanan->unit_layanan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>User Pemesan</th>
                                    <td>{{ $order->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Order</th>
                                    <td>{{ \Carbon\Carbon::parse($order->tgl_order)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jam Order</th>
                                    <td>{{ $order->jam_order }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pesanan</th>
                                    <td>
                                        @php
                                            $badge = ['warning' => 'Menunggu', 'primary' => 'diproses', 'success' => 'selesai'];
                                        @endphp
                                        <span class="badge bg-{{ array_keys($badge)[$order->status] ?? 'secondary' }}">
                                            {{ $badge[array_keys($badge)[$order->status]] ?? 'Tidak diketahui' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- ­­­­­­­­­­­­­­­­­­­­­­­­­ DAFTAR OBAT --}}
                    <h5 class="mb-3">
                        <strong>Rincian Obat</strong>
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Obat</th>
                                    <th class="text-center">Jumlah Order</th>
                                    <th class="text-center">Stok Setelah Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->details as $i => $detail)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $detail->obat->nama_obat ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->jumlah_obat }}</td>
                                        <td class="text-center">
                                            {{-- hitung stok tersisa (jika ingin ditampilkan) --}}
                                            {{ ($detail->obat->stok ?? 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
