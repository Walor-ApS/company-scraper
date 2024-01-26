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
    <td class="p-3 w-1/4 bg-white {{ isset($country) == false ? 'rounded-l-xl' : '' }}">{{ $lead->company->name }}
    </td>
    <td class="bg-white w-1/6">{{ $lead->company->cvr }}</td>
    <td class="bg-white w-[12%]">{{ $lead->employees }}</td>
    <td class="bg-white">
        <div class="flex gap-x-2">
            <input type="text" name="websites[]" placeholder="Add website" value="{{ $lead->company->link }}"
                class="outline-none flex-1 text-blue website-input">
            <input type="hidden" name="companyIds[]" value="{{ $lead->company->id }}">

            <button type="submit" class="pr-2 hover:opacity-50 transition-opacity hidden website-button">
                {!! file_get_contents('icons/edit-button.svg') !!}
            </button>
        </div>
    </td>
    <td class="bg-white w-[10%] pl-3 rounded-r-xl">
        <div
            class="w-fit p-[1px] px-3 rounded-full text-sm {{ $lead->company->state == 'New' ? 'bg-red-200' : 'bg-green-200' }}">
            {{ $lead->company->state }}
        </div>
    </td>
    <td class="pl-3 w-10">
        <input type="checkbox" name="selected_companies[]" value="{{ $lead->company->id }}">
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
