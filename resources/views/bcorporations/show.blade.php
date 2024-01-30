<x-layouts.header currentPage="B Corporations" link="bcorporations" extension="{{ $country }}">
    <h1 class="text-2xl font-bold">B Corporations</h1>

    <form action="{{ url('bcorporations/update') }}" method="post">
        @csrf
        @method('put')

        <table class="w-full mt-4 text-left table-auto">
            <tr>
                <th class="table-head pl-3">Name</th>
                <th class="table-head">Founded at</th>
                <th class="table-head">Website</th>
                <th class="table-head">State</th>
                <th class="table-head"></th>
            </tr>
            <tr class="h-2"></tr>

            @forelse ($bcorporations as $bcorporation)
                <tr>
                    <x-company-table-row :company="$bcorporation" :link="$bcorporation->link">
                        <td class="bg-white w-1/6">{{ $bcorporation->founded_at }}</td>
                    </x-company-table-row>
                </tr>
                <tr class="h-1"></tr>
            @empty
                <tr>
                    <td class="text-xs text-darkGray">There are no trigger leads for this request</td>
                </tr>
            @endforelse
        </table>

        <button type="submit" class="mt-4 bg-blueOpacity p-2 px-8 rounded-full hover:opacity-75 transition-opacity">
            Import B Corporations</button>
    </form>
    <x-pagination :pages="$bcorporations"></x-pagination-button>

</x-layouts.header>
