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
    <title>PRINT MENU</title>
</head>
<body>
    <div class="form-group">
        <p align="center"><b>Daftar Menu</b></p>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%;">
            <tr>
                <th>No</th>
                <th>Kios</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Deskripsi</th>
            </tr>

            @php
                $noUrut = 1;
            @endphp
            @foreach($dtPrintMenu as $item)
            <tr>
                <td>{{ $noUrut++ }}</td>
                <td>{{ $item->kios->kios }}</td>
                <td>{{ $item->nama_menu }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->harga }}</td>
                <td>{{ $item->deskripsi }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>