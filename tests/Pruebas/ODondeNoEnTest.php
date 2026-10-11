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

class ODondeNoEnTest extends TestCase
{
    public $conexiones = [];

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDefinicionDeCondicionalBasico()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuario = PIPE::tabla('usuarios')
                ->donde('id', '<>', 2)
                ->oDondeNoEn('id', [1])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);

            // Prueba de modelo.

            $usuario = Usuario::donde('id', '<>', 2)
                ->oDondeNoEn('id', [1])
                ->primero(PIPE::OBJETO);

            $this->assertEquals('Nombre1', $usuario->nombres);
        }
    }

    public function testDeDefinicionDeCondicionalSubconsulta()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuarios = PIPE::tabla('usuarios')
                ->donde('id', 1)
                ->oDondeNoEn('id', 'seleccionar usuario_id de temas')
                ->obtener(PIPE::OBJETO);

            $this->assertCount(1, $usuarios);

            // Prueba de modelo.

            $usuarios = Usuario::donde('id', 1)
                ->oDondeNoEn('id', 'seleccionar usuario_id de temas')
                ->obtener(PIPE::OBJETO);

            $this->assertCount(1, $usuarios);
        }
    }

    public function testDeDefinicionDeCondicionalSubconsultaYParametros()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuarios = PIPE::tabla('usuarios')
                ->donde('id', 1)
                ->oDondeNoEn(
                    'id', 'seleccionar usuario_id de temas donde titulo = ?',
                    ['Titulo1']
                )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);

            // Prueba de modelo.

            $usuarios = Usuario::donde('id', 1)
                ->oDondeNoEn(
                    'id', 'seleccionar usuario_id de temas donde titulo = ?',
                    ['Titulo1']
                )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);
        }
    }

    private function _generarRegistros()
    {
        vaciarTablas();

        generarRegistros('telefonos', 2);
        generarRegistros('usuarios', 2);
        generarRegistros('temas', 2);
    }
}
