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

use PDO;
use Exception;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class ConexionTest extends TestCase
{
    public $conexion = 'mysql';

    public function setUp(): void
    {
        global $configGlobal;

        Configuracion::inicializar($configGlobal, $this->conexion);
    }

    public function testDeDefinicionDeConexion()
    {
        $pdo = PIPE::conexion('pgsql')->obtenerPDO();

        $this->assertEquals('pgsql', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    public function testDeFalloAlDefinirConexionInexistente()
    {
        $this->expectException(Exception::class);

        $pdo = PIPE::conexion('conexion_inexistente');
    }
}
