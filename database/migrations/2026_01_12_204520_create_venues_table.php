<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('city');
            $table->string('country');
            $table->string('address')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            // Helpful for filtering/search
            $table->index(['city', 'country']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
