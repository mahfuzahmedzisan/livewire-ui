<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    @stack('styles')
</head>

<body>

    <livewire:frontend.partials.header />
    <livewire:frontend.partials.sidebar />

    {{ $slot }}

    <livewire:frontend.partials.footer />

    @fluxScripts
    @stack('scripts')

</body>

</html>
