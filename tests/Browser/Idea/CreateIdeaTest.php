<?php

use App\Models\User;

// doesn't work with (enctype="multipart/form-data")
// remove (enctype="multipart/form-data") to pass the test
// at modal-container.blade.php in  the form attributes
it('create a new idea using UI', function () {
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-btn')
        ->fill('title', 'Test idea.')
        ->click('@button-status-completed')
        ->fill('description', 'Test description.')
        ->fill('@new-link', 'http://laravel.com')
        ->click('@submit-new-link-btn')
        ->fill('@new-link', 'http://example.com')
        ->click('@submit-new-link-btn')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-btn')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-btn')
        ->click('Create')
        ->assertPathIs('/ideas');

    $idea = $user->ideas()->first();
    expect($idea)->toMatchArray([
        'title' => 'Test idea.',
        'status' => 'completed',
        'description' => 'Test description.',
        'links' => ['http://laravel.com', 'http://example.com'],
    ]);
});

// Works with (enctype="multipart/form-data") because it directly uses post
it('creates a new idea directly using post', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/ideas', [
        'title' => 'Test idea.',
        'status' => 'completed',
        'description' => 'Test description.',
        'links' => ['http://laravel.com', 'http://example.com'],
    ]);

    $response->assertRedirect('/ideas');

    $idea = $user->ideas()->first();
    expect($idea)->not->toBeNull();
    expect($idea)->toMatchArray([
        'title' => 'Test idea.',
        'status' => 'completed',
        'description' => 'Test description.',
    ]);
});
