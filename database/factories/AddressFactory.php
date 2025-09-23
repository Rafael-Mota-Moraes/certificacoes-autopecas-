<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'number' => $this->faker->numberBetween(1, 100),
            'state' => $this->faker->stateAbbr(),
            'zip_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(-33, -2),
            'longitude' => $this->faker->longitude(-73, -34),
        ];
    }
}
