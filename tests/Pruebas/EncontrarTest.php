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
use PIPE\Clases\ConstructorConsulta;

class EncontrarTest extends TestCase
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

    public function testDeObtencionDeRegistroPorLlavePrimaria()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistroPorLlavePrimaria();
        }
    }

    public function testDeObtencionDeRegistroPorLlavePrimariaPersonalizada()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistroPorLlavePrimariaPersonalizada();
        }
    }

    public function testDeObtencionDeVariosRegistrosPorLlavePrimaria()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeVariosRegistrosPorLlavePrimaria();
        }
    }

    public function testDeObtencionDeVariosRegistrosPorLlavePrimariaPersonalizada()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeVariosRegistrosPorLlavePrimariaPersonalizada();
        }
    }

    public function testDeNullCuandoNoSeObtieneRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeNullCuandoNoSeObtieneRegistro();
        }
    }

    public function testDeNullCuandoNoSeObtienenVariosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeNullCuandoNoSeObtienenVariosRegistros();
        }
    }

    private function baseTestDeObtencionDeRegistroPorLlavePrimaria()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->encontrar(1);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::encontrar(1);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
    }

    private function baseTestDeObtencionDeRegistroPorLlavePrimariaPersonalizada()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->encontrar(1, 'id');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::encontrar(1, 'id');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
    }

    private function baseTestDeObtencionDeVariosRegistrosPorLlavePrimaria()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->encontrar([1, 2]);

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::encontrar([1, 2]);

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);
    }

    private function baseTestDeObtencionDeVariosRegistrosPorLlavePrimariaPersonalizada()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->encontrar([1, 2], 'id');

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::encontrar([1, 2], 'id');

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);
    }

    private function baseTestDeNullCuandoNoSeObtieneRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->encontrar(3);

        $this->assertNull($telefono);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::encontrar(3);

        $this->assertNull($telefono);
    }

    private function baseTestDeNullCuandoNoSeObtienenVariosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->encontrar([3, 1]);

        $this->assertNull($telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::encontrar([3, 1]);

        $this->assertNull($telefonos[0]);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[1]);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
