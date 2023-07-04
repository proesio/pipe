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
use PIPE\Clases\Excepciones\ORM;

class UnirDerechaTest extends TestCase
{
    public $conexiones = [
        'mysql', 'pgsql', 'sqlsrv'
    ];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        global $configGlobal;

        $this->configGlobal = $configGlobal;
    }

    public function testDeUnionHaciaLaDerechaDeTablas()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionHaciaLaDerechaDeTablas();
        }
    }

    public function testDeUnionHaciaLaDerechaDeTablasDefiniendoTipoUnion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionHaciaLaDerechaDeTablasDefiniendoTipoUnion();
        }
    }

    public function testDeFalloAlUsarUnirDerechaConSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('usuarios')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirDerecha('temas', 'usuarios.id', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);
    }

    private function baseTestDeUnionHaciaLaDerechaDeTablas()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $usuarios = PIPE::tabla('usuarios')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirDerecha('temas', 'usuarios.id', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $usuarios);

        // Prueba de modelo.

        $this->generarRegistros();

        $usuarios = Usuario::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirDerecha('temas', 'usuarios.id', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $usuarios);
    }

    private function baseTestDeUnionHaciaLaDerechaDeTablasDefiniendoTipoUnion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $usuarios = PIPE::tabla('usuarios')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirDerecha('temas', 'usuarios.id', '=', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $usuarios);

        // Prueba de modelo.

        $this->generarRegistros();

        $usuarios = Usuario::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirDerecha('temas', 'usuarios.id', '=', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $usuarios);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'temas');

        $pdo = PIPE::obtenerPDO();

        $pdo->exec(
            "insert into temas (titulo, descripcion) values ('Titulo2', 'Descripcion2')"
        );
    }
}
