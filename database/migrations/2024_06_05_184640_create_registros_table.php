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
            $table->id();
            $table->date('fecha');
            $table->integer('empnum')->unsigned()->nullable();
            $table->string('nombre', 50)->nullable();
            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();
            $table->index('fecha');
            $table->index('empnum');
            $table->index(['fecha', 'empnum']);
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
