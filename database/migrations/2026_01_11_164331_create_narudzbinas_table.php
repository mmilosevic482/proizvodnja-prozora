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
        Schema::disableForeignKeyConstraints();

        Schema::create('narudzbinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klijent_id')->constrained('klijentis');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('broj_narudzbine')->unique();
            $table->date('datum_narudzbine');
            $table->date('rok_isporuke');
            $table->string('status')->default('nova');
            $table->decimal('ukupna_cena', 10, 2);
            $table->text('napomena')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narudzbinas');
    }
};
