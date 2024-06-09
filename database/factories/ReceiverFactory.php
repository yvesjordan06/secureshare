<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Receiver;
use App\Models\Secret;

class ReceiverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receiver::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'secret_id' => Secret::factory(),
            'email' => $this->faker->safeEmail(),
            'access_code' => $this->faker->word(),
            'viewed_at' => $this->faker->dateTime(),
        ];
    }
}
