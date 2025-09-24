@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6">
        <ul class="inline-flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 rounded bg-gray-300 text-gray-500 cursor-not-allowed">&laquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 rounded bg-primary text-white hover:bg-accent2">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-1 rounded bg-gray-300 text-gray-500">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-1 rounded bg-accent2 text-primary font-bold border-2 border-black">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="px-3 py-1 rounded bg-primary text-white hover:bg-accent2 border-2 border-black">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 rounded bg-primary text-white hover:bg-accent2">&raquo;</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 rounded bg-gray-300 text-gray-500 cursor-not-allowed">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif