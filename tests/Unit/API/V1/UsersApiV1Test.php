<?php

use App\Enums\Role;
use App\Enums\Status;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of users', function () {
    User::factory()->create();
    $response = $this->get("/api/v1/users");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'firstName',
                'lastName',
                'email',
                'meta'
            ]
        ]
    ]);
});

it('can fetch a specific user', function () {
    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $user->meta()->create([
        'job_title' => 'Test engineer'
    ]);

    $response = $this->get("/api/v1/users/".$user->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'firstName',
            'lastName',
            'email',
            'meta'
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $user->uuid,
            'firstName' => 'Jan',
            'lastName' => 'Janssens',
            'email' => 'tester@digiti.be',
            'meta' => [
                'jobTitle' => 'Test engineer'
            ]
        ]
    ]);
});

it('can store a new user', function () {
    $data = [
        'firstName' => 'Jan',
        'lastName' => 'Janssens',
        'email' => 'jan.janssens@digiti.be'
    ];

    $response = $this->postJson('/api/v1/users', $data);
    $response->assertStatus(201);
});

it('can\'t create a user with invalid data', function () {
    $data = [
        'firstName' => 'Jan',
        'lastName' => 'Janssens',
        'email' => 'notarealemail'
    ];

    $response = $this->postJson('/api/v1/users', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The email field must be a valid email address.']);
});


it('can update a user with a put request', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'firstName' => 'Peter',
        'lastName' => 'Janssens',
        'email' => 'jan.janssens@digiti.be'
    ];

    $response = $this->putJson('/api/v1/users/'.$user->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $user->uuid,
            'firstName' => 'Peter',
            'lastName' => 'Janssens',
            'email' => 'jan.janssens@digiti.be'
        ]
    ]);
});

it('can\'t update a user with a put request when invalid data is given', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'firstName' => 'Peter',
        'lastName' => 'Janssens',
        'email' => 'jan.janssensdigiti.be'
    ];

    $response = $this->putJson('/api/v1/users/'.$user->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The email field must be a valid email address.",
    ]);
});

it('can update a user with a patch request', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'first_name' => 'Peter',
        'email' => 'jan.janssens@digiti.be'
    ];

    $response = $this->patchJson('/api/v1/users/'.$user->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $user->uuid,
            'firstName' => 'Peter',
            'lastName' => 'Janssens',
            'email' => 'jan.janssens@digiti.be'
        ]
    ]);
});

it('can\'t update a user with a patch request when invalid data is given', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'email' => 'testerdigitibe',
    ];

    $response = $this->patchJson('/api/v1/users/'.$user->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The email field must be a valid email address.",
    ]);
});

it('can fetch a list of units related to the user', function () {
    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    Unit::factory()
        ->hasMeta()
        ->create()
        ->users()
        ->sync([$user->uuid]);

    $response = $this->get("/api/v1/users/".$user->uuid."/units");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'groupUuid',
                'name',
                'meta'
            ]
        ]
    ]);
});
