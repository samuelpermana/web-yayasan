@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 20px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled style="opacity: 0.5; cursor: not-allowed;">
                ‹ Previous
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <button type="button">‹ Previous</button>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0 8px; color: #718096; font-weight: 600;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button disabled style="background: linear-gradient(135deg, #667eea, #764ba2); opacity: 1; cursor: default;">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}">
                            <button type="button" class="secondary" style="background: rgba(255, 255, 255, 0.9); color: #4a5568; border: 2px solid #e2e8f0;">
                                {{ $page }}
                            </button>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                <button type="button">Next ›</button>
            </a>
        @else
            <button disabled style="opacity: 0.5; cursor: not-allowed;">
                Next ›
            </button>
        @endif
    </div>
@endif
