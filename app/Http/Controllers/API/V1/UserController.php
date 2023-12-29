<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\ConversationQuery;
use App\Filters\API\V1\MessageQuery;
use App\Filters\API\V1\UnitQuery;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Filters\API\V1\UserQuery;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Http\Resources\V1\ConversationCollection;
use App\Http\Resources\V1\MessageCollection;
use App\Http\Resources\V1\UnitCollection;
use App\Models\Message;

/**
 * @group Users
 */
class UserController extends Controller
{
    /**
     * List users
     */
    public function index(Request $request): UserCollection
    {
        $filter = new UserQuery();
        $queryItems = $filter->transform($request);
        return new UserCollection(User::where($queryItems)->with(['meta'])->get());
    }

    /**
     * Insert user
     * @apiResource App\Http\Resources\V1\UserResource
     * @apiResourceModel App\Models\User
     * @bodyParam firstName string required Example: Jan
     * @bodyParam lastName string required Example: Janssens
     * @bodyParam email string required Example: jan.janssens@digiti.be
     */
    public function store(StoreUserRequest $request): UserResource
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Get user
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->loadMissing(['meta']));
    }

    /**
     * Update user
     * @bodyParam firstName string required Example: Jan
     * @bodyParam lastName string required Example: Janssens
     * @bodyParam email string required Example: jan.janssens@digiti.be
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    /**
     * Get all conversations linked to a user
     */
    public function conversations(Request $request, User $user): ConversationCollection
    {
        $filter = new ConversationQuery();
        $queryItems = $filter->transform($request);
        return new ConversationCollection($user->conversations()->where($queryItems)->get());
    }

    /**
     * Get all conversations linked to a user
     */
    public function units(Request $request, User $user): UnitCollection
    {
        $filter = new UnitQuery();
        $queryItems = $filter->transform($request);
        return new UnitCollection($user->units()->where($queryItems)->with(['meta'])->get());
    }
}
