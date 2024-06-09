<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Secret;
use App\Models\User;

class SecretFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Secret::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(),
            'delete_when_viewed' => $this->faker->boolean(),
            'valid_until' => $this->faker->dateTime(),
            'stat_access_code' => $this->faker->word(),
        ];
    }
}
