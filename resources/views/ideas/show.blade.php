<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
            <a href="{{ route('idea.index') }}" class="flex gap-x-1 items-center text-sm font-medium">
                <x-icons.arrow-back/>
                Back to Index
            </a>
            <div class="flex gap-x-2 items-center">
                <button
                    x-data
                    class="btn btn-outlined pr-4 gap-x-1" 
                    data-test="edit-idea-btn"
                    @click="$dispatch('open-modal', 'edit-idea')"
                >
                    <x-icons.edit/>
                    Edit Idea
                </button>
                <form action="{{ route('idea.destroy', $idea) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button data-test="delete-idea-btn" class="btn gap-x-1 btn-outlined pr-4 hover:bg-red-500/10 hover:text-red-500 hover:border-red-500/20 ">
                        <x-icons.delete/>
                        Delete
                    </button>
                
                </form> 
                
            </div>
        </div>

        <div class="mt-8 space-y-6">
            @if($idea->image_path)
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-auto object-cover">
                </div>
            @endif

            <h1 class="font-bold text-4xl">{{$idea->title}}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status->value">{{$idea->status->label()}}</x-idea.status-label>
                <div class="text-muted-foreground text-sm">{{$idea->created_at->diffForHumans()}}</div>
            </div>

            @if ($idea->description)
                <x-card class="mt-6" is="div">
                    <div class="prose prose-invert md:text-sm leading-relaxed">
                        {!! $idea->formattedDescription !!}
                    </div>
                    
                </x-card> 
            @endif
            

            @if ($idea->steps->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>
                    <div class="mt-2 space-y-2">
                        @foreach ($idea->steps as $step)
                            <x-card class=" flex gap-x-3 items-center" target="_blank">
                                <form action="{{ route('step.update', $step) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center gap-x-3">
                                        <button type="submit" role="checkbox" aria-checked="{{ $step->completed ? 'true' : 'false' }}" class="size-5 flex items-center justify-center rounded-lg text-primary-foreground {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">&check;</button>
                                        <span class=" {{ $step->completed ? 'line-through text-muted-foreground' : ''}}">{{ $step->description }}</span>
                                    </div>
                                </form>
                                
                            </x-card>
                        @endforeach

                    </div>
                </div>
            @endif


            @if ($idea->links?->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Links</h3>
                    <div class="mt-2 space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card :href="$link" class="text-primary font-medium flex gap-x-3 items-center" target="_blank">
                                <x-icons.link/>
                                {{ $link }}
                            </x-card>
                        @endforeach

                    </div>
                </div>
            @endif


        </div>

        <x-idea.modal-container :idea="$idea"/>
    </div>
</x-layout>

