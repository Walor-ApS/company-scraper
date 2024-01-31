<x-layouts.header currentPage="B Corporations" link="bcorporations">
    <x-searchbar placeholder="Country"></x-searchbar>

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
