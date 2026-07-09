<x-layout>
    <x-form title="Edit your account" description="Keep sensitive credentials to yourself.">
        <form action="{{ route('profile.edit') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <x-form.field type="text" name="name" label="Name" :value="$user->name"/>
            <x-form.field type="email" name="email" label="Email" :value="$user->email"/>
            <x-form.field type="password" name="password" label="New Password"/>
            <button type="submit" class="btn btn-primary mt-2 w-full h-10" data-test="edit-profile-btn">Update Account</button>
        </form>
    </x-form>
</x-layout>