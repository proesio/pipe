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
use Modelos\EliminacionSuave\Telefono as Telefono1;

class EliminarTest extends TestCase
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

    public function testDeEliminacionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionDeRegistro();
        }
    }

    public function testDeEliminacionMasivaDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionMasivaDeRegistros();
        }
    }

    public function testDeEliminacionSuaveDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionSuaveDeRegistro();
        }
    }

    public function testDeEliminacionSuaveForzadaDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionSuaveForzadaDeRegistro();
        }
    }

    public function testDeEliminacionSuaveMasivaDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionSuaveMasivaDeRegistros();
        }
    }

    public function testDeEliminacionSuaveMasivaForzadaDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEliminacionSuaveMasivaForzadaDeRegistros();
        }
    }

    private function baseTestDeEliminacionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest1();

        $resultado = PIPE::tabla('telefonos')
            ->donde('id = ?', [1])
            ->eliminar();

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertNull($telefono);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $resultado = Telefono::donde('id = ?', [1])
            ->eliminar();

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertNull($telefono);
    }

    private function baseTestDeEliminacionMasivaDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest2();

        $resultado = PIPE::tabla('telefonos')->eliminar();

        $telefonos = PIPE::tabla('telefonos')->obtener(PIPE::OBJETO);

        $this->assertEquals(2, $resultado);
        $this->assertCount(0, $telefonos);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $resultado = Telefono::eliminar();

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertEquals(2, $resultado);
        $this->assertCount(0, $telefonos);
    }

    private function baseTestDeEliminacionSuaveDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $resultado1 = Telefono1::donde('id = ?', [1])
            ->eliminar();

        $telefono1 = Telefono1::primero(PIPE::OBJETO);

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado1);
        $this->assertNull($telefono1);
        $this->assertNotNull($telefono->eliminado_en);
    }

    private function baseTestDeEliminacionSuaveForzadaDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $resultado1 = Telefono1::donde('id = ?', [1])
            ->eliminar(true);

        $telefono1 = Telefono1::primero(PIPE::OBJETO);

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado1);
        $this->assertNull($telefono1);
        $this->assertNull($telefono);
    }

    private function baseTestDeEliminacionSuaveMasivaDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $resultado1 = Telefono1::eliminar();

        $telefonos1 = Telefono1::todo(PIPE::OBJETO);

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertEquals(2, $resultado1);
        $this->assertCount(0, $telefonos1);
        $this->assertCount(2, $telefonos);
    }

    private function baseTestDeEliminacionSuaveMasivaForzadaDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $resultado1 = Telefono1::eliminar(true);

        $telefonos1 = Telefono1::todo(PIPE::OBJETO);

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertEquals(2, $resultado1);
        $this->assertCount(0, $telefonos1);
        $this->assertCount(0, $telefonos);
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
