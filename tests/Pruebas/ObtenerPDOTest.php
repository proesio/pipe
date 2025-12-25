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

use PDO;
use PIPE\PIPE;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class ObtenerPDOTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDePDO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDePDO();
        }
    }

    private function baseTestDeObtencionDePDO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $pdo = PIPE::obtenerPDO();

        $this->assertInstanceOf(PDO::class, $pdo);
    }
}
