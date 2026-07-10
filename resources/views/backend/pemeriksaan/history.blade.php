@extends('backend.app')
@section('title', 'Riwayat Pemeriksaan')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Riwayat Pemeriksaan Prolanis</h4>
                    <div>
                        <a href="{{ route('pemeriksaan.index') }}" class="btn text-white shadow-sm px-4 py-2"
                            style="background:linear-gradient(to right,#667eea,#764ba2);border:none;font-weight:500;">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Biodata Peserta --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">No RM</th>
                                    <td>{{ $peserta->no_rm }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <td>{{ $peserta->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>{{ $peserta->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        {{ $peserta->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>No BPJS</th>
                                    <td>{{ $peserta->no_bpjs }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">Jenis Penyakit</th>
                                    <td>{{ $peserta->jenisPenyakit->nama_penyakit ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dokter</th>
                                    <td>{{ $peserta->dokter->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $peserta->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $peserta->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Total Pemeriksaan</th>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $riwayat->count() }} Kali
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <i class="fa fa-history text-primary me-2"></i>
                            Riwayat Pemeriksaan
                        </h5>
                        <a href="{{ route('pemeriksaan.create', ['peserta_id' => $peserta->id]) }}"
                            class="btn btn-primary">
                            <i class="fa fa-plus"></i> Input Pemeriksaan Baru
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">No</th>
                                    <th>Tanggal</th>
                                    <th>Petugas</th>
                                    <th>Tekanan Darah</th>
                                    <th>Risk Score</th>
                                    <th>Level</th>
                                    <th>Dokumen</th>
                                    <th width="170">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ $item->petugas->nama ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->sistol }}/{{ $item->diastol }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $item->risk_score >= 70 ? 'danger' : ($item->risk_score >= 40 ? 'warning text-dark' : 'success') }}">
                                                {{ $item->risk_score }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $item->risk_score >= 70 ? 'danger' : ($item->risk_score >= 40 ? 'warning text-dark' : 'success') }}">
                                                {{ $item->risk_level }}
                                            </span>
                                        </td>
                                        <td class="text-center">

                                            @if ($item->dokumen)
                                                <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                                    class="btn btn-info btn-sm">

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                                <a href="{{ asset('storage/' . $item->dokumen) }}" download
                                                    class="btn btn-success btn-sm">

                                                    <i class="fas fa-download"></i>

                                                </a>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Tidak Ada
                                                </span>
                                            @endif

                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-link p-0 text-primary"type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fa fa-eye" style="font-size:18px;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('pemeriksaan.show', $item->id) }}">
                                                            <i class="fa fa-search me-2 text-primary"></i>
                                                            Detail Pemeriksaan
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            class="dropdown-item"href="{{ route('pemeriksaan.edit', $item->id) }}">
                                                            <i class="fa fa-pencil-alt me-2 text-info"></i>
                                                            Edit Pemeriksaan
                                                        </a>
                                                    </li>
                                                    {{-- <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('pemeriksaan.pdf', $item->id) }}">
                                                            <i class="fa fa-file-pdf me-2 text-danger"></i>
                                                            Export PDF
                                                        </a>
                                                    </li> --}}

                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('pemeriksaan.excel', $item->id) }}">
                                                            <i class="fa fa-file-excel me-2 text-success"></i>
                                                            Export Excel
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button"class="dropdown-item btn-delete"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-trash me-2 text-danger"></i>
                                                            Hapus Pemeriksaan
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Belum ada riwayat pemeriksaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data pemeriksaan akan dihapus permanen.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('pemeriksaan.destroy', ':id') }}".replace(':id',
                                id),
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data pemeriksaan berhasil dihapus.'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Data tidak dapat dihapus.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
