<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config("app.name") }}</title>

        <!-- Styles -->
        <link rel="preload" as="style" onload="this.rel = 'stylesheet'"  href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        @livewireStyles
    </head>
    <body class="antialiased">
        <div class="box bg-orange-500"></div>
        <div class="box bg-blue-500"></div>
        <div class="box bg-purple-500"></div>

        <livewire:post />

        @livewireScripts
    </body>
</html>
