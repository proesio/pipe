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
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class UnirTest extends TestCase
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

    public function testDeUnionDeTablas()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionDeTablas();
        }
    }

    public function testDeUnionDeTablasDefiniendoTipoUnion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionDeTablasDefiniendoTipoUnion();
        }
    }

    private function baseTestDeUnionDeTablas()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $usuarios = PIPE::tabla('usuarios')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos', 
            'documentos.numero alias documento_numero', 
            'telefonos.numero alias telefono_numero'
        )
            ->unir('documentos', 'usuarios.id', 'documentos.usuario_id')
            ->unir('telefonos', 'usuarios.telefono_id', 'telefonos.id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $usuarios);

        // Prueba de modelo.

        $this->generarRegistros();

        $usuarios = Usuario::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos', 
            'documentos.numero alias documento_numero', 
            'telefonos.numero alias telefono_numero'
        )
            ->unir('documentos', 'usuarios.id', 'documentos.usuario_id')
            ->unir('telefonos', 'usuarios.telefono_id', 'telefonos.id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $usuarios);
    }

    private function baseTestDeUnionDeTablasDefiniendoTipoUnion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $usuarios = PIPE::tabla('usuarios')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos', 
            'documentos.numero alias documento_numero', 
            'telefonos.numero alias telefono_numero'
        )
            ->unir('documentos', 'usuarios.id', '=', 'documentos.usuario_id')
            ->unir('telefonos', 'usuarios.telefono_id', '=', 'telefonos.id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $usuarios);

        // Prueba de modelo.

        $this->generarRegistros();

        $usuarios = Usuario::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos', 
            'documentos.numero alias documento_numero', 
            'telefonos.numero alias telefono_numero'
        )
            ->unir('documentos', 'usuarios.id', '=', 'documentos.usuario_id')
            ->unir('telefonos', 'usuarios.telefono_id', '=', 'telefonos.id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(1, $usuarios);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'documentos');
    }
}
