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
                    <div class="product-card-wrapper position-relative">
                        <div class="product-card"
                            style="--bg-color: {{ $product->color_code_bg }}; --font-color: {{ $product->color_font }};">
                            <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}"
                                alt="{{ $product->product_name }}">
                            <h3>{{ $product->product_name }}</h3>
                            <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</div>

<div id="paginationWrapper" class="pagination-wrapper mt-4">
    {{-- Show Entries --}}
    <div class="d-flex align-items-center mb-2">
        <label for="entries" class="me-2 mb-0">Show</label>
        <select id="entries" name="entries" class="form-select form-select-sm w-auto"
                onchange="changeEntries(this.value)">
            <option value="8" {{ request('entries') == 8 ? 'selected' : '' }}>8</option>
            <option value="16" {{ request('entries') == 16 ? 'selected' : '' }}>16</option>
            <option value="32" {{ request('entries') == 32 ? 'selected' : '' }}>32</option>
        </select>
        <span class="ms-2">entries</span>
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
        <nav>
            <ul class="pagination pagination-sm mb-0">
                {{-- Prev --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Prev</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}">Prev</a>
                    </li>
                @endif

                @php
                    $current = $products->currentPage();
                    $last = $products->lastPage();
                @endphp

                @if ($last <= 5)
                    @for ($i = 1; $i <= $last; $i++)
                        <li class="page-item {{ $current == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                @else
                    @if ($current <= 3)
                        @for ($i = 1; $i <= 4; $i++)
                            <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item">
                            <a class="page-link" href="{{ $products->url($last) }}">{{ $last }}</a>
                        </li>
                    @elseif ($current > 3 && $current < $last - 2)
                        <li class="page-item"><a class="page-link" href="{{ $products->url(1) }}">1</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @for ($i = $current - 1; $i <= $current + 1; $i++)
                            <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item"><a class="page-link" href="{{ $products->url($last) }}">{{ $last }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $products->url(1) }}">1</a></li>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @for ($i = $last - 3; $i <= $last; $i++)
                            <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    @endif
                @endif

                {{-- Next --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    @endif
</div>

<script>
    function changeEntries(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('entries', value);
        url.searchParams.set('page', 1); // reset ke halaman 1 pas entries berubah
        window.location.href = url.toString();
    }
</script>
