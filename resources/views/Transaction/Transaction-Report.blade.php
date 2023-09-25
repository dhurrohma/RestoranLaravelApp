<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Transaction Report</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
            <h1 class="m-0">Transaction Report</h1>
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
                <a href="{{ route('print-report', ['status' => $selectedStatus, 'start_datetime' => $startDateInput, 'end_datetime' => $endDateInput, 'user' => $userInput, 'menu' => $menuInput, 'min_price' => $minPriceInput, 'max_price' => $maxPriceInput]) }}" target="_blank"><button>Print</button></a>
            </div>
        </div>

        <form action="{{ route('trans-report') }}" method="get">
          <div class="form-group">
            <div class="col-sm-10">
              <label for="status">Status Pesanan</label>
              <select name="status" id="status" class="form-control">
                <option value="">All Status</option>
                @foreach($statuslist as $status)
                  <option value="{{ $status->id }}" {{ $selectedStatus == $status->id ? 'selected' : '' }}>
                    {{ $status->status }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <label for="start_datetime">Tanggal Transaksi Awal</label>
              <br/>
              <input type="datetime-local" id="start_datetime" name="start_datetime">
              <p id="start-date-error" style="color: red;"></p>
            </div>
            <div class="col-sm-6">
              <label for="end_datetime">Tanggal Transaksi Akhir</label>
              <br/>
              <input type="datetime-local" id="end_datetime" name="end_datetime">
              <p id="end-date-error" style="color: red;"></p>
            </div>
          </div>

          @if ($userRoles->contains(1))
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
          @endif

          <div class="row">
          <div class="col-sm-6">
            <label for="user">Nama Pelanggan</label>
            <br/>
            <input type="text" id="user" name="user" value="{{ $userInput }}" placeholder="Nama pelanggan">
          </div>
          <div class="col-sm-6">
            <label for="menu">Menu yang dipesan</label>
            <br/>
            <input type="text" id="menu" name="menu" value="{{ $menuInput }}" placeholder="Nama menu">
          </div>
          </div>
          <br/>

          <div class="row">
          <div class="col-sm-6">
            <label for="min_price">Total Harga Minimal</label>
            <br/>
            <input type="number" id="min_price" name="min_price" value="{{ $minPriceInput }}" onkeyup="formatPrice(this)" placeholder="Total harga minimum">
          </div>
          <div class="col-sm-6">
            <label for="max_price">Total Harga Maksimal</label>
            <br/>
            <input type="number" id="max_price" name="max_price" value="{{ $maxPriceInput }}" onkeyup="formatPrice(this)" placeholder="Total harga maksimum">
          </div>
          </div>
          
          <br/>
          <div class="form-group form-group-default">
            <br?>
            <button type="submit" class="btn btn-primary" id="filter-button">Filter Pesanan</button>
          </div>
        </form>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Kios</th>
                        <th>Pesanan</th>
                        <th>Harga Total</th>
                        <th>Status</th>
                        <th>Invoice</th>
                        <th>Aksi</th>
                    </tr>
                    @php
                        $noUrut = ($transaction->currentPage() - 1) * $transaction->perPage() + 1;
                    @endphp
                    @foreach($transaction as $item)
                    <tr>
                        <td>{{ $noUrut++ }}</td>
                        <td>{{ $item->trans_date }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->kios->kios }}</td>
                        <td>
                          <ul>
                            @foreach($item->transactionDetail as $detail)
                              <li>{{ $detail->menu->nama_menu }} | {{ $detail->quantity }}</li>
                            @endforeach
                          </ul>
                        </td>
                        <td>{{ number_format($item->total_price, 0, ',', '.') }}</td>
                        <td>{{ $item->status->status }}</td>
                        <td>
                          <a href="{{ route('invoice', ['transactionId' => $item->id]) }}" >Cetak</a>
                        </td>
                        <td>
                            @if ($item->status_id == 1)
                              <button class="btn btn-primary btn-accept" data-transaction="{{ $item->id }}">Accept</button>
                              <button class="btn btn-danger btn-reject" data-transaction="{{ $item->id }}">Reject</button>
                            @elseif ($item->status_id == 2)
                              <button class="btn btn-success btn-done" data-transaction="{{ $item->id }}">Done</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                <br/>
                <div class="row">
                    {{ $transaction->links() }}
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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


<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    //Filter Tanggal
    const startDateTimeInput = document.getElementById('start_datetime');
    const endDateTimeInput = document.getElementById('end_datetime');
    const startDateError = document.getElementById('start-date-error');
    const endDateError = document.getElementById('end-date-error');
    const filterButton = document.getElementById('filter-button');

    const selectedStartDate = "{{ $startDateInput }}";
    const selectedEndDate = "{{ $endDateInput }}";

    if (selectedStartDate) {
      startDateTimeInput.value = selectedStartDate;
    }

    if (selectedEndDate) {
      endDateTimeInput.value = selectedEndDate;
    }

    startDateTimeInput.addEventListener('change', function() {
      if (endDateTimeInput.value !== '' && startDateTimeInput.value > endDateTimeInput.value) {
        startDateError.textContent = 'Tanggal transaksi awal tidak boleh lebih dari tanggal transaksi akhir';
        filterButton.setAttribute('disabled', 'true');
      } else {
        startDateError.textContent = '';
        filterButton.removeAttribute('disabled');
      }
    });

    endDateTimeInput.addEventListener('change', function() {
      if (startDateTimeInput.value !== '' && endDateTimeInput.value < startDateTimeInput.value) {
        endDateError.textContent = 'Tanggal transaksi akhir tidak boleh kurang dari tanggal transaksi awal';
        filterButton.setAttribute('disabled', 'true');
      } else {
        endDateError.textContent = '';
        filterButton.removeAttribute('disabled');
      }
    });

    //Setting Button
    const acceptButtons = document.querySelectorAll('.btn-accept');
    const rejectButtons = document.querySelectorAll('.btn-reject');
    const doneButtons = document.querySelectorAll('.btn-done');

    acceptButtons.forEach(button => {
      button.addEventListener('click', function() {
        const transactionId = button.getAttribute('data-transaction');
        updateStatus(transactionId, 2, 'Sedang dibuat restoran');
      });
    });

    rejectButtons.forEach(button => {
      button.addEventListener('click', function() {
        const transactionId = button.getAttribute('data-transaction');
        updateStatus(transactionId, 4, 'Pesanan ditolak');
      });
    });

    doneButtons.forEach(button => {
      button.addEventListener('click', function() {
        const transactionId = button.getAttribute('data-transaction');
        updateStatus(transactionId, 3, 'Pesanan telah selesai');
      });
    });

    function updateStatus(transactionId, newStatusId, statusText) {
      axios.post('/update-status', { transactionId, newStatusId })
        .then(response => {
          if (response.data.success) {
            Toastify({
              text: `Success : ${statusText}`,
              duration: 5000,
              close: true,
              gravity: 'bottom',
              backgroundColor: 'green',
              stopOnFocus: true,
            }).showToast();

            location.reload();
          } else {
            Toastify({
              text: 'Failed',
              duration: 3000,
              close: true,
              gravity: 'bottom',
              backgroundColor: 'red',
              stopOnFocus: true,
            }).showToast();
          }
        })
        .catch(error => {
          console.error(error);
        });
    }
  });
</script>

@include('Template.script')
@include('sweetalert::alert')

</body>
</html>

