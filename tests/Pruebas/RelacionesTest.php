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

use Modelos\Usuario;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class RelacionesTest extends TestCase
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

    public function testDeDefinicionDeRelaciones()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelaciones();
        }
    }

    private function baseTestDeDefinicionDeRelaciones()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

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
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'documentos');
        generarRegistros($this->conexion, 'temas');
        generarRegistros($this->conexion, 'roles');
        generarRegistros($this->conexion, 'role_usuario');
    }
}
