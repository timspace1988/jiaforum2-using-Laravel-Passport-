<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Topic;
use App\Models\Reply;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\V1\ReplyRequest;
use App\Http\Queries\ReplyQuery;

class RepliesController extends Controller
{
    //Get a topic's replies list
    public function index($topicId, ReplyQuery $query){
        //$replies = $topic->replies()->paginate();

        $replies = $query->where('topic_id', $topicId)->paginate();

        return ReplyResource::collection($replies);
    }

    //Get a user's replies list
    public function userIndex($userId, ReplyQuery $query){
        $replies = $query->where('user_id', $userId)->paginate();

        return ReplyResource::collection($replies);
    }

    //Create a reply
    public function store(ReplyRequest $request, Topic $topic, Reply $reply){
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }

    //Delete a reply
    public function destroy(Topic $topic, Reply $reply){
        //If the reply's topic_id doesn't match the topic we specified on url, show not found
        if($reply->topic_id != $topic->id){
            abort(404);
        }

        //Authorize with th policy we created
        $this->authorize('destroy', $reply);
        $reply->delete();

        return response(null, 204);
    }
}
