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
use PIPE\Clases\Excepciones\ORM;

class ConfiguracionTest extends TestCase
{
    public function testDeUnicaConexion()
    {
        global $configGlobal;

        Configuracion::inicializar($configGlobal['mysql']);

        $pdo = PIPE::obtenerPDO();

        $this->assertInstanceOf(PDO::class, $pdo);
    }

    public function testDeMultipleConexion()
    {
        global $configGlobal;

        Configuracion::inicializar($configGlobal, 'mysql');

        $pdo = PIPE::obtenerPDO();

        $this->assertInstanceOf(PDO::class, $pdo);
    }

    public function testDeMultiplesConexiones()
    {
        global $configGlobal;

        Configuracion::inicializar($configGlobal['mysql']);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('mysql', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));

        Configuracion::inicializar($configGlobal['pgsql']);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('pgsql', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));

        Configuracion::inicializar($configGlobal['sqlite']);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('sqlite', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));

        Configuracion::inicializar($configGlobal['sqlsrv']);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('sqlsrv', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    public function testDeFalloAlIniciarConfigIncorrectamenteCaso1()
    {
        $this->expectException(Exception::class);

        global $configGlobal;

        Configuracion::inicializar($configGlobal);
    }

    public function testDeFalloAlIniciarConfigIncorrectamenteCaso2()
    {
        $this->expectException(Exception::class);

        global $configGlobal;

        Configuracion::inicializar($configGlobal, 'mariadb');
    }

    public function testDeFalloAlIniciarConfigIncorrectamenteCaso3()
    {
        $this->expectException(Exception::class);

        Configuracion::inicializar('mysql', 'mysql');
    }

    public function testDeFalloAlIniciarConfigIncorrectamenteCaso4()
    {
        $this->expectException(Exception::class);

        Configuracion::inicializar([], 'mysql');
    }

    public function testDeFalloAlIniciarConfigIncorrectamenteCaso5()
    {
        $this->expectException(Exception::class);

        Configuracion::inicializar('mysql');
    }

    public function testDeControladorDesconocido()
    {  
        $this->expectException(ORM::class);

        global $configGlobal;

        $configGlobalPivote = $configGlobal;
        $configGlobalPivote['mysql']['BD_CONTROLADOR'] = 'oci';

        Configuracion::inicializar($configGlobalPivote, 'mysql'); 
    }

    public function testDeFalloAlDetectarIdiomaDesconocido()
    {  
        $this->expectException(ORM::class);

        global $configGlobal;

        $configGlobalPivote = $configGlobal;
        $configGlobalPivote['mysql']['IDIOMA'] = 'fr';

        Configuracion::inicializar($configGlobalPivote, 'mysql'); 
    }

    public function testDeFalloAlDetectarRutaModelosInexistente()
    {  
        $this->expectException(ORM::class);

        global $configGlobal;

        $configGlobalPivote = $configGlobal;
        $configGlobalPivote['mysql']['RUTA_MODELOS'] = __DIR__.'/Modelos';

        Configuracion::inicializar($configGlobalPivote, 'mysql'); 
    }
}
