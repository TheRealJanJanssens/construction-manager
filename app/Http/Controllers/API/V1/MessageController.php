<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\MessageQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UpdateMessageRequest;
use App\Http\Resources\V1\MessageCollection;
use App\Http\Resources\V1\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * Note: This isn't a very usefull call fo a user. Maybe for an admin?
     */
    public function index(Request $request): MessageCollection
    {
        $filter = new MessageQuery();
        $queryItems = $filter->transform($request);
        return new MessageCollection(Message::where($queryItems)->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message): MessageResource
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message): MessageResource
    {
        $message->update($request->only('content'));

        return new MessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     * Note: Should be admin only?
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully.']);
    }
}
