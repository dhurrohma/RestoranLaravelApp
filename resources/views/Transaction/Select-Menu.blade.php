<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Buat Pesanan | Pilih Menu</title>

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
            <h1 class="m-0">{{ $kios->kios }}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="card card-info card-outline">
        <div class="card-header">
            <label>Silakan pilih menu</label>
        </div>
        
        <form id="form-pesanan" action="{{ route('simpan-pesanan') }}" method="POST"> 
            
            <div class="card-body">
                @csrf
                <input type="hidden" name="kios_id" value="{{ $kios->id }}">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Pesanan</th>
                    </tr>
                    @php
                        $noUrut = 1;
                    @endphp
                    @foreach($menus as $item)
                    <tr>
                        <td>{{ $noUrut++ }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>
                          @if ($item->gambar)
                          <img src="{{ asset('Image/' . $item->gambar->gambar) }}" alt="Gambar" width="100">
                          @endif
                        </td>
                        <td>{{ $item->nama_menu }}</td>
                        <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->deskripsi }}</td>                       
                        <td>
                            <input type="number" name="quantity[]" id="quantity[]" min="0" class="menu-quantity" >
                            <input type="hidden" name="menu_id[]" value="{{ $item->id }}">
                        </td>
                    </tr> 
                    @endforeach
                </table>
                <br/>
                <div id="quantity-summary">
                    <div>Total Quantity : <span id="total-quantity">0</span></div>
                    <strong>Total Price : <span id="total-harga">0</span></strong>
                </div>
                <br/>
                <button type="button" class="btn btn-success" id="btn-confirm">Buat Pesanan</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('select-kios') }}'">Batal</button>
            </div>
        </form>   
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

<!-- ... (your existing HTML code) ... -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all elements with class "menu-quantity"
    var quantityInputs = document.querySelectorAll(".menu-quantity");

    // Set the initial value of each input to 0
    quantityInputs.forEach(function(input) {
        input.value = 0;
    });

    // Update the total quantity when any input changes
    quantityInputs.forEach(function(input) {
        input.addEventListener("input", updateTotalQuantity);
    });

    // Function to update the total quantity
    function updateTotalQuantity() {
        var totalQuantity = 0;
        var totalHarga = 0;
        quantityInputs.forEach(function(input) {
            var quantity = parseInt(input.value) || 0;
            var hargaText = input.closest("tr").querySelector("td:nth-child(5)").textContent.replace('.', '');
            var harga = parseInt(hargaText);
            totalQuantity += quantity;
            hargaItem = quantity * harga;
            totalHarga += hargaItem;
        });
        document.getElementById("total-quantity").textContent = totalQuantity;
        document.getElementById("total-harga").textContent = totalHarga.toLocaleString('id-ID');
    }

    // Menambahkan event listener untuk tombol "Buat Pesanan"
    document.getElementById("btn-confirm").addEventListener("click", function() {
        // Mendapatkan data yang akan ditampilkan dalam konfirmasi
        var kiosName = "{{ $kios->kios }}";
        var selectedMenus = [];
        var totalHarga = 0;
        quantityInputs.forEach(function(input) {
            var quantity = parseInt(input.value) || 0;
            if (quantity > 0) {
                var menuName = input.closest("tr").querySelector("td:nth-child(4)").textContent;
                var hargaText = input.closest("tr").querySelector("td:nth-child(5)").textContent.replace('.', '');
                var harga = parseInt(hargaText);
                var totalHargaItem = quantity * harga;
                totalHarga += totalHargaItem;
                selectedMenus.push({
                    menuName: menuName,
                    quantity: quantity,
                    totalHarga: totalHarga
                });
            }
        });

        // Membuat teks konfirmasi berdasarkan data yang dikumpulkan
        var konfirmasiText = "Konfirmasi Pesanan"
        var text = "<p>Nama Kios: " + kiosName + "</p><br/>" +
            "<p>Menu yang Dipilih:</p>";
        selectedMenus.forEach(function(menu) {
            text += "<p>- " + menu.menuName + " (" + menu.quantity + ")</p>";
        });
        text += "<br/><strong>Total Harga: " + totalHarga.toLocaleString('id-ID') + "</strong>";
        
        // Menampilkan kotak dialog konfirmasi SweetAlert
        Swal.fire({
            title: konfirmasiText,
            icon: 'question',
            html: text,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, submit formulir
                document.getElementById("form-pesanan").submit();
            }
        });
    });
});
</script>

</body>
</html>


@include('Template.script')
@include('sweetalert::alert')

</body>
</html>

