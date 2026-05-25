<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->string('latitud')->nullable()->after('direccion');
            $table->string('longitud')->nullable()->after('latitud');
            $table->text('embed_maps')->nullable()->after('longitud'); // El código embed de Google Maps
        });
    }

    public function down(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->dropColumn(['latitud', 'longitud', 'embed_maps']);
        });
    }
};