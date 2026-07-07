<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        if (! Schema::hasTable('rollen')) {
            Schema::create('rollen', function (Blueprint $table) {
                $table->id();
                $table->string('naam', 50)->unique();
                $table->string('omschrijving', 255)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('gebruikers')) {
            Schema::create('gebruikers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rol_id')->constrained('rollen')->restrictOnDelete()->cascadeOnUpdate();
                $table->string('voornaam', 100);
                $table->string('achternaam', 100);
                $table->string('email')->unique();
                $table->string('telefoon', 30)->nullable();
                $table->string('wachtwoord');
                $table->boolean('actief')->default(true);
                $table->dateTime('laatste_login')->nullable();
                $table->timestamps();

                $table->index('rol_id');
            });
        }

        if (! Schema::hasTable('klanten')) {
            Schema::create('klanten', function (Blueprint $table) {
                $table->id();
                $table->foreignId('gebruiker_id')->unique()->constrained('gebruikers')->cascadeOnDelete()->cascadeOnUpdate();
                $table->date('geboortedatum')->nullable();
                $table->string('adresregel1')->nullable();
                $table->string('adresregel2')->nullable();
                $table->string('postcode', 20)->nullable();
                $table->string('plaats', 100)->nullable()->index();
                $table->string('land', 100)->nullable();
                $table->text('algemene_notities')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('klant_kenmerken')) {
            Schema::create('klant_kenmerken', function (Blueprint $table) {
                $table->id();
                $table->foreignId('klant_id')->constrained('klanten')->cascadeOnDelete()->cascadeOnUpdate();
                $table->enum('type', ['voorkeur', 'allergie', 'wens', 'medisch']);
                $table->string('titel', 150);
                $table->text('beschrijving')->nullable();
                $table->boolean('actief')->default(true);
                $table->timestamps();

                $table->index('type');
            });
        }

        if (! Schema::hasTable('producten')) {
            Schema::create('producten', function (Blueprint $table) {
                $table->id();
                $table->string('naam', 150)->unique();
                $table->string('sku', 100)->nullable()->unique();
                $table->text('beschrijving')->nullable();
                $table->integer('voorraad_aantal')->default(0);
                $table->string('eenheid', 30)->nullable();
                $table->decimal('kostprijs', 10, 2)->nullable();
                $table->decimal('verkoopprijs', 10, 2)->nullable();
                $table->boolean('actief')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        Schema::dropIfExists('producten');
        Schema::dropIfExists('klant_kenmerken');
        Schema::dropIfExists('klanten');
        Schema::dropIfExists('gebruikers');
        Schema::dropIfExists('rollen');
    }
};
