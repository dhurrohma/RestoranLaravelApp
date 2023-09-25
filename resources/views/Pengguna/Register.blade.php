<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restoran | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Register</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Insert your data for register</p>

      <form action="{{ route('register-user')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-sm-6">
            <div class="form-group form-group-default">
                <label>Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama anda">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-group-default">
                <label>Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan email anda">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-group-default">
                <label>Password</label>
                <input type="text" id="password" name="password" class="form-control" placeholder="Masukkan password">
            </div>
        </div>
        <div class="form-group form-group-default">
            <button type="submit" class="btn btn-primary">Register</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('login') }}'">Cancel</button>
        </div>
      </form>

      
  </div>
</div>
<!-- /.login-box -->

@include('Template.script')
@include('sweetalert::alert')

</body>
</html>
