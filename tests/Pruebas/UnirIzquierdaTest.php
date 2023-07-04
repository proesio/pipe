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

use Modelos\Tema;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;

class UnirIzquierdaTest extends TestCase
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

    public function testDeUnionHaciaLaIzquierdaDeTablas()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionHaciaLaIzquierdaDeTablas();
        }
    }

    public function testDeUnionHaciaLaIzquierdaDeTablasDefiniendoTipoUnion()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeUnionHaciaLaIzquierdaDeTablasDefiniendoTipoUnion();
        }
    }

    private function baseTestDeUnionHaciaLaIzquierdaDeTablas()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirIzquierda('usuarios', 'usuarios.id', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirIzquierda('usuarios', 'usuarios.id', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);
    }

    private function baseTestDeUnionHaciaLaIzquierdaDeTablasDefiniendoTipoUnion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $temas = PIPE::tabla('temas')->seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirIzquierda('usuarios', 'usuarios.id', '=', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);

        // Prueba de modelo.

        $this->generarRegistros();

        $temas = Tema::seleccionar(
            'usuarios.nombres', 
            'usuarios.apellidos',
            'temas.titulo'
        )
            ->unirIzquierda('usuarios', 'usuarios.id', '=', 'temas.usuario_id')
            ->obtener(PIPE::OBJETO);

        $this->assertCount(2, $temas);
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
