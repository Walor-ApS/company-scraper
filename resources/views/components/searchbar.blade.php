<form action="" class="w-full bg-white rounded-lg p-2 flex gap-x-2 items-center text-sm mb-8">
    {!! file_get_contents('icons/search-icon.svg') !!}

    <input name="search" type="text" placeholder="{{ $placeholder }}" class="flex-1 outline-none"
        value="{{ request('search') ?? '' }}" />
    <button type="submit"
        class="bg-blue text-white rounded-md h-full px-4 py-2 transition-opacity hover:opacity-75">Search</button>
</form>
