<?php

namespace Database\Factories\Dms;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Dms\Document;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Dms\Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->paragraph,
            'document_id' =>  Document::all()->random()->id,
            'commenter_id' =>  User::all()->random()->id,
        ];
    }
}
