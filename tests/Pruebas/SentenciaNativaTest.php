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

use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class SentenciaNativaTest extends TestCase
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

    public function testDeEjecucionDeSentenciaNativa()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeEjecucionDeSentenciaNativa();
        }
    }

    private function baseTestDeEjecucionDeSentenciaNativa()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $respuesta = PIPE::sentenciaNativa(
            'insert into telefonos (numero) values (0987654321)'
        );

        $this->assertEquals(1, $respuesta);
    }
}
