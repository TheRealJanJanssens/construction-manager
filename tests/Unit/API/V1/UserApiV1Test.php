<?php

use App\Enums\Role;
use App\Enums\Status;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
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
                'id',
                'firstName',
                'lastName',
                'email',
                // 'role',
                // 'status',
                // 'meta',
                // 'company'
            ]
        ]
    ]);
});


it('can fetch a specific user', function () {
    // $company = Company::create([
    //     'name' => 'Test company',
    //     'address' => 'Kanaallaan 1b',
    //     'city' => 'Zandhoven',
    //     'zip' => '2240',
    //     'country' => 'Belgium'
    // ]);

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        //'role' => Role::EXPERT->value,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    // $user->meta()->create([
    //     'job_title' => 'Test engineer'
    // ]);

    // $user->company()->associate($company)->save();

    $response = $this->get("/api/v1/users/".$user->id);

    $response->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'firstName',
            'lastName',
            'email',
            //'role',
            //'status',
            //'meta',
            //'company'
        ]
    ])
    ->assertJson([
        'data' => [
            'id' => $user->id,
            'firstName' => 'Jan',
            'lastName' => 'Janssens',
            'email' => 'tester@digiti.be',
            // 'role' => Role::EXPERT->value,
            // 'status' => Status::AVAILABLE->value,
            // 'meta' => [
            //     'jobTitle' => 'Test engineer'
            // ],
            // 'company' => [
            //     'name' => 'Test company',
            //     'address' => 'Kanaallaan 1b',
            //     'city' => 'Zandhoven',
            //     'zip' => '2240',
            //     'country' => 'Belgium'
            // ]
        ]
    ]);
});

// it('can fetch filter a list of users by role', function () {
//     $company = Company::create([
//         'name' => 'Test company',
//         'address' => 'Kanaallaan 1b',
//         'city' => 'Zandhoven',
//         'zip' => '2240',
//         'country' => 'Belgium'
//     ]);

//     $user = User::create([
//         'first_name' => 'Jan',
//         'last_name' => 'Janssens',
//         'email' => 'tester@digiti.be',
//         'role' => Role::EXPERT->value,
//         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
//     ]);

//     User::create([
//         'first_name' => 'Peter',
//         'last_name' => 'Peeters',
//         'email' => 'peter@digiti.be',
//         'role' => Role::MATCHMAKER->value,
//         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
//     ]);

//     $user->meta()->create([
//         'job_title' => 'Test engineer'
//     ]);

//     $user->company()->associate($company)->save();

//     $response = $this->get("/api/v1/users?role[eq]=".Role::EXPERT->value);
//     $response->assertStatus(200)
//     ->assertJson([
//         'data' => [
//             [
//                 'id' => $user->id,
//                 'firstName' => 'Jan',
//                 'lastName' => 'Janssens',
//                 'email' => 'tester@digiti.be',
//                 //'role' => Role::EXPERT->value,
//                 //'status' => Status::AVAILABLE->value,
//                 'meta' => [
//                     'jobTitle' => 'Test engineer'
//                 ],
//                 'company' => [
//                     'name' => 'Test company',
//                     'address' => 'Kanaallaan 1b',
//                     'city' => 'Zandhoven',
//                     'zip' => '2240',
//                     'country' => 'Belgium'
//                 ]
//             ]
//         ]
//     ]);
// });

it('can store a new user', function () {
    $data = [
        'firstName' => 'Jan',
        'lastName' => 'Janssens',
        'email' => 'jan.janssens@digiti.be',
        //'role' => Role::EXPERT->value
    ];

    $response = $this->postJson('/api/v1/users', $data);
    $response->assertStatus(201);
    //$this->assertEquals('users', $data);
});

it('can\'t create a user with invalid data', function () {
    $data = [
        'firstName' => 'Jan',
        'lastName' => 'Janssens',
        'email' => 'notarealemail',
        //'role' => Role::EXPERT->value,
    ];

    $response = $this->postJson('/api/v1/users', $data);
    $response->assertStatus(422)->assertJson(['message' => 'The email field must be a valid email address.']);
    //$this->not()->assertDatabaseHas('users', $data);
});


it('can update a user with a put request', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        //'role' => Role::EXPERT->value,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'firstName' => 'Peter',
        'lastName' => 'Janssens',
        'email' => 'jan.janssens@digiti.be',
        //'role' => Role::EXPERT->value
    ];

    $response = $this->putJson('/api/v1/users/'.$user->id, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'id' => $user->id,
            'firstName' => 'Peter',
            'lastName' => 'Janssens',
            'email' => 'jan.janssens@digiti.be',
            //'role' => Role::EXPERT->value
        ]
    ]);
});

it('can\'t update a user with a put request when invalid data is given', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        //'role' => Role::EXPERT->value,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'firstName' => 'Peter',
        'lastName' => 'Janssens',
        'email' => 'jan.janssensdigiti.be',
        //'role' => Role::EXPERT->value
    ];

    $response = $this->putJson('/api/v1/users/'.$user->id, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The email field must be a valid email address.",
    ]);
});

it('can update a user with a patch request', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
       //'role' => Role::EXPERT->value,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'first_name' => 'Peter',
        'email' => 'jan.janssens@digiti.be'
    ];

    $response = $this->patchJson('/api/v1/users/'.$user->id, $data);
    $response->assertStatus(200)->assertJson([
        'data' => [
            'id' => $user->id,
            'firstName' => 'Peter',
            'lastName' => 'Janssens',
            'email' => 'jan.janssens@digiti.be',
            //'role' => Role::EXPERT->value
        ]
    ]);
});

it('can\'t update a user with a patch request when invalid data is given', function () {

    $user = User::create([
        'first_name' => 'Jan',
        'last_name' => 'Janssens',
        'email' => 'tester@digiti.be',
        //'role' => Role::EXPERT->value,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ]);

    $data = [
        'role' => 'TESTER',
    ];

    $response = $this->patchJson('/api/v1/users/'.$user->id, $data);
    $response->assertStatus(422)->assertJson([
        'message' => "The selected role is invalid.",
    ]);
});
