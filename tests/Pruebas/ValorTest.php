<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  8.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use PIPE\PIPE;
use Modelos\Usuario;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class ValorTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDeValor()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValor();
        }
    }

    public function testDeObtencionDeValorNuloPorCampoInexistente()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorNuloPorCampoInexistente();
        }
    }

    public function testDeObtencionDeValorNuloPorCampoNoSeleccionado()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeValorNuloPorCampoNoSeleccionado();
        }
    }

    private function baseTestDeObtencionDeValor()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion, true);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $valor = PIPE::tabla('usuarios')->dondeCrudo('id = ?', [1])->valor('nombres');

        $this->assertEquals('Nombre1', $valor);

        // Prueba de modelo.

        $this->generarRegistros();

        $valor = Usuario::dondeCrudo('id = ?', [1])->valor('nombres');

        $this->assertEquals('Nombre1', $valor);
    }

    private function baseTestDeObtencionDeValorNuloPorCampoInexistente()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion, true);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $valor = PIPE::tabla('usuarios')->dondeCrudo('id = ?', [1])->valor(
            'campo_inexistente'
        );

        $this->assertNull($valor);

        // Prueba de modelo.

        $this->generarRegistros();

        $valor = Usuario::dondeCrudo('id = ?', [1])->valor(
            'campo_inexistente'
        );

        $this->assertNull($valor);
    }

    private function baseTestDeObtencionDeValorNuloPorCampoNoSeleccionado()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion, true);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $valor = PIPE::tabla('usuarios')
            ->seleccionar('apellidos')
            ->dondeCrudo('id = ?', [1])
            ->valor('nombres');

        $this->assertNull($valor);

        // Prueba de modelo.

        $this->generarRegistros();

        $valor = Usuario::seleccionar('apellidos')
            ->dondeCrudo('id = ?', [1])
            ->valor('nombres');

        $this->assertNull($valor);
    }

    private function generarRegistros()
    {
        vaciarTablas();

        generarRegistros('telefonos', 1);
        generarRegistros('usuarios', 1);
    }
}
