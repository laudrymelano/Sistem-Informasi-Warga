
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIAGA | Forgot Password </title>

  <link href="{{ asset('assets/dist/img/siaga-logo.png')}}" rel="icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Forgot Password</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masukkan Email Anda yang terdaftar pada aplikasi</p>
      <form action="{{route('forgot.password.link')}}" method="post">
          @if(Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail')}}
            </div>
          @endif
          @if(Session::get('success'))
          <div class="alert alert-success">
              {{ Session::get('success')}}
          </div>
        @endif
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" value="{{old('email')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span class="text-danger">@error('email'){{$message}}@enderror</span>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="text-center">
          <p class="mt-3 mb-1">
            <a href="{{url('/viewLoginAdmin')}}">Login</a>
          </p>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
