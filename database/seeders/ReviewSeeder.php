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
        $allResellers = Reseller::all();
        $users = User::all();
        $groupedComments = Comment::all()->groupBy('rate');

        if ($allResellers->isEmpty() || $users->isEmpty() || $groupedComments->isEmpty()) {
            $this->command->warn('Certifique-se de que existem revendedoras, usuários e comentários predefinidos antes de rodar este seeder.');
            return;
        }

        $attachComments = function (Review $review) use ($groupedComments) {
            $rating = $review->rating;
            if ($groupedComments->has($rating)) {
                $commentIdsForRating = $groupedComments->get($rating)->pluck('id');
                $maxComments = min($commentIdsForRating->count(), 3);
                if ($maxComments < 1) return;
                $commentsToAttach = $commentIdsForRating->random(rand(1, $maxComments));
                $review->comments()->attach($commentsToAttach);
            }
        };


        $validCount = (int) ceil($allResellers->count() / 2);
        $validResellers = $allResellers->take($validCount);
        $invalidResellers = $allResellers->skip($validCount);

        $validResellers->each(function (Reseller $reseller) use ($attachComments) {
            $totalReviews = rand(110, 200);

            $positivePercentage = rand(80, 95) / 100;
            $positiveCount = (int) floor($totalReviews * $positivePercentage);
            $negativeCount = $totalReviews - $positiveCount;

            Review::factory()
                ->count($positiveCount)
                ->create([
                    'reseller_id' => $reseller->id,
                    'rating' => rand(4, 5)
                ])
                ->each($attachComments);

            Review::factory()
                ->count($negativeCount)
                ->create([
                    'reseller_id' => $reseller->id,
                    'rating' => rand(1, 3)
                ])
                ->each($attachComments);
        });

        $invalidResellers->each(function (Reseller $reseller) use ($attachComments) {
            Review::factory()
                ->count(rand(20, 150))
                ->create(['reseller_id' => $reseller->id])
                ->each($attachComments);
        });
    }
}
