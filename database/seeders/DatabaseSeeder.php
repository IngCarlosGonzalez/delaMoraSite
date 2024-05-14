<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Estado;
use App\Models\Periodo;
use App\Models\Ejercicio;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $this->call(UsuarioSeeder::class);

        Ejercicio::create(
            [
                'id' => 2023,
                'aadesde' => '2023/01/01',
                'aahasta' => '2023/12/31',
                'activos' => 0.0,
            ]
        );
        Ejercicio::create(
            [
                'id' => 2024,
                'aadesde' => '2024/01/01',
                'aahasta' => '2024/12/31',
                'activos' => 0.0,
            ]
        );

        Periodo::create(
            [
                'id' => 1,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'ENERO',
            ]
        );
        Periodo::create(
            [
                'id' => 2,
                'mmdesde' => '01',
                'mmhasta' => '28',
                'titulo'  => 'FEBRERO',
            ]
        );
        Periodo::create(
            [
                'id' => 3,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'MARZO',
            ]
        );
        Periodo::create(
            [
                'id' => 4,
                'mmdesde' => '01',
                'mmhasta' => '30',
                'titulo'  => 'ABRIL',
            ]
        );
        Periodo::create(
            [
                'id' => 5,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'MAYO',
            ]
        );
        Periodo::create(
            [
                'id' => 6,
                'mmdesde' => '01',
                'mmhasta' => '30',
                'titulo'  => 'JUNIO',
            ]
        );
        Periodo::create(
            [
                'id' => 7,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'JULIO',
            ]
        );
        Periodo::create(
            [
                'id' => 8,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'AGOSTO',
            ]
        );
        Periodo::create(
            [
                'id' => 9,
                'mmdesde' => '01',
                'mmhasta' => '30',
                'titulo'  => 'SEPTIEMBRE',
            ]
        );
        Periodo::create(
            [
                'id' => 10,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'OCTUBRE',
            ]
        );
        Periodo::create(
            [
                'id' => 11,
                'mmdesde' => '01',
                'mmhasta' => '30',
                'titulo'  => 'NOVIEMBRE',
            ]
        );
        Periodo::create(
            [
                'id' => 12,
                'mmdesde' => '01',
                'mmhasta' => '31',
                'titulo'  => 'DICIEMBRE',
            ]
        );

        Estado::create(
            [
                'estatus'  => 'NUEVO',
            ]
        );
        Estado::create(
            [
                'estatus'  => 'BUENO',
            ]
        );
        Estado::create(
            [
                'estatus'  => 'REGULAR',
            ]
        );
        Estado::create(
            [
                'estatus'  => 'DEFICIENTE',
            ]
        );
        Estado::create(
            [
                'estatus'  => 'BAJA',
            ]
        );

        Proveedor::create(
            [
                'abrev'  => 'INDEFINIDO',
                'nombre'  => 'INDEFINIDO',
            ]
        );

    }
}
