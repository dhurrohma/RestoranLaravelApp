<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu Makanan | Edit</title>

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
            <h1 class="m-0">Edit Menu</h1>
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
                    <form action="{{ route('update-menu', $menu->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <select class="form-control select2" style="width: 100%" name="kios_id" id="kios_id">
                                        <option value="{{ $menu->kios_id }}">{{ $menu->kios->kios }}</option>
                                        @foreach ($kios as $item)
                                        @if ($item->id !== $menu->kios_id)
                                            <option value="{{ $item->id }}">{{ $item->kios }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Nama Menu</label>
                                    <input type="text" id="nama_menu" name="nama_menu" class="form-control" placeholder="Masukkan nama menu" value="{{ $menu->nama_menu }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Jenis</label>
                                    <input type="text" id="jenis" name="jenis" class="form-control" placeholder="Masukkan nama menu" value="{{ $menu->jenis }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Harga</label>
                                    <input type="number" id="harga" name="harga" class="form-control" placeholder="Masukkan harga" value="{{ $hargaFormat }}" onkeyup="formatPrice(this)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Deskripsi</label>
                                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi" value="{{ $menu->deskripsi }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Gambar</label><br />
                                @if($gambar)
                                <img src="{{ asset('Image/' . $gambar->gambar) }}" width="50%">
                                @else
                                <p>Tidak ada gambar</p>
                                @endif
                                <br />
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-group-default">
                                    <label>Ubah Gambar</label>
                                    <br/>
                                    <input type="file" id="gambar" name="gambar">
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="form-group form-group-default">
                                <button type="submit" class="btn btn-success">Perbarui</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('data-menu') }}'">Batal</button>
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

<!-- ... (your existing HTML code) ... -->

</body>
</html>

<script>
  function formatPrice(input) {
    // Hapus semua karakter selain angka
    const rawValue = input.value.replace(/[^0-9]/g, '');

    // Format dengan menambahkan titik setiap ribuan
    const formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);

    // Setel nilai input dengan format yang sudah diformat
    input.value = formattedValue;
  }
</script>

@include('Template.script')
@include('sweetalert::alert')
</body>
</html>


