<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
         'Atendimento ruim',
         'Falta de transparência',
         'Carro em más condições',
         'Preço fora da realidade',
         'Não recomendo',
         'Atendimento lento',
         'Pouca atenção ao cliente',
         'Carro com detalhes não informados',
         'Preço poderia ser melhor',
         'Experiência abaixo do esperado',
         'Atendimento razoável',
         'Carro em condições medianas',
         'Preço justo, mas atendimento pode melhorar',
         'Processo de compra regular',
         'Experiência ok, mas nada excepcional',
         'Atendimento atencioso',
         'Carro em bom estado',
         'Preço competitivo',
         'Negociação transparente',
         'Boa experiência de compra',
         'Atendimento excelente',
         'Carro impecável',
         'Ótimo custo-benefício',
         'Revendedora confiável',
         'Experiência perfeita, recomendo'
        ];

        $rate = 0;
        foreach ($comments as $i => $comment) {
            if ($i % 5 == 0) $rate += 1;
            Comment::create(['comment' => $comment,'rate' => $rate]);
        }
    }
}