<x-layouts.header currentPage="B Corporations" link="bcorporations" extension="{{ $country }}">
    <x-searchbar placeholder="B Corporation"></x-searchbar>
    <h1 class="text-2xl font-bold">B Corporations</h1>

    <form action="{{ url("bcorporations/$country/update") }}" method="post">
        @csrf
        @method('put')

        <table class="w-full mt-4 text-left table-auto">
            <tr>
                <th class="table-head pl-3">Name</th>
                <th class="table-head">Employees</th>
                <th class="table-head">Website</th>
                <th class="table-head">State</th>
                <th class="table-head"></th>
            </tr>
            <tr class="h-2"></tr>

            @forelse ($bcorporations as $bcorporation)
                <tr>
                    <x-company-table-row :company="$bcorporation" :link="$bcorporation->website">
                        <td class="bg-white w-1/6">{{ $bcorporation->employees }}</td>
                    </x-company-table-row>
                </tr>
                <tr class="h-1"></tr>
            @empty
                <tr>
                    <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                </tr>
            @endforelse
        </table>

        @php
            $confirmationText = 'Are you sure you want to import ' . $bcorporationsCount . ' leads from ' . $country . ' into HubSpot?';
        @endphp
        <x-import-buttons :confirmationText="$confirmationText"></x-import-buttons>
    </form>
    <x-pagination :pages="$bcorporations"></x-pagination-button>

</x-layouts.header>
