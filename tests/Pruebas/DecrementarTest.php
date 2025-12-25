<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  7.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use PIPE\PIPE;
use Modelos\Telefono;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class DecrementarTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDecrementacionDeValorDeCampo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDecrementacionDeValorDeCampo();
        }
    }

    public function testDeDecrementacionDeValorDeCampoConValorDeDecrementoPersonalizado()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDecrementacionDeValorDeCampoConValorDeDecrementoPersonalizado();
        }
    }

    private function baseTestDeDecrementacionDeValorDeCampo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest1();

        PIPE::tabla('telefonos')->decrementar('numero');

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertEquals(1, $telefono->numero);

        // Prueba de modelo.

        $this->generarRegistrosTest1();

        Telefono::decrementar('numero');

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(1, $telefono->numero);
    }

    private function baseTestDeDecrementacionDeValorDeCampoConValorDeDecrementoPersonalizado()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistrosTest2();

        $incremento = PIPE::tabla('telefonos')->decrementar('numero', 2);

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertEquals(1, $telefono->numero);

        // Prueba de modelo.

        $this->generarRegistrosTest2();

        Telefono::decrementar('numero', 2);

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(1, $telefono->numero);
    }

    private function generarRegistrosTest1()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (2)"
        );
    }

    private function generarRegistrosTest2()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (3)"
        );
    }
}
