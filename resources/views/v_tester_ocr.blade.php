<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAGA</title>

    <link href="{{ asset('assets/dist/img/siaga-logo.png') }}" rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    @include('flash-message')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="javascript:void(0)" class="h1"><b>SIAGA</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Form Login untuk Warga RW 007</p>

                <form action="{{ url('/loginWarga') }}" method="post">
                    @csrf
                    {{-- {{dump($lihat)}} --}}
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $key => $item)
            @if (strlen($lihat[$key]) != 0) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[0], strpos($lihat[0], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item)
                            {{ dump($item) }} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[1], strpos($lihat[1], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[2], strpos($lihat[2], ' ', 0) + 9) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[3], strpos($lihat[3], ' ', 0) + 11, 10) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[4], strpos($lihat[4], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[5], strpos($lihat[5], ' ', 0) + 3, 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[6], strpos($lihat[6], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[7], strpos($lihat[7], ' ', 0) + 5) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[9], strpos($lihat[9], ' ', 0) + 20) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[10], strpos($lihat[10], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        {{-- @foreach ($lihat as $item) --}}
                        {{-- {{dump($item)}} --}}
                        <input type="text" name="foto" class="form-control" placeholder="NIK"
                            value="{{ substr($lihat[11], strpos($lihat[11], ' ', 0) + 3) }}" required>
                        {{-- @endforeach --}}
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="text-center">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <small class="text-danger">{{ $error }}</small>
                        @endforeach
                    @endif
                </div>
                <br>
                <div class="text-center">
                    <p class="mb-1">
                        <a href="{{ url('/') }}" class="text-center">Beranda</a>
                    </p>
                    <p class="mb-1">
                        <a href="{{ route('forgot.password.form') }}">Lupa Password ?</a>
                    </p>
                    <p class="mb-1">
                        <a href="{{ url('viewRegister') }}" class="text-center">Belum punya Akun ?</a>
                    </p>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
