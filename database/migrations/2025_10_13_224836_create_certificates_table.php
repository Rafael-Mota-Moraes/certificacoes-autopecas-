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

            $table->string('status')->default('pending_payment');

            $table->string('payment_id')->nullable();
            $table->text('qr_code_data')->nullable();
            $table->decimal('amount', 8, 2);
            $table->timestamp('payment_expires_at')->nullable();
            $table->string('file_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};