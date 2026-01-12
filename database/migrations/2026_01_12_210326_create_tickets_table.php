<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            $table->string('type'); // Standard, VIP, etc.
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('price_cents'); // stored as cents

            $table->timestamps();

            $table->index(['event_id', 'price_cents']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
