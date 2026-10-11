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

use Exception;
use PIPE\PIPE;
use Modelos\Usuario;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class ConexionTest extends TestCase
{
    public $conexion = 'mysql';

    public function setUp(): void
    {
        Configuracion::inicializar($GLOBALS['CONFIG_GLOBAL'], $this->conexion);
    }

    public function testDeDefinicionDeConexion()
    {
        $this->_generarRegistros();

        // Prueba de constructor de consulta.

        PIPE::conexion('pgsql')->tabla('usuarios')->insertar(
            [
                'telefono_id' => 1,
                'nombres' => 'pgsql',
                'apellidos' => 'pgsql'
            ]
        );

        $usuario = PIPE::conexion('pgsql')->tabla('usuarios')->encontrar(1);

        $this->assertEquals('pgsql', $usuario->nombres);

        // Prueba de modelo.

        Usuario::conexion('sqlsrv')->insertar(
            [
                'telefono_id' => 1,
                'nombres' => 'sqlsrv',
                'apellidos' => 'sqlsrv'
            ]
        );

        $usuario = Usuario::conexion('sqlsrv')->encontrar(1);

        $this->assertEquals('sqlsrv', $usuario->nombres);
    }

    public function testDeFalloAlDefinirConexionInexistentePorContructor()
    {
        $this->expectException(Exception::class);

        PIPE::conexion('conexion_inexistente');
    }

    public function testDeFalloAlDefinirConexionInexistentePorModelo()
    {
        $this->expectException(Exception::class);

        Usuario::conexion('conexion_inexistente');
    }

    private function _generarRegistros()
    {
        foreach ($GLOBALS['CONEXIONES'] as $conexion) {
            Configuracion::inicializar(
                $GLOBALS['CONFIG_GLOBAL'], $conexion, true
            );

            vaciarTablas();

            generarRegistros('telefonos', 1);
        }
    }
}
