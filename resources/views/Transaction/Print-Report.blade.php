<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        table.static {
            position: relative;
            border: 1px solid #543535;
        }
    </style>
    <title>Transaction Report</title>
</head>
<body>
    <div class="form-group">
        <p align="center"><b>Laporan Transaksi</b></p>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%;">
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Nama Kios</th>
                <th>Pesanan</th>
                <th>Harga Total</th>
                <th>Status</th>
            </tr>

            @php
                $noUrut = 1;
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
            </tr>
            @endforeach
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //Filter Tanggal
            const startDateTimeInput = document.getElementById('start_datetime');
            const endDateTimeInput = document.getElementById('end_datetime');

            const selectedStartDate = "{{ $startDateInput }}";
            const selectedEndDate = "{{ $endDateInput }}";

            if (selectedStartDate) {
                startDateTimeInput.value = selectedStartDate;
            }

            if (selectedEndDate) {
                endDateTimeInput.value = selectedEndDate;
            }
        })
    </script>
    
</body>
</html>