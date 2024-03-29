@php
    $modalId = $id ?? 'modal';
@endphp
<main id="{{ $modalId }}" class="hidden">
    <section
        class="fixed w-[40%] top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 justify-center items-center">
        <div class="bg-white p-6 rounded-xl flex flex-col gap-y-6 max-h-[90vh] overflow-scroll">
            <h1 class="text-xl font-medium text-center">{{ $title }}</h1>
            {{ $slot }}
        </div>
    </section>
    {{-- Gray background --}}
    <section class="fixed right-0 left-0 top-0 bottom-0 bg-black/30 z-40" onclick='toggleModal("{{ $modalId }}")'>
    </section>
</main>
