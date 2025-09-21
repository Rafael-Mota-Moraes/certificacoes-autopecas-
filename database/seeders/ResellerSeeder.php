<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reseller;

class ResellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reseller::factory()->count(50)->create();
    }
}
