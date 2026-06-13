<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ url('backend/assets/img/kaiadmin/LogoKmc1.png') }}" alt="navbar brand" class="navbar-brand"
                    height="48" />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Route::currentRouteName() == 'backend.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('backend.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @can('menu-data-master')
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Data Master</h4>
                </li>
                @endcan

                {{-- @can('satuan-obat-list')
                <li class="nav-item {{ Route::currentRouteName() == 'm_satuan_obat' ? 'active' : '' }}">
                    <a href="{{ route('m_satuan_obat') }}">
                        <i class="fas fa-dot-circle"></i>
                        <p>Satuan Obat</p>
                    </a>
                </li>
                @endcan --}}

                {{-- @can('unit-layanan-list')
                <li class="nav-item {{ Route::currentRouteName() == 'unit_layanan.index' ? 'active' : '' }}">
                    <a href="{{ route('unit_layanan.index') }}">
                        <i class="fas fa-dot-circle"></i>
                        <p>Data Unit Layanan</p>
                    </a>
                </li>
                @endcan --}}

                {{-- @can('gudang-list')
                <li class="nav-item {{ Route::currentRouteName() == 'gudang.index' ? 'active' : '' }}">
                    <a href="{{ route('gudang.index') }}">
                        <i class="fas fa-dot-circle"></i>
                        <p>Data Gudang</p>
                    </a>
                </li>
                @endcan --}}

                @can('peserta-list')
                <li class="nav-item {{ Route::currentRouteName() == 'peserta.index' ? 'active' : '' }}">
                    <a href="{{ route('peserta.index') }}">
                        <i class="fas fa-dot-circle"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                @endcan

                {{-- @can('obat-list')
                <li class="nav-item {{ Route::currentRouteName() == 'data_obat.index' ? 'active' : '' }}">
                    <a href="{{ route('data_obat.index') }}" class="nav-link">
                        <i class="fas fa-pills"></i>
                        <p>Data Obat</p>
                    </a>
                </li>
                @endcan --}}

                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Transaksional</h4>
                </li> --}}

                {{-- @can('transaksi-list')
                <li class="nav-item {{ Route::currentRouteName() == 'transaksional.index' ? 'active' : '' }}">
                    <a href="{{ route('transaksional.index') }}">
                        <i class="fab fa-get-pocket"></i>
                        <p>Data Transaksi</p>
                    </a>
                </li>
                @endcan --}}

                {{-- @can('history-transaksi-view')
                    <li class="nav-item {{ Route::currentRouteName() == 'histori.transaksional.index' ? 'active' : '' }}">
                        <a href="{{ route('histori.transaksional.index') }}">
                            <i class="fas fa-history"></i>
                            <p>History Transaksi</p>
                        </a>
                    </li>
                @endcan --}}

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Lain-lain</h4>
                </li>

                {{-- @can('role-list')
                <li class="nav-item {{ Route::currentRouteName() == 'qrCode.index' ? 'active' : '' }}">
                    <a href="{{ route('qrCode.index') }}">
                        <i class="fas fa-qrcode"></i>
                        <p>Qr Code</p>
                    </a>
                </li>
                @endcan --}}

                @can('user-list')
                    <li class="nav-item {{ Route::currentRouteName() == 'user.index' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">
                            <i class="fas fa-user-friends"></i>
                            <p>Data Pengguna</p>
                        </a>
                    </li>
                @endcan

                @can('role-list')
                <li class="nav-item {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i>
                        <p>Role & Permission</p>
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="logout-btn">
                        <i class="fas fa-lock-open"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->