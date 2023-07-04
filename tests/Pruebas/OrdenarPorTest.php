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

class OrdenarPorTest extends TestCase
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

    public function testDeDefinicionDeOrdenamiento()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeOrdenamiento();
        }
    }

    public function testDeDefinicionDeOrdenamientoConTipo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeOrdenamientoConTipo();
        }
    }

    public function testDeDefinicionDeMultiplesOrdenamientos()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeMultiplesOrdenamientos();
        }
    }

    public function testDeDefinicionDeMultiplesOrdenamientosConTipo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeMultiplesOrdenamientosConTipo();
        }
    }

    private function baseTestDeDefinicionDeOrdenamiento()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->ordenarPor('titulo')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::ordenarPor('titulo')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);
    }

    private function baseTestDeDefinicionDeOrdenamientoConTipo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->ordenarPor('titulo', 'desc')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(2, $temas[0]->id);
        $this->assertEquals(5, $temas[5]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::ordenarPor('titulo', 'desc')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(2, $temas[0]->id);
        $this->assertEquals(5, $temas[5]->id);
    }

    private function baseTestDeDefinicionDeMultiplesOrdenamientos()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->ordenarPor(['titulo', 'descripcion'])
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::ordenarPor(['titulo', 'descripcion'])
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);
    }

    private function baseTestDeDefinicionDeMultiplesOrdenamientosConTipo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->ordenarPor(['titulo', 'descripcion'], 'desc')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::ordenarPor(['titulo', 'descripcion'], 'desc')
            ->obtener(PIPE::OBJETO);

        $this->assertEquals(5, $temas[0]->id);
        $this->assertEquals(2, $temas[5]->id);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema4', 'Tema4')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema6', 'Tema6')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema5', 'Tema5')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema3', 'Tema3')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema1', 'Tema1')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema2', 'Tema2')"
        );
    }
}
