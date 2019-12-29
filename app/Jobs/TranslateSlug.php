<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        //the constructer receives the Topic model, but will only serialize the model's ID. When the queue job need the model, it will go to database and get it using the ID. This means the Topic mdoel we give here must be saved in database first (to generate the ID by database). So, in TopicObserver, we dispatch the job in "saved" function
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Send request to BAIDU API to tanslate
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        //if the translated slug is 'edit', the url will be 'http://jiaforum.test/topics/114/edit'
        //It will always be redirected to the edit page, we can add a -slug to it
        if(trim($slug) === 'edit'){
            $slug = $slug . '-slug';
        }

        //To avoid TopicObserver coming into dead loop(job calls save, save calls observer, observer dispatch job, job calls save), we use DB class to operate on database directly
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
