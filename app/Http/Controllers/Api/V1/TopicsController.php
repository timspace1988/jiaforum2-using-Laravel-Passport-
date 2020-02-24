<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\V1\TopicRequest;

class TopicsController extends Controller
{
    //Create a new topic
    public function store(TopicRequest $request, Topic $topic){
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    //Edit a current topic
    public function update(TopicRequest $request, Topic $topic){
        //Do the authorization using topic's update policy
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return new TopicResource($topic);

    }
}
