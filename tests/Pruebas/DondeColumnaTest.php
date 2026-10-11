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

class DondeColumnaTest extends TestCase
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

            $usuarios = PIPE::tabla('usuarios')
                ->dondeColumna('id', 'telefono_id')
                ->dondeColumna('creado_en', '=', 'actualizado_en')
                ->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);

            // Prueba de modelo.

            $usuarios = Usuario::dondeColumna('id', 'telefono_id')
                ->dondeColumna('creado_en', '=', 'actualizado_en')
                ->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);
        }
    }

    public function testDeDefinicionDeCondicionalArreglo()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuarios = PIPE::tabla('usuarios')
                ->dondeColumna(
                    [['id', 'telefono_id'], ['creado_en', '=', 'actualizado_en']]
                )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);

            // Prueba de modelo.

            $usuarios = Usuario::dondeColumna(
                [['id', 'telefono_id'], ['creado_en', '=', 'actualizado_en']]
            )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);
        }
    }

    public function testDeDefinicionDeCondicionalMatriz()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            $this->_generarRegistros();

            // Prueba de constructor de consulta.

            $usuarios = PIPE::tabla('usuarios')
                ->dondeColumna(
                    ['id' => 'telefono_id', 'creado_en' => 'actualizado_en']
                )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);

            // Prueba de modelo.

            $usuarios = Usuario::dondeColumna(
                ['id' => 'telefono_id', 'creado_en' => 'actualizado_en']
            )->obtener(PIPE::OBJETO);

            $this->assertCount(2, $usuarios);
        }
    }

    private function _generarRegistros()
    {
        vaciarTablas();

        generarRegistros('telefonos', 2);
        generarRegistros('usuarios', 2);
    }
}
