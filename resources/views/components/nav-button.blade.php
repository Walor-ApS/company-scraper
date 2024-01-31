<a href="/{{ $link }}">
    <button
        class="p-3 px-4 rounded-xl w-full mb-3 {{ $currentPage == $text ? 'bg-blueOpacity' : 'bg-white' }} hover:bg-slate-200 transition">
        <div class="grid grid-cols-[20px_1fr_20px]">
            <div class="flex justify-center items-center">
                {!! file_get_contents("icons/$link-icon.svg") !!}
            </div>

            <h3 class="text-left pl-3 {{ $currentPage == $text ? 'text-blue' : 'text-darkGray' }}">
                {{ $text }}
            </h3>
        </div>
    </button>
</a>
