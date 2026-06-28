<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Idea</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground" >
    <x-layout.nav />

    <main class="max-w-7xl mx-auto px-6">
        {{ $slot }}
    </main>

    @session('success')
        <div 
        x-data="{show: true}"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition.opacity.duration.300ms
        class="w-full px-6 absolute bottom-4">
            <div class="flex justify-end">
                <div class="bg-primary text-primary-foreground px-3 py-2 rounded-lg w-fit right-4">
                    {{ $value }}
                </div>
            </div>
        </div>
    @endsession
</body>
</html>