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

        Schema::create('proizvods', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->text('opis');
            $table->string('tip');
            $table->decimal('standardna_sirina', 5, 2)->nullable();
            $table->decimal('standardna_visina', 5, 2)->nullable();
            $table->decimal('cena_po_m2', 8, 2);
            $table->boolean('aktivna')->default(true);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proizvods');
    }
};
