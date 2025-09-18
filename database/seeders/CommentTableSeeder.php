<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dms\Comment;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->count(1000)->create();
    }
}
