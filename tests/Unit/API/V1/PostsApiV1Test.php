<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');

    //Base
    Unit::factory()->create();
    Project::factory()->belongsToUnit()->create();
});

it('can fetch a list of posts', function () {
    Post::factory(4)->belongsToProject()->belongsToUser()->create();
    $response = $this->get("/api/v1/posts");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'content',
                'createdAt',
                'updatedAt',
            ]
        ]
    ]);
});

it('can fetch a specific post', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create([
        'content' => 'Post 1'
    ]);

    $response = $this->get("/api/v1/posts/".$post->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'content',
            'createdAt',
            'updatedAt',
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $post->uuid,
            'content' => 'Post 1'
        ]
    ]);
});

it('can store a new post', function () {
    $user = User::first();
    $project = Project::first();

    $data = [
        'content' => 'Post 1',
        'project_uuid' => $project->uuid,
        'user_uuid' => $user->uuid

    ];

    $response = $this->postJson('/api/v1/posts', $data);
    $response->assertStatus(201);
});

it('can\'t create a post with invalid data', function () {
    $project = Project::first();

    $data = [
        'content' => 'Post 1',
        'project_uuid' => $project->uuid,
    ];

    $response = $this->postJson('/api/v1/posts', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The user uuid field is required.']);
});

it('can update a post with a put request', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $data = [
        'content' => 'Post 2',
    ];

    $response = $this->putJson('/api/v1/posts/'.$post->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $post->uuid,
            'content' => 'Post 2',
        ]
    ]);
});

it('can\'t update a post with a put request when invalid data is given', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $data = [
        'content' => null
    ];

    $response = $this->patchJson('/api/v1/posts/'.$post->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can update a post with a patch request', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $data = [
        'content' => 'Post 2',
    ];

    $response = $this->patchJson('/api/v1/posts/'.$post->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $post->uuid,
            'content' => 'Post 2',
        ]
    ]);
});

it('can\'t update a post with a patch request when invalid data is given', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $data = [
        'content' => null
    ];

    $response = $this->patchJson('/api/v1/posts/'.$post->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can delete a given post', function () {
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $response = $this->delete('/api/v1/posts/'.$post->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Post deleted successfully.",
    ]);
});

it('can retrieve all comments from a post',function (){
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    for ($i = 1; $i <= 3; $i++) {
        Comment::factory()->belongsToUser()->belongsToPost($post->uuid)->create();
    }

    $response = $this->get("/api/v1/posts/".$post->uuid."/comments");

    $response->assertStatus(200)->assertJson([
        'data' => [
            [
                'postUuid' => $post->uuid,
            ]
        ]
    ])->assertJsonStructure([
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

it('can add a new comment to a post',function (){
    $post = Post::factory()->belongsToProject()->belongsToUser()->create();

    $data = [
        "post_uuid" => $post->uuid,
        "content" => "test comment"
    ];

    $response = $this->postJson("/api/v1/posts/".$post->uuid."/comments", $data);

    $response->assertStatus(201)->assertJson([
        'data' => [
            "postUuid" => $post->uuid,
            "content" => "test comment"
        ]
    ])->assertJsonStructure([
        'data' => [
            'uuid',
            'postUuid',
            'userUuid',
            'content',
            'createdAt',
            'updatedAt'
        ]
    ]);
});
