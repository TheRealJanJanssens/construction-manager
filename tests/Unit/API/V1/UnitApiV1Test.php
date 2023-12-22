<?php

use App\Models\Project;
use App\Models\User;
use App\Models\Unit;
use App\Models\UnitGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of units', function () {
    Unit::factory()->create();
    $response = $this->get("/api/v1/units");

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

it('can fetch a specific unit', function () {
    $group = UnitGroup::create([
        'name' => 'Project test appartement'
    ]);

    $unit = Unit::create([
        'name' => 'Appartement 1',
        'group_uuid' => $group->uuid,
    ]);

    $unit->meta()->create([
        'address' => 'Kerkstraat 123'
    ]);

    $response = $this->get("/api/v1/units/".$unit->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'groupUuid',
            'name',
            'meta'
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $unit->uuid,
            'groupUuid' => $group->uuid,
            'name' => 'Appartement 1',
            'meta' => [
                'address' => 'Kerkstraat 123'
            ]
        ]
    ]);
});

it('can store a new unit', function () {
    $group = UnitGroup::create([
        'name' => 'Project test appartement'
    ]);

    $data = [
        'name' => 'Appartement 1',
        'group_uuid' => $group->uuid,
    ];

    $response = $this->postJson('/api/v1/units', $data);
    $response->assertStatus(201);
});

it('can\'t create a user with invalid data', function () {
    $group = UnitGroup::create([
        'name' => 'Project test appartement'
    ]);

    $data = [
        'group_uuid' => $group->uuid,
    ];

    $response = $this->postJson('/api/v1/units', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The name field is required.']);
});

it('can update a unit with a put request', function () {

    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $data = [
        'name' => 'Appartement 2',
    ];

    $response = $this->putJson('/api/v1/units/'.$unit->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $unit->uuid,
            'name' => 'Appartement 2',
        ]
    ]);
});

it('can\'t update a user with a put request when invalid data is given', function () {

    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $data = [
        'name' => null,
    ];

    $response = $this->putJson('/api/v1/units/'.$unit->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The name field is required.",
    ]);
});

it('can update a user with a patch request', function () {

    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $data = [
        'name' => 'Appartement 2',
    ];

    $response = $this->patchJson('/api/v1/units/'.$unit->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $unit->uuid,
            'name' => 'Appartement 2',
        ]
    ]);
});

it('can\'t update a user with a patch request when invalid data is given', function () {

    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $data = [
        'name' => null,
    ];

    $response = $this->patchJson('/api/v1/units/'.$unit->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The name field is required.",
    ]);
});

it('can delete a given unit', function () {

    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $response = $this->delete('/api/v1/units/'.$unit->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Unit deleted successfully.",
    ]);
});

it('can fetch all projects of a specific unit', function () {
    $unit = Unit::create([
        'name' => 'Appartement 1',
    ]);

    $unit->meta()->create([
        'address' => 'Kerkstraat 123'
    ]);

    Project::create([
        'unit_uuid' => $unit->uuid,
        'name' => "Project name"
    ]);

    $response = $this->get("/api/v1/units/".$unit->uuid."/projects");

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'unitUuid',
                'name',
                'startDate',
                'dueDate',
                'completedDate'
            ]
        ]
    ])
    ->assertJson([
        'data' => [
            [
                'unitUuid' => $unit->uuid,
                'name' => 'Project name',
            ]
        ]
    ]);
});
