@php
    $countryCodes = [
        'Denmark' => 'DK',
        'Sweden' => 'SV',
        'Finland' => 'FI',
        'Norway' => 'NO',
        'all' => 'all',
    ];

    $countryParam = request('country') ?? 'all';
    $countryCodeParam = $countryCodes[$countryParam];
@endphp

<x-layouts.header currentPage="{{ $currentPage }}" link="triggerLeads" extension="{{ $month }}">
    <section class="flex space-x-4">
        <a href="?country=all"
            class="flex space-x-2 p-1 px-5 border border-darkGray rounded-full hover:opacity-75 transition-opacity {{ $countryParam == 'all' ? 'bg-blueOpacity text-blue' : 'text-darkGray' }}">
            <h2>All</h2>
        </a>
        @foreach (['Denmark', 'Norway', 'Sweden', 'Finland'] as $country)
            <a href="?country={{ $country }}"
                class="flex space-x-2 p-1 pr-3 border border-darkGray rounded-full hover:opacity-75 transition-opacity {{ $countryParam == $country ? 'bg-blueOpacity text-blue' : 'text-darkGray' }}">
                <img class="rounded-full overflow-hidden" src="{{ url("/icons/flags/$country.png") }}" alt="country">
                <h2>{{ $country }}</h2>
            </a>
        @endforeach
    </section>

    <h1 class="text-2xl pt-8 font-bold">Companies</h1>

    <form action="{{ url('triggerLeads/update') }}" method="post">
        @csrf
        @method('put')
        <table class="w-full mt-4 text-left table-auto">
            <tr>

                @if ($countryParam == 'all')
                    <th class="table-head w-2"></th>
                @endif
                <th class="table-head pl-3">Name</th>
                <th class="table-head">CVR</th>
                <th class="table-head">Employees</th>
                <th class="table-head">Website</th>
                <th class="table-head pl-3">State</th>
                <th class="table-head"></th>
            </tr>
            <tr class="h-2"></tr>

            @if ($countryParam == 'all')
                @forelse ($triggerLeads as $country => $leads)
                    @foreach ($leads as $lead)
                        <x-company-table-row :company="$lead->company" :country="$country">
                            <td class="bg-white w-1/6">{{ $lead->company->cvr }}</td>
                            <td class="bg-white w-[12%]">{{ $lead->company->employees() }}</td>
                        </x-company-table-row>
                    @endforeach
                @empty
                    <tr>
                        <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                    </tr>
                @endforelse
            @else
                @forelse ($triggerLeads["$countryCodeParam"] ?? [] as $country => $triggerLead)
                    <x-company-table-row :company="$triggerLead->company">
                        <td class="bg-white w-1/6">{{ $triggerLead->company->cvr }}</td>
                        <td class="bg-white w-[12%]">{{ $triggerLead->company->employees() }}</td>
                    </x-company-table-row>
                @empty
                    <tr>
                        <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                    </tr>
                @endforelse
            @endif

        </table>
        <button type="submit" class="mt-4 bg-blueOpacity p-2 px-8 rounded-full hover:opacity-75 transition-opacity">
            Import Trigger Leads</button>
    </form>
</x-layouts.header>
