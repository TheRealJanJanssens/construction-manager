<?php

use App\Models\Phase;
use App\Models\Project;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //dd(Phase::all()[0]->children()->get());
    //dd(Unit::first()->projects()->get());
    //dd(Project::all()[0]->phases()->get()[0]->project()->get());

    return view('welcome');
});


/*

Spatie Roles and permissions manager

$user = User::find(1);
$user->assignRole('admin');

if ($user->hasRole('admin')) {
    // do something
}

if ($user->can('view users')) {
    // do something
}

Route::middleware('role:admin')->get('/users', function () {
    // ...
});

*/
