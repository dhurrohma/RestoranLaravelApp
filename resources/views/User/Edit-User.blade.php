<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User | Edit</title>

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
            <h1 class="m-0">Edit Role User</h1>
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
                    <form action="{{ route('update-user', $user->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Nama</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label for="role">Role</label>
                                    <p>Pilih minimal 1 role</p>
                                    <div class="role-checkbox-box">
                                        @foreach ($role as $role)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="role_{{ $role->id }}" name="role[]" value="{{ $role->id }}" {{ in_array($role->id, $userRole) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->role }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default" id="kiosSelect" style="display: none;">
                                    <label for="kios_id">Kios</label>
                                    <select name="kios_id" id="kios_id" class="form-control">
                                        <option value="">Pilih Kios</option>
                                        @foreach ($kiosOptions as $kios)
                                            <option value="{{ $kios->id }}">{{ $kios->kios }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="form-group form-group-default">
                                <button type="submit" class="btn btn-success">Perbarui</button>
                                <button type="button" class="btn btn-danger" onclick="window.location.href='{{ route('data-user') }}'">Batal</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Ketika halaman dimuat, cek apakah role dengan id 2 dicentang
        checkRole();

        // Event listener untuk memeriksa perubahan pada checkbox role
        $('input[name="role[]"]').on('change', function () {
            checkRole();
        });

        // Fungsi untuk menampilkan/menyembunyikan pilihan kios
        function checkRole() {
            var role2Checked = $('input[name="role[]"][value="2"]').prop('checked');

            if (role2Checked) {
                $('#kiosSelect').show();
            } else {
                $('#kiosSelect').hide();
            }
        }
    });
</script>


@include('Template.script')
@include('sweetalert::alert')
</body>
</html>


