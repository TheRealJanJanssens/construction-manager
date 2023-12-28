<?php

use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    //Base content
    Conversation::factory(4)->create();
    User::factory(4)->create();

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of messages', function () {
    for ($i = 1; $i <= 6; $i++) {
        Message::factory()->belongsToConversation()->belongsToUser()->create();
    }

    $response = $this->get("/api/v1/messages");

    $response->assertStatus(200)->assertJsonStructure([
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

it('can fetch a specific message ', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $response = $this->get("/api/v1/messages/".$message->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'conversationUuid',
            'userUuid',
            'content',
            'createdAt',
            'updatedAt',
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $message->uuid,
            'content' => 'Message 1'
        ]
    ]);
});

it('can update a message with a put request', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $data = [
        'content' => 'Message 2',
    ];

    $response = $this->putJson('/api/v1/messages/'.$message->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $message->uuid,
            'content' => 'Message 2',
        ]
    ]);
});

it('can\'t update a message with a put request when invalid data is given', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $data = [
    ];

    $response = $this->patchJson('/api/v1/messages/'.$message->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can update a message with a patch request', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $data = [
        'content' => 'Message 2',
    ];

    $response = $this->patchJson('/api/v1/messages/'.$message->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $message->uuid,
            'content' => 'Message 2',
        ]
    ]);
});

it('can\'t update a message with a patch request when invalid data is given', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $data = [
    ];

    $response = $this->patchJson('/api/v1/messages/'.$message->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The content field is required.",
    ]);
});

it('can delete a given message ', function () {
    $message = Message::factory()->belongsToConversation()->belongsToUser()->create([
        'content' => 'Message 1'
    ]);

    $response = $this->delete('/api/v1/messages/'.$message->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Message deleted successfully.",
    ]);
});
