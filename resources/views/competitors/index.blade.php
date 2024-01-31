<x-layouts.header currentPage="Competitors" link="competitors">
    <x-file-form></x-file-form>

    <section class="grid xl:grid-cols-3 gap-8 lg:grid-cols-2 md:grid-cols-1 pt-4">
        @forelse ($competitors as $competitorId => $companies)
            @php
                $competitor = \App\Models\Competitor::find($competitorId);
            @endphp

            <a class="bg-white p-6 rounded-md cursor-pointer hover:shadow-md transition-shadow flex flex-col gap-y-1"
                href="/competitors/{{ $competitor->id }}">
                <p class="text-center text-2xl">{{ $competitor->name }}</p>
                <p class="text-center text-md text-slate-400">{{ $competitor->cvr_name }}</p>
                <p class="text-center text-lg font-bold">{{ count($companies) }}</p>
            </a>
        @empty
            <p class="text-xs text-darkGray">There are no trigger leads for this request</p>
        @endforelse
    </section>

</x-layouts.header>
