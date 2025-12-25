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
use Modelos\Telefono;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class LimiteTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDefinicionDeLimite()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeLimite();
        }
    }

    public function testDeDefinicionDeLimiteConCantidad()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeLimiteConCantidad();
        }
    }

    public function testDeDefinicionDeLimiteConCantidadYOrdenamiento()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeLimiteConCantidadYOrdenamiento();
        }
    }

    private function baseTestDeDefinicionDeLimite()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->limite(3)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(3, $telefonos[2]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::limite(3)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(3, $telefonos[2]->id);
    }

    private function baseTestDeDefinicionDeLimiteConCantidad()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->limite(3, 2)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(5, $telefonos[2]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::limite(3, 2)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(5, $telefonos[2]->id);
    }

    private function baseTestDeDefinicionDeLimiteConCantidadYOrdenamiento()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->ordenarPor('id', 'desc')
            ->limite(3, 2)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(1, $telefonos[2]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ordenarPor('id', 'desc')
            ->limite(3, 2)
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $telefonos);
        $this->assertEquals(1, $telefonos[2]->id);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 5);
    }
}
