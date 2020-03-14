<?php

namespace App\Http\Queries;

use App\Models\Reply;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ReplyQuery extends QueryBuilder
{
    public function __construct(){
        parent::__construct(Reply::query());
        //include 'user' means include reply's related user(reply author)
        //include 'topic' means include reply's related topic
        //include 'topic.user' means includ the related topic and topic's related user(topic author) data, on url, use '?include=topic.user' to get topic info with user data
        $this->allowedIncludes('user', 'topic', 'topic.user');
    }
}
