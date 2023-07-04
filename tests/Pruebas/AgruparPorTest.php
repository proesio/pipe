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

class AgruparPorTest extends TestCase
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

    public function testDeDefinicionDeAgrupacion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeAgrupacion();
        }
    }

    public function testDeDefinicionDeMultiplesAgrupaciones()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeMultiplesAgrupaciones();
        }
    }

    private function baseTestDeDefinicionDeAgrupacion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest1();

        $temas = PIPE::tabla('temas')
            ->seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor('titulo')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        $temas = Tema::seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor('titulo')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);
    }

    private function baseTestDeDefinicionDeMultiplesAgrupaciones()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest2();

        $temas = PIPE::tabla('temas')
            ->seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor(['titulo', 'descripcion'])
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $temas);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        $temas = Tema::seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor(['titulo', 'descripcion'])
            ->obtener(PIPE::OBJETO);

        $this->assertCount(3, $temas);
    }

    private function generarRegistrosTest1()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema1', 'Tomo1')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema1', 'Tomo2')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema1', 'Tomo3')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema2', 'Tomo1')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema2', 'Tomo2')"
        );
    }

    private function generarRegistrosTest2()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema3', 'Tema3')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema3', 'Tema3')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema3', 'Tema3')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema2', 'Tema2')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema2', 'Tema2')"
        );

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Tema1', 'Tema1')"
        );
    }
}
