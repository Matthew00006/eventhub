<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('venue_id')
                ->constrained('venues')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['venue_id', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
