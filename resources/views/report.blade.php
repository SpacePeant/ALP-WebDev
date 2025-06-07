<!DOCTYPE html>
<html>
<head>
    <style>
        @font-face {
            font-family: 'Red Hat Text';
            font-style: normal;
            font-weight: 400;
            src: url('{{ public_path('fonts/RedHatText-Regular.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Playfair Display';
            font-style: normal;
            font-weight: 700;
            src: url('{{ public_path('fonts/PlayfairDisplay-Bold.ttf') }}') format('truetype');
        }

        body {
            font-family: 'Red Hat Text', sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-bottom: 10px;
            margin-top: -30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        thead tr {
            background-color: #eee;
            border-top: 1px solid #999;
            border-bottom: 1px solid #999;
        }

        tbody tr {
            border-bottom: 1px solid #ccc;
        }

        .logo {
            height: 30px;
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="p-6">
<div class="container mx-auto px-4">
    <header class="flex justify-between items-center mb-6">
        <img src="{{ public_path('image/logo2.png') }}" alt="Logo" class="h-8" style="height: 30px;">
    </header>

    <div class="text-center report-title mb-4">
        <h1 class="text-3xl font-semibold mb-1">Sales Report</h1>
        <p class="text-sm">
            @if($month && $year)
                {{ \Carbon\Carbon::create()->month((int)$month)->format('F') }} {{ $year }}
            @elseif($month)
                Month: {{ \Carbon\Carbon::create()->month((int)$month)->format('F') }}
            @elseif($year)
                Year: {{ $year }}
            @endif
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700 border-t border-b border-gray-400">
                    <th class="px-3 py-2">Customer Name</th>
                    <th class="px-3 py-2">Product Name</th>
                    <th class="px-3 py-2">Color</th>
                    <th class="px-3 py-2">Size</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Quantity</th>
                    <th class="px-3 py-2">Price</th>
                    <th class="px-3 py-2">Total</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($sales as $row)
                    <tr class="hover:bg-gray-50 border-b border-gray-300">
                        <td class="px-3 py-2">{{ $row->customer_name }}</td>
                        <td class="px-3 py-2">{{ $row->product_name }}</td>
                        <td class="px-3 py-2">{{ $row->color }}</td>
                        <td class="px-3 py-2">{{ $row->size }}</td>
                        <td class="px-3 py-2">
                            {{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}
                        </td>
                        <td class="px-3 py-2">{{ $row->quantity }}</td>
                        <td class="px-3 py-2">Rp{{ number_format($row->price, 0, ',', '.') }}</td>
                        <td class="px-3 py-2">Rp{{ number_format($row->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>