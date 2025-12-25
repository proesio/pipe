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
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class SentenciaTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeEjecucionDeSentenciaEnEspanol()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEjecucionDeSentenciaEnEspanol();
        }
    }

    private function baseTestDeEjecucionDeSentenciaEnEspanol()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $respuesta = PIPE::sentencia(
            'insertar dentro telefonos (numero) valores (1234567890)'
        );

        $this->assertEquals(1, $respuesta);
    }
}
