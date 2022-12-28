@if ($paginator->hasPages())
    <nav class="pagination" role="pagination" aria-label="pagination">
        {{-- Previous Page Link --}}
        <a
            href="{{ $paginator->previousPageUrl() }}"
            class="pagination--previous button"
            rel="prev"
            aria-label="@lang('pagination.previous')"
            @if ($paginator->onFirstPage()) disabled @endif
        >Previous</a>

        {{-- Next Page Link --}}
        <a
            href="{{ $paginator->nextPageUrl() }}"
            class="pagination--next button"
            rel="next"
            aria-label="@lang('pagination.next')"
            @if(!$paginator->hasMorePages()) disabled @endif
        >Next page</a>

        @if(isset($elements))
            <ul class="pagination--list">
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li aria-current="page">
                                    <span class="pagination--link active button" aria-label="Page {{ $page }}" aria-current="page" disabled>
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li><a href="{{ $url }}" class="pagination--link button">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        @endif
    </nav>
@endif
