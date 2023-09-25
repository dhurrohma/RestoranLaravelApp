<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gambar</title>

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
            <h1 class="m-0">Gambar</h1>
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
                <a href="{{ route('create-gambar') }}"><button>Tambah Gambar</button></a>
            </div>
        </div>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Id Menu</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                    @php
                        $noUrut = ($dtGambar->currentPage() - 1) * $dtGambar->perPage() + 1;
                    @endphp
                    @foreach($dtGambar as $item)
                    <tr>
                        <td>{{ $noUrut++ }}</td>
                        <td>{{ $item->id_menu }}</td>
                        <td>
                            <img src="{{ asset('Image/' . $item->gambar) }}" alt="Gambar" width="100">
                        </td>
                        <td>
                            <a href="{{ route('edit-gambar', $item->id) }}"><button class="btn btn-primary btn-sm">Edit</button></a> 
                                | 
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">Delete</button>

                        </td>
                    </tr>
                    @endforeach
                </table>
                <br/>
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

<script type="text/javascript">
    function confirmDelete(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus Menu',
            text: 'Apakah Anda yakin ingin menghapus menu ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus Menu',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/delete-gambar') }}/" + id;
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@include('Template.script')
@include('sweetalert::alert')

</body>
</html>

