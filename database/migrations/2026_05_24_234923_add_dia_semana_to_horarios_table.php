<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->string('dia_semana')->after('cancha_id'); // lunes, martes, etc.
        });
    }

    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropColumn('dia_semana');
        });
    }
};