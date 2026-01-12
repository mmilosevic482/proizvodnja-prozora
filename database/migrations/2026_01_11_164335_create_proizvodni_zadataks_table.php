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

        Schema::create('proizvodni_zadataks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stavka_narudzbine_id')->constrained('stavke_narudzbines');
            $table->foreignId('user_id')->constrained();
            $table->string('operacija');
            $table->dateTime('datum_pocetka')->nullable();
            $table->dateTime('datum_zavrsetka')->nullable();
            $table->string('status')->default('na_cekanju');
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
        Schema::dropIfExists('proizvodni_zadataks');
    }
};
