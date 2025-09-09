<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            'Ótimo atendimento',
            'Boa localização',
            'Atendimento demorado',
        ];

        foreach ($comments as $comment) {
            Comment::create(['comment' => $comment]);
        }
    }
}