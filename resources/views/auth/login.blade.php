<x-layout>
    <x-form title="Log in" description="Start organizing your ideas.">
        <form action="{{ route('login') }}" method="POST" class="space-y-4">            
            @csrf
            <x-form.field type="email" name="email" label="Email"/>
            <x-form.field type="password" name="password" label="Password"/>
            <button type="submit" class="btn btn-primary mt-2 w-full h-10" data-test="login-btn">Sign in</button>
        </form>
    </x-form>
</x-layout>