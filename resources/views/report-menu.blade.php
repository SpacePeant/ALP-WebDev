@extends('base.baseadmin')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Red+Hat+Display:wght@400;500&display=swap" rel="stylesheet">

    <style>
        body {
        font-family: 'Red Hat Display', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        /* padding: 40px 20px; */
        color: #212529;
        margin-bottom: 50px;
        }
        .container{
            margin-top : 100px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h4>Laporan :))) EHEK</h4>

    <div class="row mb-5">
        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" id="start_date" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" id="end_date" class="form-control" required>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <a id="pdf-button"
                  href="#"
                  class="btn btn-danger d-none"
                  target="_blank">
                    <i class="fa fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>

    <div id="sales-table">
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const start = document.getElementById('start_date');
    const end = document.getElementById('end_date');

    function fetchSales() {
        if (start.value && end.value) {
            fetch(`/report/sales/data?start_date=${start.value}&end_date=${end.value}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('sales-table').innerHTML = html;
                });
        }
    }

    start.addEventListener('change', fetchSales);
    end.addEventListener('change', fetchSales);
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('start_date');
    const endInput = document.getElementById('end_date');
    const pdfButton = document.getElementById('pdf-button');

    function updatePDFButton() {
        const start = startInput.value;
        const end = endInput.value;

        if (start && end) {
            // Tampilkan tombol PDF dan set URL-nya
            pdfButton.classList.remove('d-none');
            pdfButton.href = `/report/sales/pdf?start_date=${start}&end_date=${end}`;
        } else {
            // Sembunyikan kalau salah satu belum diisi
            pdfButton.classList.add('d-none');
            pdfButton.href = "#";
        }
    }

    // Event listener untuk saat tanggal dipilih
    startInput.addEventListener('change', updatePDFButton);
    endInput.addEventListener('change', updatePDFButton);
});
</script>
</body>
</html>
@endsection