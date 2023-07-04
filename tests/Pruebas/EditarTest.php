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

class EditarTest extends TestCase
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

    public function testDeEdicionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEdicionDeRegistro();
        }
    }

    public function testDeEdicionDeVariosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEdicionDeVariosRegistros();
        }
    }

    private function baseTestDeEdicionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest1();

        $telefono = Telefono::editar(1, ['numero' => 1234567890]);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(1234567890, $telefono->numero);
    }

    private function baseTestDeEdicionDeVariosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistrosTest2();

        $telefonos = Telefono::editar(
            [1, 3, 2],
            ['numero' => 1234567890]
        );

        $this->assertCount(3, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertNull($telefonos[1]);
        $this->assertEquals(1234567890, $telefonos[0]->numero);
        $this->assertEquals(1234567890, $telefonos[2]->numero);
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
