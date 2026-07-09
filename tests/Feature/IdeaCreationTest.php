<?php

use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can create an idea with steps', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('idea.store'), [
            'title' => 'New Idea',
            'description' => 'Idea description',
            'status' => IdeaStatus::PENDING->value,
            'steps' => [
                ['description' => 'Step 1'],
                ['description' => 'Step 2'],
            ],
        ])
        ->assertRedirect(route('idea.index'));

    $this->assertDatabaseHas('ideas', [
        'title' => 'New Idea',
        'user_id' => $user->id,
    ]);

    $idea = Idea::where('title', 'New Idea')->first();

    $this->assertDatabaseHas('steps', [
        'idea_id' => $idea->id,
        'description' => 'Step 1',
    ]);

    $this->assertDatabaseHas('steps', [
        'idea_id' => $idea->id,
        'description' => 'Step 2',
    ]);
});
