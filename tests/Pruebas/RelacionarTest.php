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

use Modelos\Usuario;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class RelacionarTest extends TestCase
{
    public $conexiones = [
        'mysql', 'pgsql', 'sqlite', 'sqlsrv'
    ];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        global $configGlobal;

        $this->configGlobal = $configGlobal;
    }

    public function testDeDefinicionDeRelacion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelacion();
        }
    }

    private function baseTestDeDefinicionDeRelacion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $usuario = Usuario::primero();
        $usuario->relacionar(
            'documento', 'temas', 'telefono', 'roles', 'relacion'
        );

        $this->assertObjectHasAttribute('documento', $usuario);
        $this->assertObjectHasAttribute('temas', $usuario);
        $this->assertObjectHasAttribute('telefono', $usuario);
        $this->assertObjectHasAttribute('roles', $usuario);
        $this->assertObjectHasAttribute('relacion', $usuario);
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
