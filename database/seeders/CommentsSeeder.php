<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory(30)->create();

        for($i = 0; $i <= 20; $i++) {
            Comment::factory()->nested()->create();
        }
    }
}
