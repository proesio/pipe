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
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class EliminarTest extends TestCase
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
