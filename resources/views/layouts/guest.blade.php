<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{  $title ?? 'Login' }}</title>
        <link rel="shortcut icon" href="{{asset('images/DA-Logo.png')}}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @vite('resources/css/app.css')
    </head>
    <body>
        {{ $slot }}
    </body>
</html>