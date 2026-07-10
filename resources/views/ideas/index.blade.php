<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="mt-1 text-muted-foreground">Organize your ideas.</p>

            <x-card 
                is="button"
                type="button"
                class="mt-10 cursor-pointer h-32 w-full flex items-center"
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                data-test="create-idea-btn"
                >
                <p>What's the idea?</p>
            </x-card>
        </header>
    </div>
    
    <x-idea.status-dropdown :status-counter="$statusCounter" />

    <div class="mt-4 mb-6 text-muted-foreground">
        <div class="grid md:grid-cols-2 gap-6 row-span-full">
            @forelse($ideas as $idea)
                <x-card href="{{ route('idea.show', $idea) }}">
                    @if($idea->image_path)
                        <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($idea->image_path) }}"
                                alt="{{ $idea->title }}"
                                class="w-full h-48 object-cover">
                        </div>
                    @endif
                    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>
                    <div>
                        <x-idea.status-label status="{{$idea->status->value}}">
                            {{$idea->status->label()}}
                        </x-idea.status-label>
                    </div>
                    <div class="prose prose-invert md:text-sm line-clamp-3 leading-relaxed">
                        {!! $idea->formattedDescription !!}
                    </div>
                    <div class="mt-4">
                        {{ $idea->created_at->diffforHumans() }}
                    </div>
                </x-card>               
                @empty
                <x-card>
                    <p class="text-muted-foreground">No ideas found.</p>
                </x-card>
            @endforelse
        </div>
        
        <x-idea.modal-container/>
        
    </div>
</x-layout>