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

class MinimoTest extends TestCase
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

    public function testDeObtencionDeValorMinimo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorMinimo();
        }
    }

    public function testDeObtencionDeValorMinimoDefiniendoCondicion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorMinimoDefiniendoCondicion();
        }
    }

    private function baseTestDeObtencionDeValorMinimo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')->minimo('numero');

        $this->assertEquals(1, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::minimo('numero');

        $this->assertEquals(1, $cantidad);
    }

    private function baseTestDeObtencionDeValorMinimoDefiniendoCondicion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')
            ->donde('numero in(?, ?)', [2, 3])
            ->minimo('numero');

        $this->assertEquals(2, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::donde('numero in(?, ?)', [2, 3])
            ->minimo('numero');

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
