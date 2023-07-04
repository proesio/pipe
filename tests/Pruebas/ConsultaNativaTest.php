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

use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\Excepciones\ORM;
use PIPE\Clases\ConstructorConsulta;

class ConsultaNativaTest extends TestCase
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

    public function testDeConsultaNativa()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativa();
        }
    }

    public function testDeConsultaNativaConParametros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConParametros();
        }
    }

    public function testDeConsultaNativaConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConTipoRetornoOBJETO();
        }
    }

    public function testDeConsultaNativaConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConTipoRetornoARREGLO();
        }
    }

    public function testDeConsultaNativaConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConTipoRetornoJSON();
        }
    }

    public function testDeConsultaNativaConParametrosYTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConParametrosYTipoRetornoOBJETO();
        }
    }

    public function testDeConsultaNativaConParametrosYTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConParametrosYTipoRetornoARREGLO();
        }
    }

    public function testDeConsultaNativaConParametrosYTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeConsultaNativaConParametrosYTipoRetornoJSON();
        }
    }

    public function testDeFalloAlDefinirTipoRetornoSQL()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeFalloAlDefinirTipoRetornoSQL();
        }
    }

    private function baseTestDeConsultaNativa()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa('select * from telefonos');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
    }

    private function baseTestDeConsultaNativaConParametros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos where id = ?', [1]
        );

        $this->assertInstanceOf(ConstructorConsulta::class, $telefonos[0]);
    }

    private function baseTestDeConsultaNativaConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos', PIPE::OBJETO
        );

        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeConsultaNativaConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos', PIPE::ARREGLO
        );

        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeConsultaNativaConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos', PIPE::JSON
        );

        $this->assertIsString($telefonos[0]);
    }

    private function baseTestDeConsultaNativaConParametrosYTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos where id = ?', [1], PIPE::OBJETO
        );

        $this->assertIsObject($telefonos[0]);
    }

    private function baseTestDeConsultaNativaConParametrosYTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos where id = ?', [1], PIPE::ARREGLO
        );

        $this->assertIsArray($telefonos[0]);
    }

    private function baseTestDeConsultaNativaConParametrosYTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->generarRegistros();

        $telefonos = PIPE::consultaNativa(
            'select * from telefonos where id = ?', [1], PIPE::JSON
        );

        $this->assertIsString($telefonos[0]);
    }

    private function baseTestDeFalloAlDefinirTipoRetornoSQL()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->expectException(ORM::class);

        PIPE::consultaNativa(
            'select * from telefonos', PIPE::SQL
        );
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }
}
