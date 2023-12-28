<?php

use App\Models\User;
use App\Models\Asset;
use App\Models\Project;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    //Authentication
    $user = User::factory()->create();
    $this->assertCount(0, $user->tokens);

    $this->actingAs($user, 'sanctum');

    Unit::factory(20)
        ->hasMeta()
        ->hasAssets(2)
        ->create();
});

it('can fetch a list of assets', function () {
    $response = $this->get("/api/v1/assets");

    $response->assertStatus(200)->assertJsonStructure([
        'data' => [
            [
                'uuid',
                'type',
                'filePath',
                'createdAt',
                'updatedAt',
            ]
        ]
    ]);
});

it('can fetch a specific asset ', function () {
    $unit = Unit::inRandomOrder()->first();
    $projects = Project::factory(10)
        ->hasAssets(2)
        ->create([
            'unit_uuid' => $unit->uuid
        ]);

    $assetId = $projects->first()->assets()->first()->uuid;
    $response = $this->get("/api/v1/assets/".$assetId);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'uuid',
            'type',
            'filePath',
            'createdAt',
            'updatedAt',
        ]
    ])
    ->assertJson([
        'data' => [
            'uuid' => $assetId,
            'filePath' => $projects->first()->assets()->first()->file_path
        ]
    ]);
});
