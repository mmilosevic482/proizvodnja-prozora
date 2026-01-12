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

        Schema::create('materijals', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->string('tip');
            $table->string('jedinica_mere');
            $table->decimal('trenutna_kolicina', 10, 2);
            $table->decimal('minimalna_kolicina', 10, 2);
            $table->decimal('cena_po_jedinici', 8, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materijals');
    }
};
