{{-- <div class="product-grid">
    @forelse ($products as $product)
        <a href="{{ url('detail_sepatu/' . $product->product_id) }}" class="product-link">
            <div class="product-card"
                style="--bg-color: {{ $product->color_code_bg }}; --font-color: {{ $product->color_font }};">
                <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}"
                     alt="{{ $product->product_name }}">
                <h3>{{ $product->product_name }}</h3>
                <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </a>
    @empty
        <p>No product available</p>
    @endforelse
</div> --}}

<div class="container">
    <div class="row">
        @forelse ($products as $product)
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                <a href="{{ url('detail_sepatu/' . $product->product_id) }}" class="product-link">
                    <div class="product-card"
                        style="--bg-color: {{ $product->color_code_bg }}; --font-color: {{ $product->color_font }};">
                        <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}"
                            alt="{{ $product->product_name }}">
                        <h3>{{ $product->product_name }}</h3>
                        <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</div>
