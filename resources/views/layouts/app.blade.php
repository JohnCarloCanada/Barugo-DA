<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Dashboard' }}</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite('resources/css/app.css')
    </head>
    <body>
        <section class="w-full bg-[#e9ffeb] flex">
            {{$slot}}
        </section>

        @vite('resources/js/sideBarMenu.js')
    </body>
</html>