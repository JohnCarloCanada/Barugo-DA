<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DogInformation>
 */
class DogInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Dog_Name' => fake()->name(),
            'Owner_Name' => fake()->name(),
            'Species' => 'Aspin',
            'Sex' => fake()->randomElement(['male', 'female']),
            'Age' => 3,
            'Neutering' => fake()->randomElement(['Yes', 'No']),
            'Color' => 'Black',
            'Date_of_Registration' => now(),
        ];
    }
}
