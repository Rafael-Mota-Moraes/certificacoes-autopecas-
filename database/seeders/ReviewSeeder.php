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

        $groupedComments = Comment::all()->groupBy('rate');

        if ($resellers->isEmpty() || $users->isEmpty() || $groupedComments->isEmpty()) {
            $this->command->warn('Certifique-se de que existem revendedoras, usuários e comentários predefinidos antes de rodar este seeder.');
            return;
        }

        $this->command->info('Criando reviews e associando comentários correspondentes à nota...');

        $resellers->each(function (Reseller $reseller) use ($groupedComments) {
            Review::factory()
                ->count(rand(20, 150))
                ->create(['reseller_id' => $reseller->id])
                ->each(function (Review $review) use ($groupedComments) {

                    $rating = $review->rating;

                    if ($groupedComments->has($rating)) {

                        $commentIdsForRating = $groupedComments->get($rating)->pluck('id');

                        $maxComments = min($commentIdsForRating->count(), 3);
                        if ($maxComments < 1) return;
                        $commentsToAttach = $commentIdsForRating->random(rand(1, $maxComments));

                        $review->comments()->attach($commentsToAttach);
                    }
                });
        });
    }
}