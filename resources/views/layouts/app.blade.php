<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Dashboard' }}</title>
        <link rel="shortcut icon" href="{{asset('images/icons/DA-logo.png')}}" type="image/x-icon">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite('resources/css/app.css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    </head>
    <body>
        <section class="w-full bg-[#e9ffeb] flex">
            {{$slot}}
        </section>
    </body>
</html>



<script>
    let menu = document.querySelector("[data-menu]");
    let sidebar = document.querySelector("[data-sidebar]");

    menu.addEventListener("click", () => {
        sidebar.classList.toggle("isHidden");
    });
</script>