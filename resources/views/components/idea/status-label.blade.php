
@props([
    'status',
])

@php
    $statusEnum = $status instanceof \App\IdeaStatus 
        ? $status 
        : \App\IdeaStatus::from($status);

    $color = $statusEnum->color();

    $class = "inline-block rounded-full border px-2 py-1 text-xs font-medium ";
    $class .= "bg-{$color}/10 text-{$color} border-{$color}/20";
@endphp

<span 
    style="--status-color: {{ $color }};" 
    class="inline-block rounded-full border px-2 py-1 text-xs font-medium 
           text-(--status-color)
           bg-(--status-color)/10 
           border-(--status-color)/20"
>
    {{ $slot }}
</span>
