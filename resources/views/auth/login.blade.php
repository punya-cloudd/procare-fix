<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kedaton Medical Center</title>
    <link rel="stylesheet" type="text/css" href="{{ url('auth/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('auth/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('auth/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('auth/iofrm-theme41.css') }}">
    <link rel="icon" href="{{ url('backend/assets/img/kaiadmin/logo_tambah.png') }}" type="image/x-icon" />
</head>
<body>
    <div class="form-body form-left">
        <div class="iofrm-layout">
            <div class="img-holder" style="background-color: #00b9b9;">
                <div class=""></div>
                <div class="info-holder">
                    <img src="{{ url('auth/img/graphic14.svg') }}" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="website-logo-inside logo-normal">
                            <a href="index.html">
                                <div class="logo">
                                    <img class="logo-size" src="images/logo-salpink.svg" alt="">
                                </div>
                            </a>
                        </div>

                        <h3 class="font-md">
                            <strong>KEDATON MEDICAL CENTER</strong>
                        </h3>
                        <p>Sign Into Your Account.</p>

                        @if($errors->any())
                            <p style="color:red">{{ $errors->first() }}</p>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input class="form-control mb-3" type="email" name="email" placeholder="E-mail Address" required>
                            <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

                            <div class="form-button d-flex">
                                <button id="submit" type="submit" class="btn" 
                                        style="background-color: #00b9b9; color: white; font-weight: bold; width: 100%;">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="other-links mt-3">
                            <span>Lupa Password? Tanya <strong>Admin</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/popper.min.js') }}"></script>
<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('js/main.js') }}"></script>
</body>
</html>
