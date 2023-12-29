<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\ConversationQuery;
use App\Filters\API\V1\MessageQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreConversationRequest;
use App\Http\Requests\API\V1\UpdateConversationRequest;
use App\Http\Resources\V1\ConversationCollection;
use App\Http\Resources\V1\ConversationResource;
use App\Http\Resources\V1\MessageCollection;
use App\Http\Resources\V1\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ConversationCollection
    {
        $filter = new ConversationQuery();
        $queryItems = $filter->transform($request);
        return new ConversationCollection(Conversation::where($queryItems)->with('latestMessage')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConversationRequest $request): ConversationResource
    {
        $conversation = Conversation::create($request->all());
        $conversation->users()->sync($request->get('users'));

        return new ConversationResource($conversation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation): ConversationResource
    {
        return new ConversationResource($conversation->load('latestMessage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConversationRequest $request, Conversation $conversation): ConversationResource
    {
        $conversation->update($request->all());

        //Update users if array is present
        if($request->has("users")){
            $conversation->users()->sync($request->get('users'));
        }

        return new ConversationResource($conversation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();

        return response()->json(['message' => 'Conversation deleted successfully.']);
    }

    /**
     * Get all messages from a conversation
     */
    public function messages(Request $request, Conversation $conversation): MessageCollection
    {
        $filter = new MessageQuery();
        $queryItems = $filter->transform($request);
        return new MessageCollection($conversation->messages()->where($queryItems)->get());
    }

    /**
     * Post a new message in a specific conversation with the logged in user as owner
     */
    public function addMessage(Request $request, Conversation $conversation): MessageResource
    {
        $request->merge([
            'user_uuid' => auth()->id(),
            'conversation_uuid' => $conversation->uuid
        ]);

        $message = Message::create($request->all());
        return new MessageResource($message);
    }
}
