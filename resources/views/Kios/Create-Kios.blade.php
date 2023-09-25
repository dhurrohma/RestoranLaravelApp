<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kios | Insert</title>

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
            <h1 class="m-0">Tambah Kios</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            <div>
                <div class="card card-info card-outline">
                    <div class="card-body">
                        <form action="{{ route('save-kios') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama Kios</label>
                                        <input type="text" id="kios" name="kios" class="form-control" placeholder="Masukkan nama kios">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                        <label>Alamat</label>
                                        <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Masukkan alamat kios">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                        <label>Owner</label>
                                        <input type="text" id="nama_pemilik" name="nama_pemilik" class="form-control" placeholder="Masukkan nama pemilik kios">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                        <label>Nomor Telpon</label>
                                        <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="Masukkan nomor telpon kios">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-group-default">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('kios') }}'">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
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


@include('Template.script')
@include('sweetalert::alert')
</body>
</html>

