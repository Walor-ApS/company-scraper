@php
    $countryCodes = [
        'DK' => 'Denmark',
        'SV' => 'Sweden',
        'FI' => 'Finland',
        'NO' => 'Norway',
    ];
    $countryImageUrl = $countryCodes[$country ?? ''] ?? '';
@endphp

<tr>
    @if (isset($country))
        <td class="pl-3 rounded-l-xl bg-white w-10">
            <img src="{{ url("/icons/flags/$countryImageUrl.png") }}" alt="{{ $country }}"
                class="w-full rounded-full">
        </td>
    @endif
    <td
        class="p-3 w-[30%] bg-white {{ isset($country) == false ? 'rounded-l-xl' : '' }} {{ isset($link) ? 'text-blue' : '' }}">
        <a @if (isset($link)) href="{{ $link }}" @endif target="_blank">{{ $company->name }}</a>
    </td>
    {{ $slot }}
    <td class="bg-white">
        <div class="flex gap-x-2">
            <input type="text" name="websites[]" placeholder="Add website" value="{{ $company->website }}"
                class="outline-none flex-1 text-blue website-input">
            <input type="hidden" name="companyIds[]" value="{{ $company->id }}">

            <button type="submit" class="pr-2 hover:opacity-50 transition-opacity hidden website-button">
                {!! file_get_contents('icons/edit-button.svg') !!}
            </button>
        </div>
    </td>
    <td class="bg-white w-[10%] pl-3 rounded-r-xl">
        <div
            class="w-fit p-[1px] px-3 rounded-full text-sm {{ $company->state == 'New' ? 'bg-red-200' : 'bg-green-200' }}">
            {{ $company->state }}
        </div>
    </td>
    <td class="pl-3 w-10">
        <input type="checkbox" name="selected_companies[]" value="{{ $company->id }}">
    </td>
</tr>
<tr class="h-1"></tr>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputFields = document.querySelectorAll('.website-input');
            const buttons = document.querySelectorAll('.website-button');

            inputFields.forEach((input, index) => {
                input.addEventListener('input', function() {
                    buttons[index].classList.toggle('hidden', input.value === '');
                });
            });
        });
    </script>
@endpush
