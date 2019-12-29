<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class RepliesTableSeeder extends Seeder
{
    public function run()
    {
        //All users' id array
        $user_ids = User::all()->pluck('id')->toArray();

        //All topics' id array
        $topic_ids = Topic::all()->pluck('id')->toArray();

        //Get an instance of Faker
        $faker = app(Faker\Generator::class);

        $replies = factory(Reply::class)
                        ->times(1000)
                        ->make()
                        ->each(function ($reply, $index) use($user_ids, $topic_ids, $faker) {
                            //Randomly get a value from user_ids and assign it to $reply->user_id
                            $reply->user_id = $faker->randomElement($user_ids);
                            //Randomly get a value from topic_ids and assign it to $reply->user_id
                            $reply->topic_id = $faker->randomElement($topic_ids);
                        });

        //conver the data set to array and insert into database
        Reply::insert($replies->toArray());
    }

}

