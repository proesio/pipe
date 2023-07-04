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

class IncrementarTest extends TestCase
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

    public function testDeIncrementacionDeValorDeCampo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeIncrementacionDeValorDeCampo();
        }
    }

    public function testDeIncrementacionDeValorDeCampoConValorDeIncrementoPersonalizado()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeIncrementacionDeValorDeCampoConValorDeIncrementoPersonalizado();
        }
    }

    private function baseTestDeIncrementacionDeValorDeCampo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        PIPE::tabla('telefonos')->incrementar('numero');

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertEquals(2, $telefono->numero);

        // Prueba de modelo.

        $this->generarRegistros();

        Telefono::incrementar('numero');

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(2, $telefono->numero);
    }

    private function baseTestDeIncrementacionDeValorDeCampoConValorDeIncrementoPersonalizado()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $incremento = PIPE::tabla('telefonos')->incrementar('numero', 2);

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertEquals(3, $telefono->numero);

        // Prueba de modelo.

        $this->generarRegistros();

        Telefono::incrementar('numero', 2);

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertEquals(3, $telefono->numero);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into telefonos (numero) values (1)"
        );
    }
}
