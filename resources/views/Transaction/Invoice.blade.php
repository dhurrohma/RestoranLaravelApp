<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .invoice-container {
            display: inline-block;
            border: 1px dashed #000; /* Garis batas kotak */
            padding: 20px; /* Ruang dalam kotak */
        }

        h1 {
            padding: 8px;
            text-align: center;
        }

        h3 {
        @if($transaction->status_id == 1)
            color: black; /* Status 1: Hitam */
        @elseif($transaction->status_id == 2)
            color: blue; /* Status 2: Biru */
        @elseif($transaction->status_id == 3)
            color: green; /* Status 3: Hijau */
        @elseif($transaction->status_id == 4)
            color: red; /* Status 4: Merah */
        @else
            color: black; /* Default: Hitam jika status tidak cocok */
        @endif
        text-align: right;
    }
    </style>
    <title>Invoice</title>
</head>

<body>
    <div class="invoice-container">
    <h1>Invoice</h1>
    <p>Tanggal Transaksi : {{ $transaction->trans_date }}</p>
    <p>Kios : {{ $transaction->kios->kios }}</p>
    <p>Pelanggan : {{ $transaction->user->name }}</p>
    <br />
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->transactionDetail as $detail)
            <tr>
                <td>{{ $detail->menu->nama_menu }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->menu->harga, 0, ',', '.') }}</td>
                <td>{{ number_format($detail->quantity * $detail->menu->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>-----</th>
            </tr>
            <tr>
                <th>Total Harga</th>
                <th></th>
                <th></th>
                <th>{{ number_format($transaction->total_price, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <br />
    <h3>{{ $transaction->status->status }}</h3>
    </div>
</body>
</html>