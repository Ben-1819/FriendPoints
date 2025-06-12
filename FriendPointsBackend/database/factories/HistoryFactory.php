<?php

namespace Database\Factories;

use App\Models\Friend;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "friend_id" => Friend::factory(),
            "title" => $this->faker->words(1, true),
            "reason" => $this->faker->words(10, true),
            "before" => $this->faker->number(),
            "after" => $this->faker->number(),
            "change" => $this->faker->number(),
        ];
    }
}
