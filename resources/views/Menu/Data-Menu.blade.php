<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Makanan</title>

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
            <h1 class="m-0">Menu Makanan</h1>
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
                @if ($userRoles->contains(1) || $userRoles->contains(2))
                <button onclick="window.location.href='{{ route('create-menu') }}'">Tambah Menu</button>
                @endif
                <a href="{{ route('print-menu') }}" target="_blank"><button>Print</button></a>
            </div>
        </div>

        @if ($userRoles->contains(1) || ($userRoles->count() == 1 && $userRoles->contains(4)))
        <form action="{{ route('data-menu') }}" method="get">
          <div class="form-group">
            <div class="col-sm-10">
              <label for="kios">Pilih Kios</label>
              <select name="kios" id="kios" class="form-control">
                <option value="">All Kios</option>
                @foreach($kioslist as $kios)
                  <option value="{{ $kios->id }}" {{ $selectedKios == $kios->id ? 'selected' : ''}}>
                    {{ $kios->kios }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group form-group-default">
            <button type="submit" class="btn btn-primary">Filter Menu</button>
          </div>
        </form>
        @endif   

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Kios</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        @if ($userRoles->contains(1) || $userRoles->contains(2))
                        <th>Aksi</th>
                        @endif
                    </tr>
                    @php
                        $noUrut = ($dtMenu->currentPage() - 1) * $dtMenu->perPage() + 1;
                    @endphp
                    @foreach($dtMenu as $item)
                    <tr>
                        <td>{{ $noUrut++ }}</td>
                        <td>{{ $item->kios->kios }}</td>
                        <td>{{ $item->nama_menu }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                          @if ($item->gambar)
                          <img src="{{ asset('Image/' . $item->gambar->gambar) }}" alt="Gambar" width="100">
                          @endif
                        </td>
                        @if ($userRoles->contains(1) || $userRoles->contains(2))
                        <td>
                            <a href="{{ route('edit-menu', $item->id) }}"><button class="btn btn-primary btn-sm">Edit</button></a> 
                            <br/>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">Delete</button>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </table>
                <br/>
                <div class="row">
                    {{ $dtMenu->links() }}
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
                window.location.href = "{{ url('/delete-menu') }}/" + id;
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@include('Template.script')
@include('sweetalert::alert')

</body>
</html>

