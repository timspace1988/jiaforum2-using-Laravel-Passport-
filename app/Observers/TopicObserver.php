<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic){
        //before save into database, we filter the content in topic's body using HTMLPurifier
        $topic->body = clean($topic->body, 'user_topic_body');

        //
        $topic->excerpt = make_excerpt($topic->body);

        //If a topic has not got a slug, we will give one to it by translating the title
        if(! $topic->slug){
            $topic->slug = app(SlugTranslateHandler::Class)->translate($topic->title);
        }
    }
}
