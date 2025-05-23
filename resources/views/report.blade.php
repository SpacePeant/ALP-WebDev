<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h4 {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h4>
        Laporan Penjualan 
        @if($month)
            Bulan {{ \Carbon\Carbon::create()->month((int)$month)->format('F') }}
        @endif
        Tahun {{ $year }}
    </h4>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Color</th>
                <th>Size</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $row)
                <tr>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ $row->product_name }}</td>
                    <td>{{ $row->color }}</td>
                    <td>{{ $row->size }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>Rp{{ number_format($row->price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($row->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
