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

        /* CSS untuk tombol "Cetak" */
        .btn-cetak {
            background-color: maroon; /* Warna latar belakang merah maroon */
            color: white; /* Warna teks putih */
            padding: 10px 20px; /* Padding tombol */
            border: none; /* Tidak ada garis batas */
            text-decoration: none; /* Tidak ada dekorasi teks (misalnya underline) */
            cursor: pointer; /* Mengubah ikon kursor saat mengarahkan ke tombol */
        }

        /* CSS untuk tombol "Riwayat Transaksi" */
        .btn-riwayat {
            background-color: darkblue; /* Warna latar belakang biru gelap */
            color: white; /* Warna teks putih */
            padding: 10px 20px; /* Padding tombol */
            border: none; /* Tidak ada garis batas */
            text-decoration: none; /* Tidak ada dekorasi teks (misalnya underline) */
            cursor: pointer; /* Mengubah ikon kursor saat mengarahkan ke tombol */
        }

    </style>
    <title>Invoice</title>
</head>

<body>
    @include('Transaction.Invoice')
    
    <br />
    <a href="{{ route('invoice', ['transactionId' => $transaction->id]) }}"><button class="btn-cetak">Cetak</button></a>
    
    <a href="{{ route('order-history') }}"><button class="btn-riwayat">Riwayat Transaksi</button></a>
</body>
</html>