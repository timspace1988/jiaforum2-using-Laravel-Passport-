<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Topic;
use App\Models\Reply;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\V1\ReplyRequest;

class RepliesController extends Controller
{
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
