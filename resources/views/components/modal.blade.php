@props([
    'name',
    'title',
    'show' => false
])

<div 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs text-foreground overflow-y-auto"
    x-data="{show: @js($show), name: @js($name)}"
    x-show="show"
    x-effect="document.body.classList.toggle('overflow-hidden', show)"
    @open-modal.window="if($event.detail === name) show = true"
    @close-modal.window="show = false"
    @keydown.escape.window="show = false"
    x-transition:enter="duration-200 ease-out"
    x-transition:enter-start="opacity-0 -translate-y-4 -translate-x-4"
    x-transition:enter-end="opacity-100"
    x-transition:leave="duration-150 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-y-4 -translate-x-4"
    style="display: none"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-{{ $name }}-title"
    :aria-hidden="!show"
    tabindex="-1"
    >

    <div @click.away="show = false" class="relative max-w-2xl w-full mx-6">
        
        <!-- 2. Close Button sits here completely unrestricted by the card's overflow parameters -->
        <button class="absolute -top-2 -right-2 z-50 border rounded-full p-1 bg-card text-muted-foreground shadow-lg 
        hover:bg-[color-mix(in_srgb,var(--color-card)_90%,red)] hover:text-red-500 hover:border-red-500" 
        @click="$dispatch('close-modal')">            <x-icons.close/>
        </button>

        <!-- 3. Card handles layout limits, shadows, and contains internal scrolling safely -->
        <x-card is="div" id="scrollCard" class="shadow-xl max-h-[80dvh] overflow-y-auto scrollbar-thin scrollbar-thumb-muted-foreground scrollbar-track-transparent">
            <div>
                <h2 id="modal-{{ $name }}-title" class="text-xl font-bold mb-4">{{ $title }}</h2>    
            </div>

            <div>
                {{ $slot }}
            </div>
        </x-card>
        
    </div>
    
    
</div>