<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  7.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use PIPE\PIPE;
use Modelos\Telefono;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDeTodosLosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistros();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoJSON();
        }
    }

    public function testDeObtencionSQL()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionSQL();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConCamposEspecificados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificados();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoJSON();
        }
    }

    public function testDeObtencionDeSQLConCamposEspecificados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeSQLConCamposEspecificados();
        }
    }

    private function baseTestDeObtencionDeTodosLosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo();

        $this->assertCount(2, $telefonos);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo();

        $this->assertCount(2, $telefonos);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(PIPE::OBJETO);

        $this->assertIsObject($telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(PIPE::OBJETO);

        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(PIPE::ARREGLO);

        $this->assertIsArray($telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(PIPE::ARREGLO);

        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(PIPE::JSON);

        $this->assertIsString($telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(PIPE::JSON);

        $this->assertIsString($telefonos[0]);
    }

    private function baseTestDeObtencionSQL()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $sql = PIPE::tabla('telefonos')->todo(PIPE::SQL);

        $this->assertIsString($sql);

        // Prueba de modelo.

        $this->generarRegistros();

        $sql = Telefono::todo(PIPE::SQL);

        $this->assertIsString($sql);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(['id', 'numero']);

        $this->assertCount(2, $telefonos);

        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(['id', 'numero']);

        $this->assertCount(2, $telefonos);

        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(['id', 'numero'], PIPE::OBJETO);

        $this->assertIsObject($telefonos[0]);

        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(['id', 'numero'], PIPE::OBJETO);

        $this->assertIsObject($telefonos[0]);

        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(['id', 'numero'], PIPE::ARREGLO);

        $this->assertIsArray($telefonos[0]);

        $this->assertArrayNotHasKey('creado_en', $telefonos[0]);
        $this->assertArrayNotHasKey('actualizado_en', $telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(['id', 'numero'], PIPE::ARREGLO);

        $this->assertIsArray($telefonos[0]);

        $this->assertArrayNotHasKey('creado_en', $telefonos[0]);
        $this->assertArrayNotHasKey('actualizado_en', $telefonos[0]);
    }

    private function baseTestDeObtencionDeTodosLosRegistrosConCamposEspecificadosYTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->todo(['id', 'numero'], PIPE::JSON);

        $this->assertIsString($telefonos[0]);

        $this->assertNotTrue((bool) strpos($telefonos, 'creado_en'));
        $this->assertNotTrue((bool) strpos($telefonos, 'actualizado_en'));

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::todo(['id', 'numero'], PIPE::JSON);

        $this->assertIsString($telefonos[0]);

        $this->assertNotTrue((bool) strpos($telefonos, 'creado_en'));
        $this->assertNotTrue((bool) strpos($telefonos, 'actualizado_en'));
    }

    private function baseTestDeObtencionDeSQLConCamposEspecificados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $sql = PIPE::tabla('telefonos')->todo(['id', 'numero'], PIPE::SQL);

        $this->assertEquals('select id,numero from telefonos', $sql);

        // Prueba de modelo.

        $this->generarRegistros();

        $sql = Telefono::todo(['id', 'numero'], PIPE::SQL);

        $this->assertEquals('select id,numero from telefonos', $sql);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
