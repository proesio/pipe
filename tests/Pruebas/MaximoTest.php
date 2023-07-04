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

class MaximoTest extends TestCase
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

    public function testDeObtencionDeValorMaximo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorMaximo();
        }
    }

    public function testDeObtencionDeValorMaximoDefiniendoCondicion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorMaximoDefiniendoCondicion();
        }
    }

    private function baseTestDeObtencionDeValorMaximo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')->maximo('numero');

        $this->assertEquals(3, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::maximo('numero');

        $this->assertEquals(3, $cantidad);
    }

    private function baseTestDeObtencionDeValorMaximoDefiniendoCondicion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')
            ->donde('numero in(?, ?)', [1, 2])
            ->maximo('numero');

        $this->assertEquals(2, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::donde('numero in(?, ?)', [1, 2])
            ->maximo('numero');

        $this->assertEquals(2, $cantidad);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (1)"
        );

        $pdo->exec(
            "insert into telefonos (numero) values (2)"
        );

        $pdo->exec(
            "insert into telefonos (numero) values (3)"
        );
    }
}
