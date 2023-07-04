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
use Modelos\Documento;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\Excepciones\ORM;

class InsertarTest extends TestCase
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

    public function testDeInsercionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistro();
        }
    }

    public function testDeInsercionDeRegistroConCamposPersonalizados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistroConCamposPersonalizados();
        }
    }

    public function testDeInsercionDeVariosRegistrosConCamposPersonalizados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeVariosRegistrosConCamposPersonalizados();
        }
    }

    public function testDeInsercionDeRegistroConMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistroConMutador();
        }
    }

    public function testDeInsercionDeRegistroConCamposPersonalizadosYMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistroConCamposPersonalizadosYMutador();
        }
    }

    public function testDeInsercionDeVariosRegistrosConCamposPersonalizadosYMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeVariosRegistrosConCamposPersonalizadosYMutador();
        }
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    public function testDeFalloAlInsertarRegistroConCamposIncompletosSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertar();
    }

    private function baseTestDeInsercionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        vaciarTablas($this->conexion);

        $telefono = PIPE::tabla('telefonos');

        if ($this->conexion == 'pgsql') {
            $telefono->id = 'default';
        } elseif ($this->conexion == 'sqlsrv') {
            $pdo = PIPE::obtenerPDO();
            $pdo->exec('set identity_insert telefonos on');

            $telefono->id = 1;
        } else {
            $telefono->id = null;
        }

        $telefono->numero = 1234567890;
        $resultado = $telefono->insertar();

        $this->assertEquals(1, $resultado);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        $telefono = new Telefono();

        if ($this->conexion == 'pgsql') {
            $telefono->id = 'default';
        } elseif ($this->conexion == 'sqlsrv') {
            $pdo = PIPE::obtenerPDO();
            $pdo->exec('set identity_insert telefonos on');

            $telefono->id = 1;
        } else {
            $telefono->id = null;
        }

        $telefono->numero = 1234567890;
        $resultado = $telefono->insertar();

        $this->assertEquals(1, $resultado);
    }

    private function baseTestDeInsercionDeRegistroConCamposPersonalizados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        vaciarTablas($this->conexion);

        $resultado = PIPE::tabla('telefonos')
            ->insertar(['numero' => 1234567890]);

        $this->assertEquals(1, $resultado);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        $telefono = new Telefono();

        $resultado = $telefono->insertar(['numero' => 1234567890]);

        $this->assertEquals(1, $resultado);
    }

    private function baseTestDeInsercionDeVariosRegistrosConCamposPersonalizados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        vaciarTablas($this->conexion);

        $resultado = PIPE::tabla('telefonos')
            ->insertar(
                [
                    ['numero' => 1234567890],
                    ['numero' => 9876543210]
                ]
            );

        $this->assertEquals(2, $resultado);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        $telefono = new Telefono();

        $resultado = $telefono->insertar(
            [
                ['numero' => 1234567890],
                ['numero' => 9876543210]
            ]
        );

        $this->assertEquals(2, $resultado);
    }

    private function baseTestDeInsercionDeRegistroConMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 1);
        generarRegistros($this->conexion, 'usuarios', 1);

        $documento = new Documento();

        if ($this->conexion == 'pgsql') {
            $documento->id = 'default';
        } elseif ($this->conexion == 'sqlsrv') {
            $pdo = PIPE::obtenerPDO();
            $pdo->exec('set identity_insert documentos on');

            $documento->id = 1;
        } else {
            $documento->id = null;
        }

        $documento->usuario_id = 1;
        $documento->numero = 1234567890;
        $documento->insertar();

        $documento = Documento::encontrar(1);

        $this->assertEquals('C.C. 1234567890', $documento->numero);
    }

    private function baseTestDeInsercionDeRegistroConCamposPersonalizadosYMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 1);
        generarRegistros($this->conexion, 'usuarios', 1);

        $documento = new Documento();

        $documento->insertar(
            [
                'usuario_id' => 1,
                'numero' => 1234567890
            ]
        );

        $documento = Documento::encontrar(1);

        $this->assertEquals('C.C. 1234567890', $documento->numero);
    }

    private function baseTestDeInsercionDeVariosRegistrosConCamposPersonalizadosYMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
        generarRegistros($this->conexion, 'usuarios', 2);

        $documento = new Documento();

        $documento->insertar(
            [
                ['usuario_id' => 1, 'numero' => 1234567890],
                ['usuario_id' => 2, 'numero' => 9876543210]
            ]
        );

        $documentos = Documento::todo();

        $this->assertEquals('C.C. 1234567890', $documentos[0]->numero);
        $this->assertEquals('C.C. 9876543210', $documentos[1]->numero);
    }
}
