<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_fix_narudzbina_klijent_foreign_key.php
public function up()
{
    Schema::table('narudzbinas', function (Blueprint $table) {
        // 1. Prvo obriši staru constraitu (ako postoji)
        $table->dropForeign(['klijent_id']);

        // 2. Dodaj novu constraitu na pravu tabelu
        $table->foreign('klijent_id')
              ->references('id')
              ->on('klijents')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('narudzbinas', function (Blueprint $table) {
        $table->dropForeign(['klijent_id']);
    });
}
};
