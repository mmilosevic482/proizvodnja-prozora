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
    Schema::table('materijals', function (Blueprint $table) {
        $table->string('slika')->nullable()->after('opis'); // putanja do slike
    });
}

public function down(): void
{
    Schema::table('materijals', function (Blueprint $table) {
        $table->dropColumn('slika');
    });
}

};
