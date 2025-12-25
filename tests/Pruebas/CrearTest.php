<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  7.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use Modelos\Telefono;
use PIPE\Configuracion;
use PIPE\ConstructorConsulta;
use PHPUnit\Framework\TestCase;

class CrearTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
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
        $this->assertObjectHasProperty('id', $telefono);
        $this->assertObjectHasProperty('numero', $telefono);
        $this->assertObjectHasProperty('creado_en', $telefono);
        $this->assertObjectHasProperty('actualizado_en', $telefono);
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
        $this->assertObjectHasProperty('id', $telefonos[0]);
        $this->assertObjectHasProperty('numero', $telefonos[0]);
        $this->assertObjectHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectHasProperty('actualizado_en', $telefonos[0]);
    }
}
