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

use Modelos\Usuario;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class ObtenerEliminacionSuaveTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDeEliminacionSuave()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeEliminacionSuave();
        }
    }

    private function baseTestDeObtencionDeEliminacionSuave()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $eliminacionSuave = Usuario::obtenerEliminacionSuave();

        $this->assertSame(false, $eliminacionSuave);
    }
}
