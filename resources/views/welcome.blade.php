<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UPT PUSKESMAS SUKABUMI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ url('backend/assets/img/kaiadmin/logo_tambah.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
</head>

<body>
    <div class="header-top d-flex justify-content-between flex-wrap">
        <div class="mb-2 mb-md-0">
            <i class="bi bi-clock"></i> SENIN - SABTU, 08.00 WIB s.d 14.00 WIB
        </div>
        <div>
            <i class="bi bi-telephone-fill"></i> No. Kontak: (0266) 6253204
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ url('backend/assets/img/kaiadmin/logo_tambah.png') }}" alt="navbar brand" class="me-2" style="height: 50px;">
            <span class="fw-bold text-dark">UPT PUSKESMAS SUKABUMI</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item me-3">
                <a href="#sambutan" class="nav-link fw-mediumi">Kata Sambutan</a>
                </li>
                <li class="nav-item me-3">
                <a href="#tentang-kami" class="nav-link fw-mediumi">tentang kami</a>
                </li>
                <li class="nav-item me-3">
                <a href="#pelayanan" class="nav-link fw-mediumi">pelayanan</a>
                </li>
                <li class="nav-item me-3">
                <a href="#galeri" class="nav-link fw-mediumi">galeri</a>
                </li>
                <li class="nav-item me-lg-3 mb-2 mb-lg-0">
                <a href="/login" class="btn fw-bold py-2 px-4" style="background-color: #00b9b9; color: white; border: none;">
                    Login
                </a>
                </li>
                <li class="nav-item">
                <a class="btn fw-bold py-2 px-3" style="background-color: #00b9b9; color: white; border: none;" href="#" data-bs-toggle="modal" data-bs-target="#qrModal" onclick="generateQRCode()">Kode QR</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="slider-container">
            <div class="slider">
                <img src="{{ url('backend/assets/img/examples/puskes2.jpg') }}" alt="Slide 1" class="slide active">
                <img src="{{ url('backend/assets/img/examples/slide.png') }}" alt="Slide 2" class="slide">
                <img src="{{ url('backend/assets/img/examples/puskes1.jpg') }}" alt="Slide 3" class="slide">
            </div>
            <section class="hero-section">
                <div class="hero-box">
                    <h1>Selamat Datang di UPT Puskesmas Sukabumi</h1>
                    <p>"Melayani dengan Penuh Keikhlasan"</p>
                </div>
            </section>
        </div>
    </main>

<!-- Sambutan Pimpinan -->
<section class="container my-5 px-3" id="sambutan">
<h3 class="text-center mb-4 fw-bold" data-aos="fade-up">Sambutan Pimpinan UPT Puskesmas Sukabumi</h3>
<div class="mx-auto mb-4" style="width: 60px; height: 4px; background-color: #00b9b9;"></div>
<div class="row justify-content-center">
    <div class="col-md-3 text-center mb-4 mb-md-0" data-aos="fade-right">
    <img src="https://www.eventfulnigeria.com/wp-content/uploads/2021/04/Avatar-PNG-Free-Download.png" alt="Foto Pimpinan" class="img-fluid rounded" style="max-width: 200px;">
    <h5 class="mt-3 mb-0 fw-bold">Dr.Syarifa Nur</h5>
    <p class="text-muted">Kepala Puskesmas</p>
    </div>
    <div class="col-md-8" data-aos="fade-left">
    <div class="card p-4 shadow-sm">
        <p>Assalamu'alaikum warahmatullahi wabarakatuh.</p>
        <p>Salam sejahtera bagi kita semua,
        Yang saya hormati, para tamu undangan,
        Yang saya banggakan, seluruh tenaga kesehatan serta masyarakat yang hadir pada hari ini.</p>
        <p>Puji syukur kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, kita dapat berkumpul dalam keadaan sehat walafiat pada acara yang penuh makna ini.</p>
        <p>Atas nama Puskesmas sukabumi, saya mengucapkan terima kasih dan apresiasi setinggi-tingginya kepada seluruh pihak yang telah mendukung kegiatan ini. Kami menyadari bahwa pelayanan kesehatan yang optimal hanya dapat terwujud melalui kerja sama yang baik antara tenaga kesehatan, pemerintah, dan seluruh lapisan masyarakat.</p>
        <p>Wassalamu'alaikum warahmatullahi wabarakatuh.</p>
    </div>
    </div>
