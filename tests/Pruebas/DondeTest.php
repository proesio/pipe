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

class DondeTest extends TestCase
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

    public function testDeDefinicionDeCondicional()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeCondicional();
        }
    }

    public function testDeDefinicionDeCondicionalConParametros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeCondicionalConParametros();
        }
    }

    private function baseTestDeDefinicionDeCondicional()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->donde('id = 1')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $telefonos);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::donde('id = 1')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $telefonos);
    }

    private function baseTestDeDefinicionDeCondicionalConParametros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->donde('id = ?', [1])
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $telefonos);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::donde('id = ?', [1])
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $telefonos);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }
}
