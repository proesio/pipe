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

class PromedioTest extends TestCase
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

    public function testDeObtencionDePromedio()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDePromedio();
        }
    }

    public function testDeObtencionDePromedioDefiniendoCondicion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDePromedioDefiniendoCondicion();
        }
    }

    private function baseTestDeObtencionDePromedio()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')->promedio('numero');

        $this->assertEquals(2, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::promedio('numero');

        $this->assertEquals(2, $cantidad);
    }

    private function baseTestDeObtencionDePromedioDefiniendoCondicion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $valorEsperado = 2.5;

        if ($this->conexion == 'sqlsrv') {
            $valorEsperado = 2;
        }

        $cantidad = PIPE::tabla('telefonos')
            ->donde('numero in(?, ?)', [2, 3])
            ->promedio('numero');

        $this->assertEquals($valorEsperado, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $valorEsperado = 2.5;

        if ($this->conexion == 'sqlsrv') {
            $valorEsperado = 2;
        }

        $cantidad = Telefono::donde('numero in(?, ?)', [2, 3])
            ->promedio('numero');

        $this->assertEquals($valorEsperado, $cantidad);
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
