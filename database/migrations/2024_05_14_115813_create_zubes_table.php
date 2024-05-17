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
        Schema::create('zubes', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo')->unsigned();
            $table->text('descripciondelbien')->charset('utf8mb4');
            $table->decimal('valoractuallibros', 14, 4)->nullable()->default(0.0);
            $table->char('textofechacompra', 10)->nullable();
            $table->integer('ejercicio_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zubes');
    }
};
