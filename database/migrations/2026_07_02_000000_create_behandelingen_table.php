<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behandelingen', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('type');
            $table->unsignedSmallInteger('duur_minuten');
            $table->decimal('prijs', 8, 2);
            $table->text('beschrijving')->nullable();
            $table->text('aanvullende_informatie')->nullable();
            $table->boolean('actief')->default(true);
            $table->timestamps();

            $table->index(['type', 'actief']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behandelingen');
    }
};
