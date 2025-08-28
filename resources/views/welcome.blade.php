<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @fluxAppearance()

</head>

<body>
    <div>
        <flux:heading level="2" size="lg" class="">Welcome to </flux:heading>
        <flux:heading size="xl">{{ config('app.name', 'Laravel') }}</flux:heading>
    </div>

    @fluxScripts()
</body>

</html>
