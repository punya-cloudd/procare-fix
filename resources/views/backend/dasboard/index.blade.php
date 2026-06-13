    @extends('backend.app')
    @section('title', 'Dashboard')

    @section('content')
        <div class="container">
            <div class="page-inner">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Dashboard</h3>
                        <h6 class="op-7 mb-2">Informasi Ringkasan Sistem</h6>
                    </div>
                </div>

                <div class="row">
                    <!-- Jumlah Obat -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-capsules"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3">
                                        <div class="numbers">
                                            <p class="card-category">Jumlah Obat</p>
                                            <h4 class="card-title">{{ $jumlahObat }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Kurang -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round" data-bs-toggle="modal" data-bs-target="#stokModal"
                            style="cursor:pointer;">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-danger bubble-shadow-small">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3">
                                        <div class="numbers">
                                            <p class="card-category">Stok &lt; 5</p>
                                            <h4 class="card-title">{{ $stokKurang->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Hari Ini -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-calendar-plus"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3">
                                        <div class="numbers">
                                            <p class="card-category">Transaksi Hari Ini</p>
                                            <h4 class="card-title">{{ $transaksiHariIni }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Kemarin -->
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-round">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-calendar-minus"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3">
                                        <div class="numbers">
                                            <p class="card-category">Transaksi Kemarin</p>
                                            <h4 class="card-title">{{ $transaksiKemarin }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Obat per Unit Layanan -->
                <div class="row mt-4">
                    <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                        <div class="card-title">total obat perunit layanan</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                        <canvas
                            id="pieChart"
                            style="width: 50%; height: 50%"
                        ></canvas>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data transaksi perhari</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                        <canvas id="barChart"></canvas>
                        </div>
                    </div>
                    </div>
                </div>
                    <!-- @foreach($totalObatPerUnit as $unit)
                        <div class="col-sm-6 col-md-3 mb-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                                <i class="fas fa-pills"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3">
                                            <div class="numbers">
                                                <p class="card-category">{{ $unit->unit_layanan ?? 'Unit Tidak Diketahui' }}</p>
                                                <h4 class="card-title">{{ $unit->total_obat ?? 0 }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> -->

                <!-- Modal Stok Kurang dari 5 -->
                <div class="modal fade" id="stokModal" tabindex="-1" aria-labelledby="stokModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="stokModalLabel">Obat dengan Stok Kurang dari 5</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($stokKurang->count())
                                    <ul class="list-group">
                                        @foreach($stokKurang as $obat)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $obat->nama_obat ?? 'Nama tidak tersedia' }}
                                                <span class="badge bg-danger rounded-pill">{{ $obat->stok }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Tidak ada obat dengan stok kurang dari 5.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endsection

    @section('script')
    <script>
        var myPieChart = new Chart(pieChart, {
            type: "pie",
            data: {
    datasets: [
        {
        data: {!! json_encode($unitData) !!}, // <-- [18, 1, 0, 1]
        backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b", "#66BB6A"], // 4 warna untuk 4 data
        borderWidth: 0,
        },
    ],
    labels: {!! json_encode($unitLabels) !!} // <-- ["UGD", "Persalinan", "Rawat Inap", "Gigi dan Mulut"]
    },

            options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
                labels: {
                fontColor: "rgb(154, 154, 154)",
                fontSize: 11,
                usePointStyle: true,
                padding: 20,
                },
            },
            pieceLabel: {
                render: "percentage",
                fontColor: "white",
                fontSize: 14,
            },
            tooltips: false,
            layout: {
                padding: {
                left: 20,
                right: 20,
                top: 20,
                bottom: 20,
                },
            },
            },
        });

        var myBarChart = new Chart(barChart, {
            type: "bar",
            data: {
        labels: {!! json_encode($labelTanggal) !!}, // contoh: ['26 Apr', '27 Apr', ...]
        datasets: [{
            label: 'Jumlah Transaksi',
            data: {!! json_encode($dataJumlah) !!},     // contoh: [0, 2, 0, 4, 1, 0, 5]
            backgroundColor: '#1d7af3'
        }]
        },
            options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [
                {
                    ticks: {
                    beginAtZero: true,
                    },
                },
                ],
            },
            },
        });

    </script>
    @endsection