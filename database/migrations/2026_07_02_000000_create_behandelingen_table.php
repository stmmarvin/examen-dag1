<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Maakt de tabel voor mijn behandeling CRUD.
        Schema::create('behandelingen', function (Blueprint $table) {
            $table->id();
            $table->string('naam', 150);
            $table->string('type', 100);
            $table->text('beschrijving')->nullable();
            $table->integer('duur_minuten');
            $table->decimal('prijs', 10, 2);
            $table->boolean('actief')->default(true);
            $table->timestamps();

            // Zelfde indexen als in de nieuwe SQL database.
            $table->index('type');
            $table->index('naam');
            $table->fullText(['naam', 'beschrijving']);
        });
    }

    public function down(): void
    {
        // Verwijdert de tabel als de migratie wordt teruggedraaid.
        Schema::dropIfExists('behandelingen');
    }
};