</div>
</section>

<!-- Tentang Kami -->
<section class="container my-5 px-3" id="tentang-kami">
<h2 class="text-center fw-bold mb-4" data-aos="fade-up">TENTANG KAMI</h2>
<div class="mx-auto mb-4" style="width: 60px; height: 4px; background-color: #00b9b9;" data-aos="fade-up"></div>
<div class="row align-items-center">
    <div class="col-md-12 mb-4 mb-md-0" data-aos="fade-right">
    <video id="introVideo" class="w-100 rounded shadow-sm" controls playsinline>
        <source src="{{ url('video/video_intro.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung video.
    </video>
    </div>
    <div class="col-md-12" data-aos="fade-left">
    <p>

    </p>
    <p class="text-center mb-10">Puskesmas sukabumi menyelenggarakan upaya kesehatan masyarakat dan upaya kesehatan perseorangan tingkat pertama.
    Kami memiliki tujuan mengutamakan upaya promotif dan preventif.
    Berkoordinasi dengan lintas sektoral untuk meningkatkan pelayanan kesehatan.
    Memberikan pelayanan kesehatan dasar seperti pemeriksaan umum, imunisasi, pengobatan, dan konsultasi.</p>
    </div>
</div>
</section>

<!-- Bagian Pelayanan -->
<section class="pelayanan-section py-5" id="pelayanan">
<div class="container">
<div class="section-header text-center mb-5" data-aos="fade-up">
    <h2 class="fw-bold">PELAYANAN KAMI</h2>
    <div class="divider mx-auto"></div>
    <p class="text-secondary mt-3">Puskesmas Sukabumi menyediakan berbagai layanan kesehatan dasar yang berkualitas untuk masyarakat</p>
</div>

<div class="row g-4 justify-content-center">
    <!-- UGD Service -->
    <div class="col-md-6 col-lg-3" data-aos="fade-up">
    <div class="service-card">
        <div class="icon-wrapper bg-red-soft">
        <i class="bi bi-heart-pulse"></i>
        </div>
        <h5>Unit Gawat Darurat</h5>
        <p>Pelayanan darurat 24 jam untuk kasus medis yang membutuhkan penanganan segera dan cepat.</p>
        <a href="#" class="service-link">
        Detail Layanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    </div>

    <!-- Gigi Service -->
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
    <div class="service-card">
        <div class="icon-wrapper bg-blue-soft">
        <i class="fas fa-tooth"></i>
        </div>
        <h5>Gigi dan Mulut</h5>
        <p>Pemeriksaan, perawatan, dan konsultasi kesehatan gigi oleh dokter gigi profesional.</p>
        <a href="#" class="service-link">
        Detail Layanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    </div>

    <!-- Persalinan Service -->
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
    <div class="service-card">
        <div class="icon-wrapper bg-green-soft">
        <i class="bi bi-bag-heart"></i>
        </div>
        <h5>Persalinan</h5>
        <p>Pelayanan persalinan normal oleh bidan terlatih dengan fasilitas yang aman dan nyaman.</p>
        <a href="#" class="service-link">
        Detail Layanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    </div>

    <!-- Rawat Inap Service -->
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
    <div class="service-card">
        <div class="icon-wrapper bg-purple-soft">
        <i class="bi bi-hospital"></i>
        </div>
        <h5>Rawat Inap</h5>
        <p>Fasilitas rawat inap dengan monitoring ketat oleh tenaga medis profesional.</p>
        <a href="#" class="service-link">
        Detail Layanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    </div>

    <!-- Additional Services -->
    <div class="col-12 text-center mt-4" data-aos="fade-up">
    <button class="btn pelayanan-more-btn">
        Lihat Semua Layanan <i class="bi bi-plus-circle ms-2"></i>
    </button>
    </div>
