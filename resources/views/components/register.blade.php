<x-layout>
    <x-form title="Register an accountr" description="Organize your ideas.">
        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <x-form.field type="text" name="name" label="Name"/>
            <x-form.field type="email" name="email" label="Email"/>
            <x-form.field type="password" name="password" label="Password"/>
            <button type="submit" class="btn btn-primary mt-2 w-full h-10">Register</button>
        </form>
    </x-form>
</x-layout>