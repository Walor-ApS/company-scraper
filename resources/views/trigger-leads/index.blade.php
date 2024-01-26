@php
    $yearParam = request('year') ?? '2024';
@endphp

<x-layouts.header currentPage="{{ $currentPage }}" link="triggerLeads">
    <ul class="list-none flex space-x-2 default:ring-0">
        @foreach ($years as $year)
            <li>
                <a href="?year={{ $year }}"
                    class="border border-darkGray rounded-full py-1 px-5 transition-opacity hover:opacity-75 {{ $yearParam == $year ? 'bg-blueOpacity text-blue' : 'text-darkGray' }}">{{ $year }}</a>
            </li>
        @endforeach
    </ul>

    @forelse ($triggerLeads[$yearParam] ?? [] as $employees => $employeesData)
        <h1 class="text-xl font-medium pt-10 pb-2 mb-4 border-b-[3px] border-blueOpacity">Trigger Leads with
            {{ $employees }}
            employees
        </h1>
        <section class="grid xl:grid-cols-4 gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
            @forelse ($employeesData as $month => $monthData)
                <a class="bg-white p-8 rounded-md cursor-pointer hover:shadow-md transition-shadow"
                    href="/triggerLeads/{{ $employees }}/{{ $yearParam }}/{{ $month }}">
                    <p class="text-center text-xl font-bold">{{ $month }}</p>
                    <div class="grid grid-cols-4 pt-5">
                        {{-- Denmark --}}
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <img class="rounded-full overflow-hidden" src="{{ url('/icons/flags/Denmark.png') }}"
                                alt="DK">
                            <h2 class="text-lg font-bold">{{ isset($monthData['DK']) ? count($monthData['DK']) : 0 }}
                            </h2>
                        </div>

                        {{-- Norway --}}
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <img class="rounded-full overflow-hidden" src="{{ url('/icons/flags/Norway.png') }}"
                                alt="NO">
                            <h2 class="text-lg font-bold">{{ isset($monthData['NO']) ? count($monthData['NO']) : 0 }}
                            </h2>
                        </div>

                        {{-- Sweden --}}
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <img class="rounded-full overflow-hidden" src="{{ url('/icons/flags/Sweden.png') }}"
                                alt="SV">
                            <h2 class="text-lg font-bold">{{ isset($monthData['SV']) ? count($monthData['SV']) : 0 }}
                            </h2>
                        </div>

                        {{-- Finland --}}
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <img class="rounded-full overflow-hidden" src="{{ url('/icons/flags/Finland.png') }}"
                                alt="NO">
                            <h2 class="text-lg font-bold">{{ isset($monthData['FI']) ? count($monthData['FI']) : 0 }}
                            </h2>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-xs text-darkGray">There are no trigger leads for this request</p>
            @endforelse
        </section>
    @empty
        <p class="text-xs text-darkGray pt-6">Select a year to view the data</p>
    @endforelse

</x-layouts.header>
