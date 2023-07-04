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

class InsertarObtenerIdTest extends TestCase
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

    public function testDeInsercionDeRegistroYObtencionDeId()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistroYObtencionDeId();
        }
    }

    public function testDeInsercionDeRegistroYObtencionDeIdConCamposPersonalizados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeRegistroYObtencionDeIdConCamposPersonalizados();
        }
    }

    public function testDeInsercionDeVariosRegistrosYObtencionDeIdConCamposPersonalizados()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeInsercionDeVariosRegistrosYObtencionDeIdConCamposPersonalizados();
        }
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosMysqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosPgsqlModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosSqliteModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        $telefono = PIPE::tabla('telefonos');
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    public function testDeFalloAlInsertarRegistroYObtencionDeIdConCamposIncompletosSqlsrvModelo()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        $telefono = new Telefono();
        $telefono->numero = 1234567890;
        $telefono->insertarObtenerId();
    }

    private function baseTestDeInsercionDeRegistroYObtencionDeId()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos');

        if ($this->conexion == 'pgsql') {
            $telefono->id = 'default';
        } elseif ($this->conexion == 'sqlsrv') {
            $pdo = PIPE::obtenerPDO();
            $pdo->exec('set identity_insert telefonos on');

            $telefono->id = 3;
        } else {
            $telefono->id = null;
        }

        $telefono->numero = 1234567890;
        $resultado = $telefono->insertarObtenerId();

        $this->assertEquals(3, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono1 = new Telefono();

        if ($this->conexion == 'pgsql') {
            $telefono1->id = 'default';
        } elseif ($this->conexion == 'sqlsrv') {
            $pdo = PIPE::obtenerPDO();
            $pdo->exec('set identity_insert telefonos on');

            $telefono1->id = 3;
        } else {
            $telefono1->id = null;
        }

        $telefono1->numero = 1234567890;
        $resultado1 = $telefono1->insertarObtenerId();

        $this->assertEquals(3, $resultado1);
    }

    private function baseTestDeInsercionDeRegistroYObtencionDeIdConCamposPersonalizados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $resultado = PIPE::tabla('telefonos')
            ->insertarObtenerId(['numero' => 1234567890]);

        $this->assertEquals(3, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = new Telefono();

        $resultado = $telefono->insertarObtenerId(['numero' => 1234567890]);

        $this->assertEquals(3, $resultado);
    }

    private function baseTestDeInsercionDeVariosRegistrosYObtencionDeIdConCamposPersonalizados()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $valorEsperado = 4;

        if ($this->conexion == 'mysql') {
            $valorEsperado = 3;
        }

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $resultado = PIPE::tabla('telefonos')
            ->insertarObtenerId(
                [
                    ['numero' => 1234567890],
                    ['numero' => 9876543210]
                ]
            );

        $this->assertEquals($valorEsperado, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = new Telefono();

        $resultado = $telefono->insertarObtenerId(
            [
                ['numero' => 1234567890],
                ['numero' => 9876543210]
            ]
        );

        $this->assertEquals($valorEsperado, $resultado);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
