@php
    $countryCodes = [
        'Denmark' => 'DK',
        'Sweden' => 'SV',
        'Finland' => 'FI',
        'Norway' => 'NO',
    ];

    $countryParam = request('country') ?? 'Denmark';
    $countryCodeParam = $countryCodes[$countryParam];
@endphp

<x-layouts.header currentPage="{{ $currentPage }}" extension="{{ $month }}">
    <section class="flex space-x-4">
        @foreach (['Denmark', 'Sweden', 'Norway', 'Finland'] as $country)
            <a href="?country={{ $country }}"
                class="flex space-x-2 p-1 pr-3 border border-darkGray rounded-full hover:opacity-75 transition-opacity {{ $countryParam == $country ? 'bg-blueOpacity text-blue' : 'text-darkGray' }}">
                <img class="rounded-full overflow-hidden" src="{{ url("/icons/flags/$country.png") }}" alt="country">
                <h2>{{ $country }}</h2>
            </a>
        @endforeach
    </section>

    <h1 class="text-2xl pt-8 font-bold">Companies {{ $countryCodeParam }}</h1>

    <form action="{{ url('trigger-leads/remove') }}" method="post">
        @csrf
        @method('delete')
        <table class="w-full mt-4 text-left table-auto">
            <tr>
                <th class="table-head">Name</th>
                <th class="table-head">CVR</th>
                <th class="table-head">Employees</th>
                <th class="table-head">Founded at</th>
            </tr>
            <tr class="h-2"></tr>
            @forelse ($triggerLeads["$countryCodeParam"] ?? [] as $country => $triggerLead)
                <tr>
                    <td class="p-3 rounded-xl max-w-32 bg-white">{{ $triggerLead->company->name ?? 'Unknown' }}</td>
                    <td class="bg-white">{{ $triggerLead->company->cvr ?? 'Unknown' }}</td>
                    <td class="bg-white">{{ $triggerLead->employees ?? 'Unknown' }}</td>
                    <td class="bg-white rounded-xl">{{ $triggerLead->company->founded_at ?? 'Unknown' }}</td>
                    <td class="pl-4 w-10">
                        <input type="checkbox" name="selected_companies[]" value="{{ $triggerLead->company->id }}">
                    </td>
                </tr>
                <tr class="h-1"></tr>
            @empty
                <tr>
                    <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                </tr>
            @endforelse
        </table>
        <button type="submit" class="mt-4 bg-blueOpacity p-2 px-8 rounded-full hover:opacity-75 transition-opacity">
            Delete Trigger Leads</button>
    </form>
</x-layouts.header>
