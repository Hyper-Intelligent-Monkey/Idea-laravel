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
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            x-transition.opacity.duration.300ms
            class="fixed bottom-4 right-4 z-50 pointer-events-none"
        >
            <div class="bg-primary text-primary-foreground px-4 py-2 rounded-lg shadow-lg pointer-events-auto">
                {{ $value }}
            </div>
        </div>
    @endsession
</body>
</html>