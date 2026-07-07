<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_id')->unique()->nullable();
            $table->decimal('montant', 10, 2);
            $table->string('devise')->default('TND');
            $table->enum('methode', ['stripe', 'paypal', 'carte', 'virement'])->default('stripe');
            $table->enum('statut', ['en_attente', 'complete', 'echoue', 'rembourse'])->default('en_attente');
            $table->text('details')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};