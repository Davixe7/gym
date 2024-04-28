<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        'name'   => fake()->name(),
        'age'    => fake()->numberBetween(18, 70),
        'dni'    => fake()->randomNumber(6, true),
        'phone'  => '57' . fake()->randomNumber(9)
      ];
    }
}
