<?php

use App\Models\Idea;
use App\Models\User;

// doesn't work with (enctype="multipart/form-data")
// remove (enctype="multipart/form-data") to pass the test
// at modal-container.blade.php in  the form attributes
it('edit an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->fill('title', 'Test idea.')
        ->click('@button-status-completed')
        ->fill('description', 'Test description.')
        ->fill('@new-link', 'http://laravel.com')
        ->click('@submit-new-link-btn')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-btn')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    $idea = $user->ideas()->first();
    expect($idea)->toMatchArray([
        'title' => 'Test idea.',
        'status' => 'completed',
        'description' => 'Test description.',
        'links' => [$idea->links[0], 'http://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});

it('show the initial title', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-btn')
        ->assertValue('title', $idea->title);
});
