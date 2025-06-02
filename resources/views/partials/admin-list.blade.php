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