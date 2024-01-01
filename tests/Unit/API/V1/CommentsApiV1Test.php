<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    //Base content
    Unit::factory()->create();
    Project::factory()->belongsToUnit()->create();
    Post::factory(4)->belongsToProject()->belongsToUser()->create();
    User::factory(4)->create();

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of comments', function () {
    for ($i = 1; $i <= 6; $i++) {
        Comment::factory()->belongsToPost()->belongsToUser()->create();
    }

    $response = $this->get("/api/v1/comments");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'postUuid',
                'userUuid',
                'content',
                'createdAt',
                'updatedAt',
            ]
        ]
    ]);
});

it('can fetch a specific comment', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $response = $this->get("/api/v1/comments/".$comment->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'postUuid',
            'userUuid',
            'content',
            'createdAt',
            'updatedAt',
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $comment->uuid,
            'content' => 'Comment 1'
        ]
    ]);
});

it('can update a comment with a put request', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $data = [
        'content' => 'Comment 2',
    ];

    $response = $this->putJson('/api/v1/comments/'.$comment->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $comment->uuid,
            'content' => 'Comment 2',
        ]
    ]);
});

it('can\'t update a comment with a put request when invalid data is given', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $data = [
        'content' => null
    ];

    $response = $this->patchJson('/api/v1/comments/'.$comment->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can update a comment with a patch request', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $data = [
        'content' => 'Comment 2',
    ];

    $response = $this->patchJson('/api/v1/comments/'.$comment->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $comment->uuid,
            'content' => 'Comment 2',
        ]
    ]);
});

it('can\'t update a comment with a patch request when invalid data is given', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $data = [
        'content' => null
    ];

    $response = $this->patchJson('/api/v1/comments/'.$comment->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can delete a given comment ', function () {
    $comment = Comment::factory()->belongsToPost()->belongsToUser()->create([
        'content' => 'Comment 1'
    ]);

    $response = $this->delete('/api/v1/comments/'.$comment->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Comment deleted successfully.",
    ]);
});
