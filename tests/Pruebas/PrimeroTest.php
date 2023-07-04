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

use Modelos\Telefono;
use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\Excepciones\ORM;
use PIPE\Clases\ConstructorConsulta;

class PrimeroTest extends TestCase
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

    public function testDeObtencionDelPrimerRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelPrimerRegistro();
        }
    }

    public function testDeObtencionDelPrimerRegistroConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelPrimerRegistroConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDelPrimerRegistroConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelPrimerRegistroConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDelPrimerRegistroConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelPrimerRegistroConTipoRetornoJSON();
        }
    }

    public function testDeObtencionDeLosPrimerosTantosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosPrimerosTantosRegistros();
        }
    }

    public function testDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoJSON();
        }
    }

    public function testDeObtencionNullCuandoNoSeEncuentranRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionNullCuandoNoSeEncuentranRegistros();
        }
    }

    public function testDeFalloAlDefinirTipoRetornoSQLMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlitelModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::primero(PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->primero(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirPrimerosTantosRegistrosConTipoRetornoSQLSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::primero(2, PIPE::SQL);
    }

    private function baseTestDeObtencionDelPrimerRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->primero();

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(1, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::primero();

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(1, $telefono->id);
    }

    private function baseTestDeObtencionDelPrimerRegistroConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(1, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::primero(PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(1, $telefono->id);
    }

    private function baseTestDeObtencionDelPrimerRegistroConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(1, $telefono['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::primero(PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(1, $telefono['id']);
    }

    private function baseTestDeObtencionDelPrimerRegistroConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->primero(PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(1, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::primero(PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(1, $telefono->id);
    }

    private function baseTestDeObtencionDeLosPrimerosTantosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->primero(2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::primero(2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->primero(2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::primero(2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->primero(2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::primero(2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);
    }

    private function baseTestDeObtencionDeLosPrimerosTantosRegistrosConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->primero(2, PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::primero(2, PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionNullCuandoNoSeEncuentranRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        vaciarTablas($this->conexion);

        $telefono = PIPE::tabla('telefonos')->primero();

        $this->assertNull($telefono);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        $telefono = Telefono::primero();

        $this->assertNull($telefono);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 3);
    }
}
