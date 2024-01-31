<section class="relative">
    <button type="submit"
        class="mt-4 bg-blueOpacity text-blue p-2 px-8 rounded-full hover:opacity-75 transition-opacity">
        Import Competitors</button>
    <button type="button"
        class="mt-4 border-2 border-blueOpacity p-2 px-8 rounded-full hover:opacity-75 transition-opacity absolute right-0"
        onclick="toggleModal()">
        Import All Competitors</button>

    <x-modal>
        <div class="flex flex-col gap-y-2">
            <h1 class="text-xl font-bold text-center">Are you sure?</h1>
            <p class="text-slate-500">{{ $confirmationText }}</p>
        </div>
        <div class="grid grid-cols-2 gap-x-4">
            <button type="button" onclick="toggleModal()"
                class="bg-red-400 rounded-xl py-2 transition-opacity hover:opacity-75">Cancel</button>
            <button type="submit" onclick="toggleModal()"
                class="bg-blueOpacity text-blue rounded-xl py-2 transition-opacity hover:opacity-75" name="action"
                value="importAllCompetitors">Import</button>
        </div>
    </x-modal>
</section>
