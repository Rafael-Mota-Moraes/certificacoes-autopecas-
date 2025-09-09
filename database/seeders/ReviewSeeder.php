<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Reseller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $resellers = Reseller::all();
        $users = User::all();
        $commentIds = Comment::pluck('id');

        if ($resellers->isEmpty() || $users->isEmpty() || $commentIds->isEmpty()) {
            $this->command->warn('Certifique-se de que existem revendedoras, usuários e comentários predefinidos antes de rodar este seeder.');
            return;
        }

        $this->command->info('Criando reviews e associando comentários...');

        $resellers->each(function (Reseller $reseller) use ($commentIds) {
            Review::factory()
                ->count(rand(2, 10))
                ->create(['reseller_id' => $reseller->id])
                ->each(function (Review $review) use ($commentIds) {
                    $commentsToAttach = $commentIds->random(rand(1, 3));
                    $review->comments()->attach($commentsToAttach);
                });
        });
    }
}