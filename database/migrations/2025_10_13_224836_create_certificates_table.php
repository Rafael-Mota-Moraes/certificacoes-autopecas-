<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->constrained()->onDelete('cascade');
            $table->string('payment_provider_id')->nullable();
            $table->text('pix_qr_code')->nullable();
            $table->string('status')->default('pending_payment');
            $table->decimal('amount', 8, 2);
            $table->string('pix_emv')->nullable();
            $table->timestamp('payment_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
