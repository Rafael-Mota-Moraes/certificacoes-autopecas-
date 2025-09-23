<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Reseller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reseller::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'cnpj' => $this->faker->unique()->numerify('##############'),
            'photo' => null,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Reseller $reseller) {
            Address::factory()->create([
                'reseller_id' => $reseller->id,
            ]);

            Contact::factory()->create([
                'reseller_id' => $reseller->id,
            ]);
        });
    }
}
