<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Walor Company Scraper</title>
    @vite('resources/css/app.css')
</head>

<body class="text-black bg-gray">
    {{ $slot }}

    @stack('scripts')

    <script>
        function toggleModal(id) {
            var modal = document.getElementById(id ?? "modal");
            modal.classList.toggle('hidden');
        }
    </script>
</body>

</html>
