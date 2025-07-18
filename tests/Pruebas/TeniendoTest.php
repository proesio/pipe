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

use Modelos\Tema;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class TeniendoTest extends TestCase
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

    public function testDeDefinicionDeCondicionalHaving()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeCondicionalHaving();
        }
    }

    private function baseTestDeDefinicionDeCondicionalHaving()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')
            ->seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor(['titulo', 'descripcion'])
            ->teniendo('contar(*) > 2')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $temas);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::seleccionar('titulo', 'contar(*) alias cantidad')
            ->agruparPor(['titulo', 'descripcion'])
            ->teniendo('contar(*) > 2')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $temas);
    }

    private function generarRegistros()
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
