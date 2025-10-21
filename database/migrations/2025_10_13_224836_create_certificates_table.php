<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->constrained()->onDelete('cascade');

            $table->string('status')->default('pending_payment');
            $table->decimal('amount', 8, 2);
            $table->timestamp('payment_expires_at')->nullable();

            // --- CAMPOS CORRIGIDOS PARA BATER COM O CONTROLLER ---

            // 1. Renomeado de 'payment_id' para 'payment_provider_id'
            $table->string('payment_provider_id')->nullable()->comment('ID do pagamento no AbacatePay');

            // 2. Renomeado de 'qr_code_data' para 'pix_qr_code' (e mudei para text)
            $table->text('pix_qr_code')->nullable()->comment('QR Code PIX em Base64');

            // 3. Adicionado o 'pix_emv'
            $table->text('pix_emv')->nullable()->comment('PIX Copia e Cola (BR Code)');

            // --- Outros campos ---
            $table->string('file_path')->nullable()->comment('Caminho para o PDF do certificado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};