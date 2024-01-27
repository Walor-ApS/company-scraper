<x-layouts.header currentPage="Competitors" link="competitors">
    {{-- Search field --}}
    <form action="{{ url('competitors/import') }}" method="POST" enctype="multipart/form-data" class="mb-4 flex flex-col">
        @csrf
        <input type="file" name="file" accept=".csv" class="text-slate-500 cursor-pointer" />

        <button type="submit" class="w-fit mt-4 bg-slate-200 px-4 py-1 rounded-md">Upload</button>
    </form>

    <section class="grid xl:grid-cols-3 gap-8 lg:grid-cols-2 md:grid-cols-1">
        @forelse ($competitors as $competitor => $companies)
            <a class="bg-white p-8 rounded-md cursor-pointer hover:shadow-md transition-shadow"
                href="/competitors/{{ $competitor }}">
                <p class="text-center text-xl">{{ $competitor }}</p>
                <p class="text-center text-xl pt-1 font-bold">{{ count($companies) }}</p>
            </a>
        @empty
            <p class="text-xs text-darkGray">There are no trigger leads for this request</p>
        @endforelse
    </section>

</x-layouts.header>
