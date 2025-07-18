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

use DateTime;
use PIPE\Clases\PIPE;
use Modelos\Telefono;
use Modelos\Documento;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\ConstructorConsulta;
use Modelos\EliminacionSuave\Telefono as Telefono1;

class ObtenerTest extends TestCase
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

    public function testDeObtencionDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistros();
        }
    }

    public function testDeObtencionDeRegistrosConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeRegistrosConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeRegistrosConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConTipoRetornoJSON();
        }
    }

    public function testDeObtencionDeRegistrosConTipoRetornoSQL()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConTipoRetornoSQL();
        }
    }

    public function testDeObtencionDeRegistrosConMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConMutador();
        }
    }

    public function testDeObtencionDeRegistrosConEliminacionSuave()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosConEliminacionSuave();
        }
    }

    private function baseTestDeObtencionDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->obtener();

        $this->assertCount(2, $telefonos);
        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
    }

    private function baseTestDeObtencionDeRegistrosConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->obtener(PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeObtencionDeRegistrosConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->obtener(PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeObtencionDeRegistrosConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->obtener(PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeObtencionDeRegistrosConTipoRetornoSQL()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $sql = PIPE::tabla('telefonos')->obtener(PIPE::SQL);

        $this->assertIsString($sql);
    }

    private function baseTestDeObtencionDeRegistrosConMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
        generarRegistros($this->conexion, 'usuarios', 2);
        generarRegistros($this->conexion, 'documentos', 2);

        $documentos = Documento::todo();

        $this->assertInstanceOf(DateTime::class, $documentos[0]->actualizado_en);
        $this->assertInstanceOf(DateTime::class, $documentos[1]->actualizado_en);
    }

    private function baseTestDeObtencionDeRegistrosConEliminacionSuave()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefono1 = Telefono1::encontrar(1)->eliminar();

        $telefonos1 = Telefono1::todo();

        $telefonos = Telefono::todo();

        $this->assertEquals(1, $telefono1);
        $this->assertCount(1, $telefonos1);
        $this->assertCount(2, $telefonos);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
