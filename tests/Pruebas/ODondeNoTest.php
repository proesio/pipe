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

class ODondeNoTest extends TestCase
{
    public $conexiones = [];

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDefinicionDeCondicionalJSON()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', 1)
                ->oDondeNo('config->propiedad->subpropiedad', 'Valor2')
                ->primero(PIPE::OBJETO);

            $config = json_decode($usuario->config);

            $this->assertEquals('Valor1', $config->propiedad->subpropiedad);

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', 2)
                ->oDondeNo('config->propiedad->subpropiedad', '=', 'Valor1')
                ->primero(PIPE::OBJETO);

            $config = json_decode($usuario->config);

            $this->assertEquals('Valor2', $config->propiedad->subpropiedad);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', 1)
                ->oDondeNo('config->propiedad->subpropiedad', 'Valor2')
                ->primero(PIPE::OBJETO);

            $config = json_decode($usuario->config);

            $this->assertEquals('Valor1', $config->propiedad->subpropiedad);

            $usuario = Usuario::donde('id', 2)
                ->oDondeNo(
                    'config->propiedad->subpropiedad', '=', 'Valor1'
                )->primero(PIPE::OBJETO);

            $config = json_decode($usuario->config);

            $this->assertEquals('Valor2', $config->propiedad->subpropiedad);
        }
    }

    public function testDeDefinicionDeCondicionalBasico()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', 1)
                ->oDondeNo('nombres', 'Nombre2')
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', '>', 1)
                ->oDondeNo('nombres', '<>', 'Nombre2')
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre2', $usuario->nombres);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', 1)
                ->oDondeNo('nombres', 'Nombre2')
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);

            $usuario = Usuario::donde('id', '>', 1)
                ->oDondeNo('nombres', '<>', 'Nombre2')
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre2', $usuario->nombres);
        }
    }

    public function testDeDefinicionDeCondicionalArreglo()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', '<>', 2)
                ->oDondeNo([['id', 2], ['nombres', '=', 'Nombre2']])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Apellido1', $usuario->apellidos);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', '<>', 2)
                ->oDondeNo([['id', 2], ['nombres', '=', 'Nombre2']])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Apellido1', $usuario->apellidos);
        }
    }

    public function testDeDefinicionDeCondicionalMatriz()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', '<>', 2)
                ->oDondeNo(['id' => 2, 'nombres' => 'Nombre2'])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Apellido1', $usuario->apellidos);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', '<>', 2)
                ->oDondeNo(['id' => 2, 'nombres' => 'Nombre2'])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Apellido1', $usuario->apellidos);
        }
    }

    public function testDeDefinicionDeCondicionalClosure()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', 1)
                ->oDondeNo(
                    function ($consulta) {
                        $consulta->donde('nombres', 'Nombre2')
                            ->oDonde('apellidos', 'Apellido2');
                    }
                )->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', 1)
                ->oDondeNo(
                    function ($consulta) {
                        $consulta->donde('nombres', 'Nombre2')
                            ->oDonde('apellidos', 'Apellido2');
                    }
                )->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);
        }
    }

    private function _generarRegistros()
    {
        vaciarTablas();

        generarRegistros('telefonos', 2);
        generarRegistros('usuarios', 2);
    }
}
