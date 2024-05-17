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
        Schema::create('registros', function (Blueprint $table) {
            $table->date('fecha');
            $table->integer('empnum')->unsigned()->nullable();
            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();
            $table->string('nombre', 50)->nullable();
            $table->primary(['fecha', 'empnum']);
            $table->foreign('fecha')->references('fecha')->on('fechas');
            $table->index('empnum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
