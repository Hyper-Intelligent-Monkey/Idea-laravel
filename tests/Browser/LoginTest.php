<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

test('login a user', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create([
        'password' => 'password'
    ]);
    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('[data-test="login-btn"]')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

test('logs out a user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')
        ->click('@logout-btn');

    $this->assertGuest();
});


test('login an actual user', function () {
    visit('/login')
        ->fill('email', 'johndoe@example.com')
        ->fill('password', 'password')
        ->click('[data-test="login-btn"]')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

