@props(['statusCounter'])

<div>
        <div
            x-data="{
                open: false,
                selected: '{{ request('status') && \App\IdeaStatus::tryFrom(request('status')) ? \App\IdeaStatus::tryFrom(request('status'))->label() : 'All' }}',                toggle() {
                    if (this.open) {
                        return this.close()
                    }
                    this.$refs.button.focus()
                    this.open = true
                },
                close(focusAfter) {
                    if (! this.open) return
                    this.open = false
                    focusAfter && focusAfter.focus()
                }
            }"+
            x-on:keydown.escape.prevent.stop="close($refs.button)"
            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
            x-id="['dropdown-button']"
            class="relative"
        >
            <!-- Button -->
            <button
                x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                type="button"
                class="btn btn-outlined w-fit justify-between transition-all duration-200 hover:border-primary/50 group"
                :class="open ? 'bg-primary/10 border-primary/50 text-primary' : ''"
            >
                <span class="text-sm font-medium" x-text="selected"></span>
    
                <!-- Heroicon: micro chevron-down -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 text-muted-foreground transition-transform duration-200 group-hover:text-foreground" :class="open ? 'rotate-180 text-primary' : ''">
                    <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
    
            <!-- Panel -->
            <div
                x-ref="panel"
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                x-on:click.outside="close($refs.button)"
                :id="$id('dropdown-button')"
                x-cloak
                class="absolute left-0 w-38 rounded-xl shadow-2xl mt-2 z-20 origin-top-left bg-card/95 backdrop-blur-md border border-border p-1.5 focus:outline-none"
            >
                <a href="/" 
                <a href="{{ route('idea.index') }}" 
                    class="px-2 py-1.5 w-full flex items-center rounded-lg transition-all text-left text-sm group justify-between"
                    :class="selected === 'All' ? 'bg-primary/20 text-primary font-semibold' : 'text-foreground hover:bg-primary/10 hover:text-primary'"
                >
                    <div class="flex items-center">
                        <span class="w-2 h-2 rounded-full bg-gray-400 mr-2" :class="selected === 'All' ? 'animate-pulse' : ''"></span>
                        All
                    </div>
                    <span class="text-xs pl-3">{{ $statusCounter->get('all') }}</span>
                </a>

                @foreach (\App\IdeaStatus::cases() as $status)
                    <a href="{{ route('idea.index', ['status' => $status->value]) }}" 
                        class="px-2 py-1.5 min-w-full max-w-fit flex items-center rounded-lg transition-all text-left text-sm group justify-between"
                        :class="selected === '{{ $status->label() }}' ? 'bg-primary/20 text-primary font-semibold' : 'text-foreground hover:bg-primary/10 hover:text-primary'"
                    >
                        <div class="flex items-center">
                            <span 
                            style="--status-color: {{ $status->color() }};"
                            class="w-2 h-2 rounded-full bg-(--status-color) mr-2" :class="selected === '{{ $status->label() }}' ? 'animate-pulse' : ''"></span>
                            {{ $status->label() }}
                        </div>
                        <span class="text-xs pl-3">{{$statusCounter->get($status->value)}}</span>
                            
                        
                    </a>
                @endforeach
        </div>
    </div>