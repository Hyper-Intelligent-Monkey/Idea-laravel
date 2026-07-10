@props([
    'idea' => new App\Models\Idea()
])

<x-modal name="{{$idea->exists ? 'edit-idea' : 'create-idea'}}" title="{{$idea->exists ? 'Edit Idea' : 'NewIdea'}}">
            <form
                x-ref="modalForm"
                action="{{$idea->exists ? route('idea.update', $idea) : route('idea.store') }}" 
                method="POST"
                x-data="{
                    status: @js(old('status', $idea->status->value)),
                    newLink: '',
                    links: @js(old('links', $idea->links ?? [])),
                    newStep: '',
                    steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed'])))
                }"
                {{-- 
                // Include this in the x-data object if you want to test the UI of the form.
                image: '' --}} 
                enctype="multipart/form-data"
                >
                @csrf

                @if($idea->exists)
                    @method('PATCH')
                @endif

                <div class="space-y-6">
                    <x-form.field 
                        label="Title" 
                        name="title" 
                        placeholder="Enter a title." 
                        autofocus 
                        required
                        value="{{$idea->title}}"
                    />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>
                        <div class="flex gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                                <button
                                    type="button"
                                    @click="status = @js($status->value)"
                                    style="--status-color: {{ $status->color() }}"
                                    data-test="button-status-{{ $status->value }}"
                                    class="btn flex-1 border"
                                    :class="status === @js($status->value) ? 'bg-(--status-color)/10 border-(--status-color)/20  text-(--status-color)' : 'btn-outlined'"
                                >{{ $status->label() }}</button>
                                
                            @endforeach

                            <input type="hidden" name="status" :value="status" class="input">

                        </div>
                        <x-form.error name="status"/>

                    </div>

                    <x-form.field label="Description" name="description" placeholder="Describe your idea." type="textarea" value="{{$idea->description}}"/>

                    <div class="space-y-2">
                        <label for="image" class="label">Featured Image</label>

                        @if ($idea->image_path)
                            <div class="space-y-2">
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($idea->image_path) }}"
                                    alt="{{ $idea->title }}"
                                    class="w-full h-48 object-cover rounded-lg">

                                <button class="btn btn-outlined w-full" form="delete-image-form">Remove Image</button>
                            </div>

                        @endif

                        <input type="file" id="image" name="image" accept="image/*">

                    
                    {{-- 
                    // Solution for testing form without (enctype="multipart/form-data) issues.
                    // This converts the image into a Base64 string.
                    // This creates an image that is not supported by the remove image button.
                    // Replace the input type="file" with the following:
                    <input type="file" id="image_file" accept="image/*"
                            @change="
                            let file = $event.target.files[0]; 
                            if (file) {
                                let reader = new FileReader();
                                reader.onload = (e) => {image = e.target.result;};
                                reader.readAsDataURL(file);
                            }
                            "
                        >

                        <input type="hidden" name="image" :value="image" class="input"> --}}

                        <x-form.error name="image"/>
                    </div>
                    
                    <div>
                        <fieldset class="space-y-3">
                                <legend class="label">Actionable Steps</legend>

                                <template x-for="(step, index) in steps" :key="step.id || index">
                                    <div class="flex gap-x-2 items-center">

                                        <input :name="'steps[' + String(index) + '][description]'" x-model="step.description" class="input">
                                        <input type="hidden" :name="'steps[' + String(index) + '][completed]'" :value="step.completed ? '1' : '0'" class="input">
                                        
                                        <button
                                            type="button"
                                            aria-label="Remove step"
                                            @click="steps.splice(index, 1)"
                                            class="form-muted-icon"
                                        >
                                            <x-icons.close />
                                        </button>
                                    </div>
                                </template>

                                <div class="flex gap-x-2 items-center">
                                    <input
                                        x-model="newStep"
                                        x-ref="newStepInput"
                                        id="new-step"
                                        data-test="new-step"
                                        placeholder="What needs to be done"
                                        class="input flex-1"
                                        spellcheck="false"
                                        >
                                    <button
                                        type="button"
                                        x-ref="addStepButton"
                                        class="form-muted-icon"
                                        data-test="submit-new-step-btn"
                                        @click="
                                            steps.push({description: newStep.trim(), completed: false}); 
                                            newStep = '';
                                            $nextTick(() => {
                                                $refs.modalForm.scrollIntoView({ behavior: 'smooth', block: 'end' });
                                                $refs.newStepInput.focus();
                                            });
                                        "
                                        :disabled="newStep.trim().length === 0"
                                        aria-label="Add a new step"
                                    >
                                        <x-icons.close class="rotate-45"/>
                                    </button>

                                </div>
                            
                        </fieldset>
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                                <legend class="label">Links</legend>

                                <template x-for="(link, index) in links" :key="link">
                                    <div class="flex gap-x-2 items-center">
                                        <input name="links[]" x-model="link" class="input">
                                        <button
                                            type="button"
                                            aria-label="Remove link"
                                            @click="links.splice(index, 1)"
                                            class="form-muted-icon"
                                        >
                                            <x-icons.close />
                                        </button>
                                    </div>
                                </template>

                                <div class="flex gap-x-2 items-center">
                                    <input
                                        x-model="newLink"
                                        x-ref="newLinkInput"
                                        type="url"
                                        id="new-link"
                                        data-test="new-link"
                                        placeholder="http://example.com"
                                        autocomplete="url"
                                        class="input flex-1"
                                        spellcheck="false"
                                        >
                                    <button
                                        type="button"
                                        x-ref="addLinkButton"
                                        class="form-muted-icon"
                                        data-test="submit-new-link-btn"
                                        @click="
                                            links.push(newLink.trim()); 
                                            newLink = '';
                                            $nextTick(() => {
                                                $refs.modalForm.scrollIntoView({ behavior: 'smooth', block: 'end' });
                                                $refs.newLinkInput.focus();
                                            });
                                        "
                                        :disabled="newLink.trim().length === 0"
                                        aria-label="Add a new link"
                                    >
                                        <x-icons.close class="rotate-45"/>
                                    </button>

                                </div>
                            
                        </fieldset>
                    </div>

                    <div class="flex justify-end gap-x-5">
                        <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                        <button type="submit" class="btn" data-test="{{ $idea->exists ? 'update-idea-btn' : 'create-idea-btn'}}"> {{ $idea->exists ? 'Update' : 'Create'   }}</button>
                    </div>

                </div>
                
            </form>

            @if($idea->image_path)
                <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
                    @csrf
                    @method('DELETE')
                </form>
            @endif

        </x-modal>