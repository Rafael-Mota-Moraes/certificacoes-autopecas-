<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reseller;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Reseller::factory()
            ->count(20)
            ->hasAddress(1)   // Creates 1 address for the reseller
            ->hasContacts(2)  // Creates 2 contacts for the reseller
            ->create();
    }
}
