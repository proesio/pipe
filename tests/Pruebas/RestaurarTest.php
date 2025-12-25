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

use PIPE\PIPE;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;
use Modelos\EliminacionSuave\Telefono as Telefono1;

class RestaurarTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeRestauracionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeRestauracionDeRegistro();
        }
    }

    public function testDeRestauracionMasivaDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeRestauracionMasivaDeRegistros();
        }
    }

    private function baseTestDeRestauracionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        Telefono1::donde('id = ?', [1])->eliminar();

        $telefono1 = Telefono1::encontrar(1);

        $this->assertNull($telefono1);

        Telefono1::donde('id = ?', [1])->restaurar();

        $telefono1 = Telefono1::encontrar(1);

        $this->assertNotNull($telefono1);
    }

    private function baseTestDeRestauracionMasivaDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        Telefono1::eliminar();

        $telefonos1 = Telefono1::todo(PIPE::OBJETO);

        $this->assertCount(0, $telefonos1);

        Telefono1::restaurar();

        $telefonos1 = Telefono1::todo(PIPE::OBJETO);

        $this->assertCount(2, $telefonos1);
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
