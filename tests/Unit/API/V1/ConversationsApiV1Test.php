<?php

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of conversations', function () {
    Conversation::factory()->create();
    $response = $this->get("/api/v1/conversations");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'name',
                'latestMessage',
                'createdAt',
                'updatedAt',
            ]
        ]
    ]);
});

it('can fetch a specific conversation ', function () {
    $conversation  = Conversation::factory()->create([
        'name' => 'Conversation 1'
    ]);

    $response = $this->get("/api/v1/conversations/".$conversation->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'name',
            'latestMessage',
            'createdAt',
            'updatedAt',
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $conversation->uuid,
            'name' => 'Conversation 1'
        ]
    ]);
});

it('can store a new conversation ', function () {
    $users = User::factory(2)->create();

    $usersData = $users->map(function($user){
        return $user->uuid;
    })->toArray();

    $data = [
        'name' => 'Conversation 1',
        'users' => $usersData

    ];

    $response = $this->postJson('/api/v1/conversations', $data);
    $response->assertStatus(201);
});

it('can\'t create a conversation  with invalid data', function () {
    $data = [
        'name' => 'Conversation 1'
    ];

    $response = $this->postJson('/api/v1/conversations', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The users field is required.']);
});

it('can update a conversation with a put request', function () {
    $conversation  = Conversation::factory()->create();

    $data = [
        'name' => 'Conversation 2',
    ];

    $response = $this->putJson('/api/v1/conversations/'.$conversation->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $conversation->uuid,
            'name' => 'Conversation 2',
        ]
    ]);
});

it('can\'t update a conversation with a put request when invalid data is given', function () {
    $conversation  = Conversation::factory()->create();

    $data = [
        'name' => "Conversation 2",
        'users' => ["fake-uuid"]
    ];

    $response = $this->patchJson('/api/v1/conversations/'.$conversation->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The users field must have at least 2 items.",
    ]);
});

it('can update a conversation with a patch request', function () {
    $conversation  = Conversation::factory()->create();

    $data = [
        'name' => 'Conversation 2',
    ];

    $response = $this->patchJson('/api/v1/conversations/'.$conversation->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $conversation->uuid,
            'name' => 'Conversation 2',
        ]
    ]);
});

it('can\'t update a conversation with a patch request when invalid data is given', function () {
    $conversation  = Conversation::factory()->create();

    $data = [
        'name' => "Conversation 2",
        'users' => ["fake-uuid"]
    ];

    $response = $this->patchJson('/api/v1/conversations/'.$conversation->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The users field must have at least 2 items.",
    ]);
});

it('can delete a given conversation ', function () {
    $conversation  = Conversation::factory()->create();

    $response = $this->delete('/api/v1/conversations/'.$conversation->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Conversation deleted successfully.",
    ]);
});

it('can retrieve all messages from a conversation ',function (){
    $conversation  = Conversation::factory()->has(
        Message::factory()->belongsToUser()->count(10)
    )->create();

    $response = $this->get("/api/v1/conversations/".$conversation->uuid."/messages");

    $response->assertStatus(200)->assertJson([
        'data' => [
            [
                'conversationUuid' => $conversation->uuid,
            ]
        ]
    ])->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'conversationUuid',
                'userUuid',
                'content',
                'createdAt',
                'updatedAt',
            ]
        ]
    ]);
});

it('can add a new message to a conversation ',function (){
    $conversation  = Conversation::factory()->create();

    $data = [
        "content" => "test message"
    ];

    $response = $this->postJson("/api/v1/conversations/".$conversation->uuid."/messages", $data);

    $response->assertStatus(201)->assertJson([
        'data' => [
            "conversationUuid" => $conversation->uuid,
            "content" => "test message"
        ]
    ])->assertJsonStructure([
        'data' => [
            'uuid',
            'conversationUuid',
            'userUuid',
            'content',
            'createdAt',
            'updatedAt'
        ]
    ]);
});
