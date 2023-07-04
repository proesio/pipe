<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  5.1.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use Modelos\Telefono;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\ConstructorConsulta;

class CrearTest extends TestCase
{
    public $conexiones = [
        'mysql', 'pgsql', 'sqlite', 'sqlsrv'
    ];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        global $configGlobal;

        $this->configGlobal = $configGlobal;
    }

    public function testDeCreacionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeCreacionDeRegistro();
        }
    }

    public function testDeCreacionDeVariosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeCreacionDeVariosRegistros();
        }
    }

    private function baseTestDeCreacionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        $telefono = Telefono::crear(['numero' => 1234567890]);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertObjectHasAttribute('id', $telefono);
        $this->assertObjectHasAttribute('numero', $telefono);
        $this->assertObjectHasAttribute('creado_en', $telefono);
        $this->assertObjectHasAttribute('actualizado_en', $telefono);
    }

    private function baseTestDeCreacionDeVariosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        $telefonos = Telefono::crear(
            [
                ['numero' => 1234567890],
                ['numero' => 9876543210]
            ]
        );

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertObjectHasAttribute('id', $telefonos[0]);
        $this->assertObjectHasAttribute('numero', $telefonos[0]);
        $this->assertObjectHasAttribute('creado_en', $telefonos[0]);
        $this->assertObjectHasAttribute('actualizado_en', $telefonos[0]);
    }
}
