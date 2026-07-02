<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('klant_kenmerken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->constrained('klanten')->onDelete('cascade');
            $table->string('type'); // 'allergie' or 'wens'
            $table->text('beschrijving');
            $table->boolean('actief')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klant_kenmerken');
    }
};
