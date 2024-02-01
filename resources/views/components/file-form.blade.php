<form action="{{ url('competitors/import') }}" method="POST" enctype="multipart/form-data" class="mb-4 flex items-center">
    @csrf
    <label for="fileInput"
        class="cursor-pointer bg-blueOpacity text-blue rounded-xl py-1 px-5 transition-opacity hover:opacity-75 h-fit">Choose
        file</label>
    <input type="file" id="fileInput" name="file" accept=".csv" class="hidden" onchange="updateButtonVisibility()" />

    <span id="selectedFileName" class="ml-2 text-slate-500"></span>
    <button type="button" id="uploadButton" onclick="toggleModal()"
        class="w-fit bg-slate-200 px-4 py-1 rounded-md ml-4 transition-opacity hover:opacity-75 h-fit hidden">Upload</button>

    <x-modal title="Name your competitor">
        <input type="text" name="competitor_name" placeholder="Walor.io" class="border-b border-b-blue outline-none">
        <button type="submit"
            class="bg-blueOpacity text-blue rounded-xl py-1 px-5 transition-opacity hover:opacity-75">Submit</button>
    </x-modal>
</form>

@push('scripts')
    <script>
        function updateButtonVisibility() {
            var fileInput = document.getElementById('fileInput');
            var uploadButton = document.getElementById('uploadButton');
            var selectedFileName = document.getElementById('selectedFileName');

            var fileName = fileInput.value.split('\\').pop();
            selectedFileName.textContent = fileName;

            if (fileName) {
                uploadButton.classList.remove('hidden');
            }
        }
    </script>
@endpush
