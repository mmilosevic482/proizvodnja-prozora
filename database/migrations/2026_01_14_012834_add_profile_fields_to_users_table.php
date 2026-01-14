<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefon')->nullable()->after('email');
            $table->string('adresa')->nullable()->after('telefon');
            $table->string('grad')->nullable()->after('adresa');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefon', 'adresa', 'grad']);
        });
    }
};
