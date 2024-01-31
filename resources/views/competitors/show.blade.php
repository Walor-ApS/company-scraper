<x-layouts.header currentPage="Competitors" link="competitors" extension="{{ $competitor->name }}">
    <x-searchbar placeholder="Company"></x-searchbar>
    <h1 class="text-2xl font-bold">Companies</h1>

    <form action="{{ url("competitors/$competitor->id/update") }}" method="post">
        @csrf
        @method('put')

        <table class="w-full mt-4 text-left table-auto">
            <tr>
                <th class="table-head pl-3">Name</th>
                <th class="table-head">Website</th>
                <th class="table-head pl-3">State</th>
                <th class="table-head"></th>
            </tr>
            <tr class="h-2"></tr>

            @forelse ($companies as $company)
                <tr>
                    <x-company-table-row :company="$company"></x-company-table-row>
                </tr>
                <tr class="h-1"></tr>
            @empty
                <tr>
                    <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                </tr>
            @endforelse
        </table>

        @php
            $confirmationText = 'Are you sure you want to import ' . $companiesCount . ' leads from ' . $competitor->name . ' into HubSpot?';
        @endphp
        <x-import-buttons :confirmationText="$confirmationText"></x-import-buttons>
    </form>
    <x-pagination :pages="$companies"></x-pagination-button>

</x-layouts.header>
