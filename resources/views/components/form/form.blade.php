@props([
    'title',
    'description'
])

<div  class="flex min-h-[calc(100vh-5rem)] items-center justify-center px-4">
    <div class="w-full max-w-md space-y-10">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight">{{$title}}</h1>
            <p class="text-muted-foreground mt-1">{{ $description }}</p>
        </div>

        {{ $slot }}

    </div>
</div>