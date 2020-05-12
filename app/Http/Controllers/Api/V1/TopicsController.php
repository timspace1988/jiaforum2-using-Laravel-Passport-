<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Queries\TopicQuery;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\V1\TopicRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TopicsController extends Controller
{
    //Create a new topic
    public function store(TopicRequest $request, Topic $topic){
        //Test throwing an error exception with error code 1003 (which is specified by us)
        //return $this->errorResponse(403, '您还没有通过认证', 1003);
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

    //Destroy a topic
    public function destroy(Topic $topic){
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }

    //Get topics list
    public function index(Request $request, TopicQuery $query){
        // $query = $topic->query();

        // if($categoryId = $request->category_id){
        //     $query->where('category_id', $categoryId);
        // }

        // $topics = $query->with('user', 'category')->withOrder($request->order)->paginate();


        // $topics = QueryBuilder::for(Topic::class)
        // //'user' and 'category' are relationship defined in Topic model
        //     ->allowedIncludes('user', 'category')
        //     ->allowedFilters([
        //         'title',//contains xx
        //         AllowedFilter::exact('category_id'),//exactly matches xx
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();

        $topics = $query->paginate();

        return TopicResource::collection($topics);
    }

    //Get a user's posts(topics) list
    public function userIndex(Request $request, User $user, TopicQuery $query){
        // $query = $user->topics()->getQuery();

        // $topics = QueryBuilder::for($query)
        //     ->allowedIncludes('user', 'category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();

        $topics = $query->where('user_id', $user->id)->paginate();
        return TopicResource::collection($topics);
    }

    // //Show a topic's detail (method 1)
    // public function show(Topic $topic){
    //     return new TopicResource($topic);
    // }

    //Show a topic's detail (method 2)
    public function show($topicId, TopicQuery $query){
        // $topic = QueryBuilder::for(Topic::class)
        //     ->allowedIncludes('user', 'category')
        //     ->findOrFail($topicId);

        $topic = $query->findOrFail($topicId);

        return new TopicResource($topic);
    }
}
