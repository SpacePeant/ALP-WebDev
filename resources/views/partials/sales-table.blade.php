@if(count($sales) > 0)
<table class="table table-bordered">
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
            <td>{{ $row->date }}</td>
            <td>{{ $row->quantity }}</td>
            <td>Rp{{ number_format($row->price, 0, ',', '.') }}</td>
            <td>Rp{{ number_format($row->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="text-muted">Tidak ada data dalam rentang tanggal tersebut.</p>
@endif
