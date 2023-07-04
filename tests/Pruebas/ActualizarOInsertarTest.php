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
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class ActualizarOInsertarTest extends TestCase
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

    public function testDeActualizacionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionDeRegistro();
        }
    }

    public function testDeInsercionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistro();
        }
    }

    private function baseTestDeActualizacionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest1();

        $resultado = PIPE::tabla('temas')
            ->actualizarOInsertar(
                ['titulo' => 'Titulo1', 'descripcion' => 'Descripcion1'],
                ['titulo' => 'Titulo2']
            );

        $tema = PIPE::tabla('temas')->primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertEquals('Titulo2', $tema->titulo);
        $this->assertNotNull($tema->actualizado_en);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $resultado = Tema::actualizarOInsertar(
            ['titulo' => 'Titulo1', 'descripcion' => 'Descripcion1'],
            ['titulo' => 'Titulo2']
        );

        $tema = Tema::primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertEquals('Titulo2', $tema->titulo);
        $this->assertNotNull($tema->actualizado_en);
    }

    private function baseTestDeInsercionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest2();

        $resultado = PIPE::tabla('temas')
            ->actualizarOInsertar(
                ['titulo' => 'Titulo1', 'descripcion' => 'Descripcion1'],
                ['usuario_id' => 1]
            );

        $tema = PIPE::tabla('temas')->primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertIsObject($tema);
        $this->assertEquals(1, $tema->usuario_id);
        $this->assertEquals('Titulo1', $tema->titulo);
        $this->assertEquals('Descripcion1', $tema->descripcion);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $resultado = Tema::actualizarOInsertar(
            ['titulo' => 'Titulo1', 'descripcion' => 'Descripcion1'],
            ['usuario_id' => 1]
        );

        $tema = Tema::primero(PIPE::OBJETO);

        $this->assertEquals(1, $resultado);
        $this->assertIsObject($tema);
        $this->assertEquals(1, $tema->usuario_id);
        $this->assertEquals('Titulo1', $tema->titulo);
        $this->assertEquals('Descripcion1', $tema->descripcion);
    }

    private function generarRegistrosTest1()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Titulo1', 'Descripcion1')"
        );
    }

    private function generarRegistrosTest2()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
    }
}
