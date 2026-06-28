@props([
    'label',
    'name',
    'type' => 'text'
])
<div class="space-y-2">
    <label for="{{ $name }}" class="label">{{$label}}</label>
    <input type="{{$type}}" name="{{ $name }}" id="{{ $name }}" class="input" value="{{old($name)}}" {{$attributes}}>

    @error($name)
        <p class="error">{{$message}}</p>
    @enderror
</div>