<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //An array contains all users' id
        $user_ids = User::all()->pluck('id')->toArray();

        //An array contains all catogeries's id
        $category_ids = Category::all()->pluck('id')->toArray();

        //Get Faker instance
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
                            ->times(100)
                            ->make()
                            ->each(function ($topic, $index)
                                use ($user_ids, $category_ids, $faker){
                                    //give this topic a random user id
                                    $topic->user_id = $faker->randomElement($user_ids);
                                    //give this topic a random category id
                                    $topic->category_id = $faker->randomElement($category_ids);
                                });
        //convert topics set to array and insert into database
        Topic::insert($topics->toArray());
    }

}

