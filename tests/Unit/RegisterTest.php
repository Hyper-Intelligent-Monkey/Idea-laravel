<?php

use Illuminate\Support\Facades\Auth;

test('registers a user', function () {
    $this->withoutExceptionHandling();

    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'johndoe@example.com')
        ->fill('password', 'password')
        ->click('@register-btn')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
    ]);
});