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

use Modelos\Usuario;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class RelacionesTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDefinicionDeRelaciones()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelaciones();
        }
    }

    private function baseTestDeDefinicionDeRelaciones()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion, true);

        $this->generarRegistros();

        $usuario = Usuario::relaciones(
            'documento', 'temas', 'telefono', 'roles', 'relacion'
        )->primero();

        $this->assertObjectHasProperty('documento', $usuario);
        $this->assertObjectHasProperty('temas', $usuario);
        $this->assertObjectHasProperty('telefono', $usuario);
        $this->assertObjectHasProperty('roles', $usuario);
        $this->assertObjectHasProperty('relacion', $usuario);
        $this->assertNull($usuario->relacion);
    }

    private function generarRegistros()
    {
        vaciarTablas();

        generarRegistros('telefonos');
        generarRegistros('usuarios');
        generarRegistros('documentos');
        generarRegistros('temas');
        generarRegistros('roles');
        generarRegistros('role_usuario');
    }
}
