<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Beranda</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('Template.Navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('Template.Sidebar', ['userRoles' => $userRoles])

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Beranda</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-tools">
                
            </div>
        </div>
            
            <div class="card-body">
                <div style="text-align: center;">
                    <h4>Selamat datang di aplikasi kami</h4>
                    <p>Silakan pilih halaman yang ingin anda tuju</p>
                    <a href="{{ route('kios') }}"><button class="btn btn-primary btn-sm">Kios</button></a>
                    <a href="{{ route('data-menu') }}"><button class="btn btn-primary btn-sm">Menu</button></a> 
                    <!-- <a href="{{ route('gambar') }}"><button class="btn btn-primary btn-sm">Gambar</button></a> -->
                    <a href="{{ route('data-role') }}"><button class="btn btn-primary btn-sm">Role</button></a>
                    <a href="{{ route('data-user') }}"><button class="btn btn-primary btn-sm">User</button></a>
                </div>
            </div>
            
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    @include('Template.Footer')
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@include('Template.script')
@include('sweetalert::alert')

</body>
</html>

