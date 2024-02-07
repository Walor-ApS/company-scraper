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

    <x-modal id="help-modal" title="Follow instructions">
        <div class="flex flex-col gap-y-3">
            <p>1. Open ahrefs.com and search for dessired link</p>
            <p>2. Click on "backlinks" page</p>
            <p>3. Click on "Export" button</p>
            <img class="rounded-lg h-80 object-cover object-right-top w-full"
                src="{{ url('/help-images/export-btn.png') }}" alt="img">
            <p>4. Make sure to choose the "CSV(UTF-8)" option</p>
            <img class="rounded-lg w-full h-80 object-cover" src="{{ url('/help-images/csv-format.png') }}"
                alt="img">
        </div>
    </x-modal>
    <button class="fixed right-4 bottom-4 bg-slate-300 py-1 px-8 rounded-xl transition-opacity hover:opacity-60"
        onclick="toggleModal('help-modal')">Help</button>
</x-layouts.header>
