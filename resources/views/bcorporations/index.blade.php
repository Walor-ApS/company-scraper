<x-layouts.header currentPage="B Corporations" link="bcorporations">
    {{-- Search field --}}
    <form action="" class="w-full bg-white rounded-lg p-2 flex gap-x-2 items-center text-sm mb-8">
        {!! file_get_contents('icons/search-icon.svg') !!}

        <input name="search" type="text" placeholder="Country" class="flex-1 outline-none"
            value="{{ request('search') ?? '' }}" />
        <button type="submit"
            class="bg-blue text-white rounded-md h-full px-4 py-2 transition-opacity hover:opacity-75">Search</button>
    </form>

    <section class="grid xl:grid-cols-4 gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
        @forelse ($bcorporations as $country => $bcorporation)
            <a class="bg-white p-8 rounded-md cursor-pointer hover:shadow-md transition-shadow"
                href="/bcorporations/{{ $country }}">
                <p class="text-center text-xl">{{ $country }}</p>
                <p class="text-center text-xl pt-1 font-bold">{{ count($bcorporation) }}</p>
            </a>
        @empty
            <p class="text-xs text-darkGray">There are no trigger leads for this request</p>
        @endforelse
    </section>

</x-layouts.header>
