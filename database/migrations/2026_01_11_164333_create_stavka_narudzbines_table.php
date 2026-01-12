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

        Schema::create('stavka_narudzbines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('narudzbina_id')->constrained('narudzbines');
            $table->foreignId('proizvod_id')->constrained('proizvodis');
            $table->decimal('sirina', 5, 2);
            $table->decimal('visina', 5, 2);
            $table->integer('kolicina');
            $table->string('boja')->nullable();
            $table->text('napomena')->nullable();
            $table->decimal('cena', 10, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stavka_narudzbines');
    }
};
