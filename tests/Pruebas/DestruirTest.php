<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP versión 8. 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  6.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use Modelos\Telefono;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\ConstructorConsulta;
use Modelos\EliminacionSuave\Telefono as Telefono1;

class DestruirTest extends TestCase
{
    public $conexiones = [
        'mysql', 'pgsql', 'sqlite', 'sqlsrv'
    ];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDestruccionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDestruccionDeRegistro();
        }
    }

    public function testDeDestruccionDeVariosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDestruccionDeVariosRegistros();
        }
    }

    public function testDeDestruccionSuaveDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDestruccionSuaveDeRegistro();
        }
    }

    public function testDeDestruccionSuaveDeVariosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDestruccionSuaveDeVariosRegistros();
        }
    }

    private function baseTestDeDestruccionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest1();

        $telefono = Telefono::destruir(1);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertObjectHasProperty('id', $telefono);
        $this->assertObjectHasProperty('numero', $telefono);
        $this->assertObjectHasProperty('creado_en', $telefono);
        $this->assertObjectHasProperty('actualizado_en', $telefono);
    }

    private function baseTestDeDestruccionDeVariosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest2();

        $telefonos = Telefono::destruir([1, 3, 2]);

        $this->assertCount(3, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertNull($telefonos[1]);
        $this->assertObjectHasProperty('id', $telefonos[0]);
        $this->assertObjectHasProperty('numero', $telefonos[0]);
        $this->assertObjectHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectHasProperty('actualizado_en', $telefonos[0]);
    }

    private function baseTestDeDestruccionSuaveDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest1();

        $telefono1 = Telefono1::destruir(1);

        $telefonos1 = Telefono1::todo(PIPE::OBJETO);

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono1);
        $this->assertObjectHasProperty('id', $telefono1);
        $this->assertObjectHasProperty('numero', $telefono1);
        $this->assertObjectHasProperty('creado_en', $telefono1);
        $this->assertObjectHasProperty('actualizado_en', $telefono1);
        $this->assertCount(0, $telefonos1);
        $this->assertCount(1, $telefonos);
    }

    private function baseTestDeDestruccionSuaveDeVariosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest2();

        $telefonos1 = Telefono1::destruir([1, 3, 2]);

        $telefonos2 = Telefono1::todo(PIPE::OBJETO);

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertCount(3, $telefonos1);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos1[0]);
        $this->assertNull($telefonos1[1]);
        $this->assertObjectHasProperty('id', $telefonos1[0]);
        $this->assertObjectHasProperty('numero', $telefonos1[0]);
        $this->assertObjectHasProperty('creado_en', $telefonos1[0]);
        $this->assertObjectHasProperty('actualizado_en', $telefonos1[0]);
        $this->assertCount(0, $telefonos2);
        $this->assertCount(2, $telefonos);
    }

    private function generarRegistrosTest1()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }

    private function generarRegistrosTest2()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