</div>
</div>
</section>

<!-- Gallery Section -->
<section class="container my-5 px-3" id="galeri">
<h2 class="text-center fw-bold">GALERI</h2>
<div class="mx-auto mb-4" style="width: 60px; height: 4px; background-color: #00b9b9;" data-aos="fade-up"></div>
<p class="text-center mb-4">Dokumentasi kegiatan dan fasilitas UPT Puskesmas Sukabumi</p>

<!-- Gallery Filter Buttons -->
<div class="text-center mb-4" data-aos="fade-up">
<div class="btn-group" role="group">
    <button type="button" class="btn active filter-btn" data-filter="all" style="background-color: #00b9b9; color: white;">Semua</button>
    <button type="button" class="btn filter-btn" data-filter="kegiatan" style="color: #004d4d;">Kegiatan</button>
    <button type="button" class="btn filter-btn" data-filter="fasilitas" style="color: #004d4d;">Fasilitas</button>
    <button type="button" class="btn filter-btn" data-filter="staff" style="color: #004d4d;">Staff</button>
</div>
</div>

<!-- Gallery Images -->
<div class="row g-3 gallery-container">
<!-- Kegiatan -->
<div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="kegiatan" data-aos="zoom-in">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/gambar-vaksin.jpg') }}" class="card-img-top" alt="Kegiatan Vaksinasi">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Kegiatan Vaksinasi 2025</p>
    </div>
    </div>
</div>

<div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="kegiatan" data-aos="zoom-in" data-aos-delay="100">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/penyuluhan.jpg') }}" class="card-img-top" alt="Penyuluhan Kesehatan">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Penyuluhan Kesehatan Masyarakat</p>
    </div>
    </div>
</div>
<!-- Fasilitas -->
<div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="fasilitas" data-aos="zoom-in" data-aos-delay="200">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/resepsionis.webp') }}" class="card-img-top" alt="Ruang Resepsionis">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Ruang Resepsionis</p>
    </div>
    </div>
</div>

<div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="fasilitas" data-aos="zoom-in" data-aos-delay="300">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/fasilitas.jpg') }}" class="card-img-top" alt="Peralatan Medis">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Fasilitas Peralatan Medis</p>
    </div>
    </div>
</div>
    <!-- Staff -->
    <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="staff" data-aos="zoom-in" data-aos-delay="100">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/tim-dokter.jpg') }}" class="card-img-top" alt="Tim Dokter">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Tim Dokter Puskesmas</p>
    </div>
    </div>
</div>

<div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="staff" data-aos="zoom-in" data-aos-delay="200">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/tim-perawat.jpeg') }}" class="card-img-top" alt="Tim Perawat">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Tim Perawat Puskesmas</p>
    </div>
    </div>
</div>
    <!-- Kegiatan -->
    <div class="col-6 col-md-4 col-lg-3 gallery-item" data-category="kegiatan" data-aos="zoom-in" data-aos-delay="300">
    <div class="card h-100 border-0 shadow-sm">
    <img src="{{ url('backend/assets/img/examples/seminar.jpg') }}" class="card-img-top" alt="Seminar Kesehatan">
    <div class="card-body p-2">
        <p class="card-text small mb-0">Seminar Kesehatan Lingkungan</p>
    </div>
    </div>
</div>
<!-- View More Button -->
<div class="text-center mt-4">
<button class="btn fw-medium py-2 px-4" style="background-color: #00b9b9; color: white; border: none;" id="loadMoreBtn" data-aos="fade-up">
    Lihat Lebih Banyak <i class="bi bi-arrow-right-circle ms-1"></i>
