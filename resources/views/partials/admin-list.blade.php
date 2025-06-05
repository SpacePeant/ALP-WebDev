<div id="product-list">

<div class="product-grid mt-4">
   @forelse ($products as $product)
            <div class="product-card" onclick="showVariants({{ $product->color_id }})">
                <div class="dropdown-container custom-dropdown">
                    <button class="custom-dropdown-toggle" onclick="event.stopPropagation(); toggleDropdown(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <div class="custom-dropdown-menu">
                        <a href="{{ route('product.edit', ['id' => $product->id, 'color_id' => $product->color_id]) }}" onclick="event.stopPropagation()">Edit</a>
                        <a href="#" class="text-danger" onclick="event.stopPropagation(); confirmDelete({{ $product->color_id }})">Delete</a>
                    </div>
                </div>

                <img src="{{ asset('image/sepatu/kiri/' . $product->image_kiri) }}" class="product-img me-3" alt="{{ $product->name }}">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-color">Color: {{ $product->color_name }}</div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
  </div>
</div>

<div id="paginationWrapper" class="pagination-wrapper mt-4">
    {{-- Show Entries --}}
    <div class="d-flex align-items-center mb-2">
        <label for="entries" class="me-2 mb-0">Show</label>
        <select id="entries" name="entries" class="form-select form-select-sm w-auto"
                onchange="changeEntries(this.value)">
            <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
            <option value="40" {{ request('entries') == 40 ? 'selected' : '' }}>40</option>
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
</div>

<script>
    window.totalPages = {{ $products->lastPage() }};
</script>