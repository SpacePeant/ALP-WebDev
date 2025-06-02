@if ($products->count())
    <div>
        <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries</p>
    </div>
@endif

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