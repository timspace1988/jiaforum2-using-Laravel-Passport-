<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => 'Notes',
                'description' => 'Learning and developing notes',
            ],
            [
                'name' => 'Share',
                'description' => 'Share new findings',
            ],
            [
                'name' => 'Tutorial',
                'description' => 'Programming skills and packages'
            ],
            [
                'name' => 'Blog',
                'description' => 'Lifestyle, shopping, travel'
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();//ttuncate will clear all data in selected table
    }
}
