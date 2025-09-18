<?php

namespace Database\Factories\Dms;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Dms\Document;
use App\Models\Dms\Status;
use App\Models\User;
use Faker\Generator as Faker;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Dms\Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subject = $this->faker->sentence(2);

        return [
            'subject' => rtrim($subject, '.'),
            'content' => $this->faker->paragraph,
            'excerpt' => $this->faker->paragraph(1),
            'document_date' => now(),
            'status_id' =>  Status::all()->random()->id,
            'user_id' =>  User::all()->random()->id,
        ];
    }
}
