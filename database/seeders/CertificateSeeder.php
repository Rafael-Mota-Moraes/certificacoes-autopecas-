<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Reseller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {

        $minReviews = 100;
        $minPositivePercentage = 80;

        $eligibleResellers = Reseller::doesntHave('certificate')
            ->withCount('reviews')
            ->withCount(['reviews as positive_reviews_count' => function ($query) {
                $query->where('rating', '>=', 4);
            }])
            ->get()
            ->filter(function (Reseller $reseller) use ($minReviews, $minPositivePercentage) {

                if ($reseller->reviews_count < $minReviews) {
                    return false;
                }

                if ($reseller->reviews_count === 0) {
                    return false;
                }

                $positivePercentage = ($reseller->positive_reviews_count / $reseller->reviews_count) * 100;

                return $positivePercentage >= $minPositivePercentage;
            });

        if ($eligibleResellers->isEmpty()) {
            $this->command->warn('Nenhuma revendedora VÁLIDA (>= 100 reviews, >= 80% positivas) sem certificado encontrada.');
            return;
        }

        $totalEligibleCount = $eligibleResellers->count();


        $certifyCount = (int) ceil($totalEligibleCount / 2);
        $resellersToCertify = $eligibleResellers->take($certifyCount);
        $resellersToIgnoreCount = $totalEligibleCount - $certifyCount;


        $resellersCount = $resellersToCertify->count();
        if ($resellersCount === 0) {
            $this->command->info('Nenhum certificado a ser criado nesta execução.');
            return;
        }

        $paidCount = (int) ceil($resellersCount / 2);

        $resellersPaid = $resellersToCertify->take($paidCount);
        $resellersPending = $resellersToCertify->skip($paidCount);

        $certificatePrice = 99.90;

        $resellersPaid->each(function (Reseller $reseller) use ($certificatePrice) {
            Certificate::create([
                'reseller_id' => $reseller->id,
                'status' => 'paid',
                'amount' => $certificatePrice,
                'payment_provider_id' => 'paid_' . Str::random(12),
                'pix_qr_code' => null,
                'pix_emv' => null,
                'payment_expires_at' => null,
            ]);
        });

        $resellersPending->each(function (Reseller $reseller) use ($certificatePrice) {
            Certificate::create([
                'reseller_id' => $reseller->id,
                'status' => 'pending_payment',
                'amount' => $certificatePrice,
                'payment_provider_id' => 'pending_' . Str::random(12),
                'pix_qr_code' => 'dummy_base64_qr_code...' . Str::random(30),
                'pix_emv' => 'dummy_emv_copia_e_cola...' . Str::random(30),
                'payment_expires_at' => now()->addDays(3),
            ]);
        });

        $this->command->info(
            $resellersPaid->count() . ' certificados "paid" e ' .
                $resellersPending->count() . ' certificados "pending_payment" criados.'
        );
    }
}
