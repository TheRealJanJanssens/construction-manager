<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    User::factory()
        ->email('jan.janssens@digiti.be')
        ->password('password')
        ->create();
});

it('can login a user', function () {
    $data = [
        'email' => 'jan.janssens@digiti.be',
        'password' => 'password'
    ];

    $response = $this->postJson('/api/v1/login', $data);

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            'accessToken',
            'tokenType',
            'user'
        ]
    ]);
});

it('can\'t login with invalid credentials', function () {
    $data = [
        'email' => 'tester@digiti.be',
        'password' => 'password'
    ];

    $response = $this->postJson('/api/v1/login', $data);

    $response->assertStatus(401)->assertJson([
        'message' => 'Login information is invalid.'
    ]);
});

// it('can\'t execute events resource without authentication', function () {
//     $response = $this->getJson("/api/v1/events");
//     $response->assertStatus(401)->assertJson([
//         'message' => 'Unauthenticated.'
//     ]);
// });

// it('can\'t execute meetings resource without authentication', function () {
//     $response = $this->getJson("/api/v1/meetings");
//     $response->assertStatus(401)->assertJson([
//         'message' => 'Unauthenticated.'
//     ]);
// });

// it('can\'t execute users resource without authentication', function () {
//     $response = $this->getJson("/api/v1/users");
//     $response->assertStatus(401)->assertJson([
//         'message' => 'Unauthenticated.'
//     ]);
// });
