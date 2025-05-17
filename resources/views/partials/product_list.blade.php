<div class="product-grid">
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
        <p>Tidak ada produk tersedia.</p>
    @endforelse
</div>