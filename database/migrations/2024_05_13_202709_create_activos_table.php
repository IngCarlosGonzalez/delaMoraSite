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
        Schema::create('activos', function (Blueprint $table) {
            $table->id();

            $table->integer('refer')->unsigned();
            $table->integer('codigo')->unsigned();
            $table->text('descripciondelbien')->charset('utf8mb4');
            $table->decimal('valoractuallibros', 14, 4)->nullable()->default(0.0);
            $table->date('fechacompra')->nullable();
            $table->foreignId('ejercicio_id')->nullable()->default(2000)->constrained();

            $table->string('lainstitucion', 60)->nullable()->charset('utf8mb4');
            $table->string('numinventario', 20)->nullable();
            $table->decimal('montounitario', 14, 4)->nullable()->default(0.0);
            $table->string('administradora', 60)->nullable()->charset('utf8mb4');
            $table->date('fechaactualiza')->nullable();
            $table->string('anotaciones', 60)->nullable()->default('');
         
            $table->boolean('tiene_foto_resg')->default(0);
            $table->string('foto_de_resguardo', 255)->nullable();
            $table->string('nombre_foto_resg', 255)->nullable();

            $table->string('entreganombre1', 60)->nullable();
            $table->string('entregapuesto1', 60)->nullable();
            $table->string('entreganombre2', 60)->nullable();
            $table->string('entregapuesto2', 60)->nullable();

            $table->date('fechaentregado')->nullable();
            $table->string('entregadoletras', 36)->nullable();

            $table->integer('numeroderesguardo')->unsigned()->nullable();
            $table->integer('ejercicioresguado')->unsigned()->nullable();
            $table->string('cxadenaresguardo', 12)->nullable();
         
            $table->foreignId('proveedor_id')->nullable()->default(1)->constrained();
            $table->string('proveedor_abrev', 20)->charset('utf8mb4');
            $table->string('proveedor_nombre', 80)->charset('utf8mb4');

            $table->string('numerofactura', 20)->nullable();
            $table->date('fechafactura')->nullable();
            $table->string('numeropedido', 20)->nullable();

            $table->string('areadeadscripcion', 60)->nullable()->charset('utf8mb4');
            $table->string('nombreresguardante', 60)->nullable()->charset('utf8mb4');
            $table->string('puestoresguardante', 60)->nullable()->charset('utf8mb4');

            $table->text('descripciondetallada')->charset('utf8mb4');

            $table->string('ubicacionactual', 80)->nullable()->charset('utf8mb4');    
            $table->foreignId('estado_id')->nullable()->default(1)->constrained();
            $table->string('causadelabaja', 60)->nullable()->charset('utf8mb4');
            $table->date('fechadelabaja')->nullable();

            $table->boolean('tiene_foto_ext1')->default(0);
            $table->string('la_foto_extra_1', 255)->nullable();
            $table->string('nombre_foto_ext1', 255)->nullable();
            $table->boolean('tiene_foto_ext2')->default(0);
            $table->string('la_foto_extra_2', 255)->nullable();
            $table->string('nombre_foto_ext2', 255)->nullable();
            $table->boolean('tiene_foto_ext3')->default(0);
            $table->string('la_foto_extra_3', 255)->nullable();
            $table->string('nombre_foto_ext3', 255)->nullable();
            $table->boolean('tiene_foto_ext4')->default(0);
            $table->string('la_foto_extra_4', 255)->nullable();
            $table->string('nombre_foto_ext4', 255)->nullable();
            $table->boolean('tiene_foto_ext5')->default(0);
            $table->string('la_foto_extra_5', 255)->nullable();
            $table->string('nombre_foto_ext5', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
