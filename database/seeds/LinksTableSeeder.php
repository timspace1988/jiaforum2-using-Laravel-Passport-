<?php

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Generate the fake data collection
        $links = factory(Link::class)->times(6)->make();

        //Convert the data collection to array and save into database
        Link::insert($links->toArray());
    }
}
