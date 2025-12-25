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
use PIPE\Configuracion;
use PIPE\Excepciones\ORM;
use PIPE\ConstructorConsulta;
use PHPUnit\Framework\TestCase;

class ConsultaTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeConsultaEnEspanol()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanol();
        }
    }

    public function testDeConsultaEnEspanolConParametros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConParametros();
        }
    }

    public function testDeConsultaEnEspanolConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConTipoRetornoOBJETO();
        }
    }

    public function testDeConsultaEnEspanolConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConTipoRetornoARREGLO();
        }
    }

    public function testDeConsultaEnEspanolConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConTipoRetornoJSON();
        }
    }

    public function testDeConsultaEnEspanolConParametrosYTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConParametrosYTipoRetornoOBJETO();
        }
    }

    public function testDeConsultaEnEspanolConParametrosYTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConParametrosYTipoRetornoARREGLO();
        }
    }

    public function testDeConsultaEnEspanolConParametrosYTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaEnEspanolConParametrosYTipoRetornoJSON();
        }
    }

    public function testDeFalloAlDefinirTipoRetornoSQL()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeFalloAlDefinirTipoRetornoSQL();
        }
    }

    private function baseTestDeConsultaEnEspanol()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta('seleccionar todo de telefonos');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConParametros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos donde id = ?', [1]
        );

        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos', PIPE::OBJETO
        );

        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos', PIPE::ARREGLO
        );

        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos', PIPE::JSON
        );

        $this->assertIsString($telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConParametrosYTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos donde id = ?', [1], PIPE::OBJETO
        );

        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConParametrosYTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos donde id = ?', [1], PIPE::ARREGLO
        );

        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeConsultaEnEspanolConParametrosYTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consulta(
            'seleccionar todo de telefonos donde id = ?', [1], PIPE::JSON
        );

        $this->assertIsString($telefonos[0]);
    }

    private function baseTestDeFalloAlDefinirTipoRetornoSQL()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->expectException(ORM::class);

        PIPE::consulta(
            'seleccionar todo de telefonos', PIPE::SQL
        );
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }
}
