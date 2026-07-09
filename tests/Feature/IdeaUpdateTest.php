<?php

use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it can update an idea and its steps', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->create(['user_id' => $user->id]);
    $idea->steps()->create(['description' => 'Old Step']);

    $this->actingAs($user)
        ->patch(route('idea.update', $idea), [
            'title' => 'Updated Title',
            'status' => IdeaStatus::COMPLETED->value,
            'steps' => [
                ['description' => 'New Step 1'],
                ['description' => 'New Step 2'],
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'title' => 'Updated Title',
        'status' => IdeaStatus::COMPLETED->value,
    ]);

    $this->assertDatabaseMissing('steps', [
        'description' => 'Old Step',
    ]);

    $this->assertDatabaseHas('steps', [
        'idea_id' => $idea->id,
        'description' => 'New Step 1',
    ]);

    $this->assertDatabaseHas('steps', [
        'idea_id' => $idea->id,
        'description' => 'New Step 2',
    ]);
});
