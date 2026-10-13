<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->string('xendit_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('amount');
            $table->string('description')->nullable();
            $table->string('status')->default('PENDING');
            $table->text('invoice_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
