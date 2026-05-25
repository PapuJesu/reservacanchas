<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->text('reglas')->nullable()->after('direccion');
            $table->text('informacion')->nullable()->after('reglas');
            $table->text('fotos')->nullable()->after('informacion'); // JSON array de fotos
        });
    }

    public function down(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->dropColumn(['reglas', 'informacion', 'fotos']);
        });
    }
};