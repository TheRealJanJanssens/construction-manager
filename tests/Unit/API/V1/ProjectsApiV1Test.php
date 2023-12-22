<?php

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');
});

it('can fetch a list of projects', function () {
    $unit = Unit::factory()->create();
    Project::factory()->create(['unit_uuid' => $unit->uuid]);
    $response = $this->get("/api/v1/projects");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'unitUuid',
                'name',
                'startDate',
                'dueDate',
                'completedDate'
            ]
        ]
    ]);
});

it('can fetch a specific project', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create([
        'unit_uuid' => $unit->uuid,
        'name' => 'Project 1'
    ]);

    $response = $this->get("/api/v1/projects/".$project->uuid);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'unitUuid',
            'name',
            'startDate',
            'dueDate',
            'completedDate'
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $project->uuid,
            'unitUuid' => $unit->uuid,
            'name' => 'Project 1'
        ]
    ]);
});

it('can store a new project', function () {
    $unit = Unit::factory()->create();

    $data = [
        'unit_uuid' => $unit->uuid,
        'name' => 'Project 1',
        'start_date' => Carbon::now()->toDateTimeString()
    ];

    $response = $this->postJson('/api/v1/projects', $data);
    $response->assertStatus(201);
});

it('can\'t create a project with invalid data', function () {
    $unit = Unit::factory()->create();

    $data = [
        'unit_uuid' => $unit->uuid,
        'name' => 'Project 1'
    ];

    $response = $this->postJson('/api/v1/projects', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The start date field is required.']);
});

it('can update a project with a put request', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create(['unit_uuid' => $unit->uuid]);

    $data = [
        'name' => 'Project 2',
    ];

    $response = $this->putJson('/api/v1/projects/'.$project->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $project->uuid,
            'name' => 'Project 2',
        ]
    ]);
});

it('can\'t update a project with a put request when invalid data is given', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create(['unit_uuid' => $unit->uuid]);

    $data = [
        'name' => null,
    ];

    $response = $this->putJson('/api/v1/projects/'.$project->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The name field is required.",
    ]);
});

it('can update a project with a patch request', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create(['unit_uuid' => $unit->uuid]);

    $data = [
        'name' => 'Project 2',
    ];

    $response = $this->patchJson('/api/v1/projects/'.$project->uuid, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'uuid' => $project->uuid,
            'name' => 'Project 2',
        ]
    ]);
});

it('can\'t update a project with a patch request when invalid data is given', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create(['unit_uuid' => $unit->uuid]);

    $data = [
        'name' => null,
    ];

    $response = $this->patchJson('/api/v1/projects/'.$project->uuid, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The name field is required.",
    ]);
});

it('can delete a given project', function () {
    $unit = Unit::factory()->create();
    $project = Project::factory()->create(['unit_uuid' => $unit->uuid]);

    $response = $this->delete('/api/v1/projects/'.$project->uuid);
    $response->assertStatus(200)->assertJson([
        'message' => "Project deleted successfully.",
    ]);
});
