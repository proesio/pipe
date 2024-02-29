<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  5.1.6
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use Modelos\Telefono;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\ConstructorConsulta;

class DestruirTest extends TestCase
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
