<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Post::class, 500)->create();

        $categories = \App\Models\Categories::all();

        \App\Models\Post::all()->each(function($post) use ($categories){
            $post->category()->attach(
                $categories->random(rand(1,3))->pluck('id')->toArray()
            );
        });
    }
}
