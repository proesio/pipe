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

use Modelos\Tema;
use Modelos\Telefono;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class VaciarTest extends TestCase
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

    public function testDeTruncadoDeTabla()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeTruncadoDeTabla();
        }
    }

    public function testDeTruncadoForzadoDeTabla()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeTruncadoForzadoDeTabla();
        }
    }

    private function baseTestDeTruncadoDeTabla()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest1();

        $resultado = PIPE::tabla('temas')->vaciar();

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Titulo1', 'Descripcion1')"
        );

        $tema = PIPE::tabla('temas')->ultimo(PIPE::OBJETO);

        $this->assertTrue($resultado);
        $this->assertEquals(1, $tema->id);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $resultado = Tema::vaciar();

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Titulo1', 'Descripcion1')"
        );

        $tema = Tema::ultimo(PIPE::OBJETO);

        $this->assertTrue($resultado);
        $this->assertEquals(1, $tema->id);
    }

    private function baseTestDeTruncadoForzadoDeTabla()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest2();

        $resultado = PIPE::tabla('telefonos')->vaciar(true);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (1234567890)"
        );

        $telefono = PIPE::tabla('telefonos')->ultimo(PIPE::OBJETO);

        $this->assertTrue($resultado);
        $this->assertEquals(1, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $resultado = Telefono::vaciar(true);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (1234567890)"
        );

        $telefono = Telefono::ultimo(PIPE::OBJETO);

        $this->assertTrue($resultado);
        $this->assertEquals(1, $telefono->id);
    }

    private function generarRegistrosTest1()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
        generarRegistros($this->conexion, 'usuarios', 2);
        generarRegistros($this->conexion, 'temas', 2);
    }

    private function generarRegistrosTest2()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
        generarRegistros($this->conexion, 'usuarios', 2);
    }
}
