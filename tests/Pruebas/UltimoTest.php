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

class UltimoTest extends TestCase
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

    public function testDeObtencionDelUltimoRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistro();
        }
    }

    public function testDeObtencionDelUltimoRegistroConLlavePrimaria()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConLlavePrimaria();
        }
    }

    public function testDeObtencionDelUltimoRegistroConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDelUltimoRegistroConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDelUltimoRegistroConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConTipoRetornoJSON();
        }
    }

    public function testDeObtencionDelUltimoRegistroConLlavePrimariaYTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDelUltimoRegistroConLlavePrimariaYTipoRetornoJSON();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistros();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConLlavePrimaria()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimaria();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoOBJETO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoOBJETO();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoARREGLO()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoARREGLO();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoJSON();
        }
    }

    public function testDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoJSON()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoJSON();
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

        PIPE::tabla('telefonos')->ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirTipoRetornoSQLSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::ultimo(PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConTipoRetornoSQLSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::ultimo(2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::SQL);
    }

    public function testDeFalloAlDefinirUltimosTantosRegistrosConLlavePrimariaYTipoRetornoSQLSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::ultimo('id', 2, PIPE::SQL);
    }

    private function baseTestDeObtencionDelUltimoRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo();

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo();

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDelUltimoRegistroConLlavePrimaria()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo('id');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo('id');

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDelUltimoRegistroConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo(PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo(PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo('id', PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo('id', PIPE::OBJETO);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDelUltimoRegistroConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo(PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(3, $telefono['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo(PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(3, $telefono['id']);
    }

    private function baseTestDeObtencionDelUltimoRegistroConLlavePrimeriaYTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo('id', PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(3, $telefono['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo('id', PIPE::ARREGLO);

        $this->assertIsArray($telefono);
        $this->assertEquals(3, $telefono['id']);
    }

    private function baseTestDeObtencionDelUltimoRegistroConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo(PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::ultimo(PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDelUltimoRegistroConLlavePrimariaYTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->ultimo('id', PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = Telefono::ultimo('id', PIPE::JSON);

        $telefono = json_decode($telefono);

        $this->assertIsObject($telefono);
        $this->assertEquals(3, $telefono->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo(2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo(2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimaria()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo('id', 2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo('id', 2);

        $this->assertCount(2, $telefonos);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo(2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo(2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoOBJETO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo('id', 2, PIPE::OBJETO);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo(2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo(2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoARREGLO()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo('id', 2, PIPE::ARREGLO);

        $this->assertCount(2, $telefonos);
        $this->assertIsArray($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]['id']);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo(2, PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo(2, PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);
    }

    private function baseTestDeObtencionDeLosUltimosTantosRegistrosConLlavePrimariaYTipoRetornoJSON()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')->ultimo('id', 2, PIPE::JSON);

        $telefonos = json_decode($telefonos);

        $this->assertCount(2, $telefonos);
        $this->assertIsObject($telefonos[0]);
        $this->assertEquals(2, $telefonos[1]->id);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::ultimo('id', 2, PIPE::JSON);

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

        $telefono = PIPE::tabla('telefonos')->ultimo();

        $this->assertNull($telefono);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        $telefono = Telefono::ultimo();

        $this->assertNull($telefono);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 3);
    }
}
