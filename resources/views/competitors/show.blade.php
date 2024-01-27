<x-layouts.header currentPage="Competitors" link="competitors" extension="{{ $competitor }}">
    <h1 class="text-2xl font-bold">Competitors</h1>

    <form action="{{ url('competitors/update') }}" method="post">
        @csrf
        @method('put')

        <table class="w-full mt-4 text-left table-auto">
            <tr>
                <th class="table-head pl-3">Name</th>
                <th class="table-head">Website</th>
                <th class="table-head">State</th>
                <th class="table-head"></th>
            </tr>
            <tr class="h-2"></tr>

            @forelse ($companies as $company)
                <tr>
                    <x-company-table-row :company="$company" :link="$company->page_url"></x-company-table-row>
                </tr>
                <tr class="h-1"></tr>
            @empty
                <tr>
                    <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                </tr>
            @endforelse
        </table>

        <button type="submit" class="mt-4 bg-blueOpacity p-2 px-8 rounded-full hover:opacity-75 transition-opacity">
            Import Competitors</button>
    </form>
    <x-pagination :pages="$companies"></x-pagination-button>

</x-layouts.header>
