@if ($paginator->hasPages())

    <ul class="pagination pagination pull-right m-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled previous page-item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a href="" class="page-link">
                    <i class="ti-arrow-left"></i> Prev
                </a>
                <!-- <span aria-hidden="true">&lsaquo;</span> -->
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    aria-label="@lang('pagination.previous')">
                    <i class="ti-arrow-left"></i> Prev
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled page-item" aria-disabled="true">
                    <a href="" class="page-link">
                        <span>{{ $element }}</span>
                    </a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <a href="" class="page-link">
                                <span>{{ $page }}</span>
                            </a>
                        </li>
                    @else
                        <li><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="next page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    Next <i class="ti-arrow-right"></i>
                </a>
            </li>
        @else
            <li class="disabled next page-item" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a href="" class="page-link">
                    <span aria-hidden="true">
                        Next <i class="ti-arrow-right"></i>
                </a>
            </li>
        @endif
    </ul>
@endif