</button>
</div>
</section>

<!-- Footer with enhanced design -->
<footer class="py-4" style="background-color: #004d4d; color: white;">
<div class="container">
<div class="row gy-4">
    <!-- Logo and description -->
    <div class="col-lg-4 col-md-6">
    <div class="d-flex align-items-center mb-3">
        <img src="{{ url('backend/assets/img/kaiadmin/logo_tambah.png') }}" alt="Puskesmas Logo" style="height: 40px;" class="me-2">
        <h5 class="mb-0 fw-bold">UPT PUSKESMAS SUKABUMI</h5>
    </div>
    <p class="small text-white-50">Melayani dengan penuh keikhlasan untuk kesehatan masyarakat yang lebih baik.</p>
    <div class="d-flex gap-3 mt-3">
        <a href="#" class="text-white-50 hover-icon"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white-50 hover-icon"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-white-50 hover-icon"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="text-white-50 hover-icon"><i class="bi bi-youtube"></i></a>
    </div>
    </div>

    <!-- Links -->
    <div class="col-lg-2 col-6">
    <h6 class="mb-3 text-white fw-bold">NAVIGASI</h6>
    <ul class="list-unstyled footer-links">
        <li><a href="#sambutan">Kata Sambutan</a></li>
        <li><a href="#tentang-kami">Tentang Kami</a></li>
        <li><a href="#pelayanan">Pelayanan</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="/login">Login</a></li>
    </ul>
    </div>
    <!-- Contact information -->
    <div class="col-lg-3 col-6">
    <h6 class="mb-3 text-white fw-bold">JAM OPERASIONAL</h6>
    <ul class="list-unstyled footer-info">
        <li><i class="bi bi-clock me-2"></i>Senin - Sabtu</li>
        <li class="ms-4">08.00 - 14.00 WIB</li>
        <li><i class="bi bi-calendar-x me-2"></i>Minggu Libur</li>
        <li class="ms-4">Tutup</li>
    </ul>
    </div>

    <!-- Address and contact -->
    <div class="col-lg-3 col-md-6">
    <h6 class="mb-3 text-white fw-bold">KONTAK</h6>
    <ul class="list-unstyled footer-info">
        <li><i class="bi bi-geo-alt me-2"></i>Jl. Kesehatan No. 123, Sukabumi</li>
        <li><i class="bi bi-telephone me-2"></i>(0266) 6253204</li>
        <li><i class="bi bi-envelope me-2"></i>info@puskesmassukabumi.co.id</li>
    </ul>
    </div>
</div>
        <hr class="my-3 opacity-25">
        <div class="row footer-bottom">
            <div class="col-md-6 text-center text-md-start">
                <p class="small mb-0">&copy; 2025 UPT PUSKESMAS SUKABUMI</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small mb-0">Developed by MICRODATAINDONESIA</p>
            </div>
        </div>
    </div>
</footer>

<!-- Modal QR Code -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
        <h5 class="modal-title mb-3" id="qrModalLabel">Scan QR Code</h5>

        <!-- WRAPPER untuk centering -->
        <div class="d-flex justify-content-center mb-3">
            <img src="{{ url($qrcode->qr_code_path ?? '') }}" alt="QR Code" class="img-fluid">
        </div>

        <div class="row">
            <div class="col-6">
            @if(isset($qrcode) && isset($qrcode->id))
        <a href="{{ route('download.qrcode', $qrcode->id) }}" class="btn btn-success mt-2 w-100">Download QR</a>
    @else
        <button class="btn btn-secondary mt-2 w-100" disabled>QR belum tersedia</button>
    @endif
            </div>
            <div class="col-6">
            <button type="button" class="btn btn-secondary mt-2 w-100" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ url('backend/assets/js/welcome.js') }}"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        disable: window.innerWidth < 768 // Disable AOS on mobile for better performance
    });

    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }, 4000);
</script>
</body>
</html>
