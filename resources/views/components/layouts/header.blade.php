<x-layouts.app>
    <nav class="p-10 bg-white flex-1 w-80 h-screen fixed">
        <a href="/">
            {!! file_get_contents('logo.svg') !!}
        </a>

        <div class="pt-20">
            <x-nav-button text="Trigger Leads" link="trigger-leads" currentPage="{{ $currentPage }}"></x-nav-button>
            <x-nav-button text="B Corporations" link="b-corporations" currentPage="{{ $currentPage }}"></x-nav-button>
            <x-nav-button text="Competitors" link="competitors" currentPage="{{ $currentPage }}"></x-nav-button>
        </div>
    </nav>
    <section class="pt-10 pl-7 ml-80 bg-white h-28 fixed w-screen">
        <div class="flex items-center space-x-8">
            <h1 class="text-2xl">{{ $currentPage }}</h1>
            @if (isset($extension))
                {!! file_get_contents('icons/chevron-right.svg') !!}
                <h1 class="text-xl font-bold">{{ $extension }}</h1>
            @endif
        </div>
    </section>
    <main class="pl-[352px] pr-[32px] pt-[146px] pb-6">
        {{ $slot }}
    </main>

</x-layouts.app>