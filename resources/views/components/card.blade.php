@props([
    'is' => 'a'
])


<{{ $is }} {{$attributes->merge(["class"=>"block border border-border rounded-lg bg-card p-4 md:text-sm space-y-3 "])}}>
    {{ $slot }}
</{{ $is }}>