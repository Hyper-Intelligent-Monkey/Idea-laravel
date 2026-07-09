<?php

use App\Models\User;

test('login a user', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create([
        'password' => 'password',
    ]);
    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('[data-test="login-btn"]')
        ->assertRoute('idea.index');

    $this->assertAuthenticated();
});

test('logs out a user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')
        ->click('@logout-btn');

    $this->assertGuest();
});
