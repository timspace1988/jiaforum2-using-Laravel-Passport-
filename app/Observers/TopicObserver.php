<?php

namespace App\Observers;

use App\Models\Topic;
//use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

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


    }

    public function saved(Topic $topic){
        //If a topic has not got a slug, we will give one to it by translating the title
        //If a topic's title is changed, we also need to update its slug
        //isDirty(array|string|null $attr=null), check if the model's given attributes have been changed
        if(!$topic->slug || $topic->isDirty('title')){
            //$topic->slug = app(SlugTranslateHandler::Class)->translate($topic->title);
            dispatch(new TranslateSlug($topic));

        }

        //The priciple here is: after we saved the $topic instance, we update the slug.
        //The reason we dispatch the translation job after the $topic being saved
        //is to generate the Topic ID in database first, so that the queued job could use ID
        //to get the whole model from database
    }

    public function deleted(Topic $topic){
        //When a topic is deleted, we need to delete its all replies
        //Be careful, we should avoid using $topic->replies->delete()
        //Because it will trigger ReplyObserver, and call Topic to update its reply_count
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
