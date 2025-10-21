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
        $this->command->info('Criando certificados para revendedoras...');

        $resellers = Reseller::doesntHave('certificate')->get();

        if ($resellers->isEmpty()) {
            $this->command->warn('Nenhuma revendedora sem certificado encontrada.');
            return;
        }

        $resellersCount = $resellers->count();
        $paidCount = ceil($resellersCount / 2);

        $resellersPaid = $resellers->take($paidCount);
        $resellersPending = $resellers->skip($paidCount);

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