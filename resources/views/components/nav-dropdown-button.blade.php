<div class="mb-3" id="Trigger-Leads">
    <button
        class="p-3 px-4 rounded-xl w-full {{ $currentPage == $text ? 'bg-blueOpacity' : 'bg-white' }} hover:bg-slate-200 transition"
        id="toggleButton" onclick="toggleDropdown()">
        {{-- <div class="grid grid-cols-[20px_1fr_20px]">
            <div class="flex justify-center items-center">
                {!! file_get_contents('icons/trigger-leads-icon.svg') !!}
            </div>

            <h3 class="{{ $currentPage == $text ? 'text-blue' : 'text-darkGray' }}">{{ $text }}</h3>

            <div class="flex justify-center items-center">
                {!! file_get_contents('icons/chevron-down.svg') !!}
            </div>
        </div> --}}
    </button>

    <section class="flex {{ $currentPage == $text ? '' : 'hidden' }} flex-col" id="dropdownSection">
        {{ $slot }}
    </section>
</div>

@push('scripttts')
    <script>
        function toggleDropdown() {
            var dropdownSection = document.getElementById('dropdownSection');
            dropdownSection.classList.toggle('hidden');
            var dropdownSection = document.getElementById('toggleButton');
            dropdownSection.classList.toggle('bg-slate-200');
        }
    </script>
@endpush
