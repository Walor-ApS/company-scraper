<nav class="flex justify-center mt-4">
    {{-- Previous Page Link --}}
    <a href="{{ $pages->previousPageUrl() }}"
        class="px-6 py-1 mr-2 bg-blueOpacity text-blue hover:opacity-50 transition-opacity rounded-md {{ $pages->onFirstPage() == true ? 'opacity-25' : '' }}">
        Previous</a>

    {{-- Pagination Elements --}}
    @for ($i = max(1, $pages->currentPage() - 1); $i <= min($pages->lastPage(), $pages->currentPage() + 3); $i++)
        <a href="{{ $pages->url($i) }}"
            class="px-2 py-1 hover:opacity-50 transition rounded mx-1 cursor-pointer {{ $i == $pages->currentPage() ? 'bg-blueOpacity text-blue' : 'hover:bg-blueOpacity' }}">{{ $i }}
        </a>
    @endfor

    {{-- Last page --}}
    @if ($pages->currentPage() + 3 < $pages->lastPage())
        <a href="{{ $pages->url($pages->lastPage()) }}"
            class="px-2 py-1 hover:opacity-50 transition rounded mx-1 cursor-pointer hover:bg-blueOpacity">{{ $pages->lastPage() }}
        </a>
    @endif

    {{-- Next Page Link --}}
    <a href="{{ $pages->nextPageUrl() }}"
        class="px-6 py-1 ml-2 bg-blueOpacity text-blue hover:opacity-50 transition-opacity rounded-md {{ $pages->hasMorePages() == false ? 'opacity-25' : '' }}">
        Next</a>
</nav>
