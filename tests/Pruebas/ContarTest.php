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

class ContarTest extends TestCase
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

    public function testDeConteoDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConteoDeRegistros();
        }
    }

    public function testDeConteoDeRegistrosDefiniendoCampo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConteoDeRegistrosDefiniendoCampo();
        }
    }

    public function testDeConteoDeRegistrosDefiniendoCondicion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConteoDeRegistrosDefiniendoCondicion();
        }
    }

    private function baseTestDeConteoDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')->contar();

        $this->assertEquals(3, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::contar();

        $this->assertEquals(3, $cantidad);
    }

    private function baseTestDeConteoDeRegistrosDefiniendoCampo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')->contar('numero');

        $this->assertEquals(2, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::contar('numero');

        $this->assertEquals(2, $cantidad);
    }

    private function baseTestDeConteoDeRegistrosDefiniendoCondicion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $cantidad = PIPE::tabla('telefonos')
            ->donde('numero es no nulo')
            ->contar();

        $this->assertEquals(2, $cantidad);

        // Prueba de modelo.

        $this->generarRegistros();

        $cantidad = Telefono::donde('numero es no nulo')
            ->contar();

        $this->assertEquals(2, $cantidad);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (null)"
        );
    }
}
