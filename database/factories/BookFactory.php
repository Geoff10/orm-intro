<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => Author::factory(),
            'title' => $this->faker->sentence,
            'genre' => $this->faker->word,
            'release_date' => $this->faker->date,
        ];
    }
}
