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
use PIPE\Excepciones\ORM;
use PHPUnit\Framework\TestCase;

class ExtraerTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeExtraccionDeColumnaPorClave()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeExtraccionDeColumnaPorClave();
        }
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorConstructorDeConsultaEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorConstructorDeConsultaEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorConstructorDeConsultaEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorConstructorDeConsultaEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorModeloEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorModeloEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorModeloEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoObjetoPorModeloEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::OBJETO);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->extraer('numero', PIPE::SQL);
    }

    private function baseTestDeExtraccionDeColumnaPorClave()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $numeros = PIPE::tabla('telefonos')->extraer('numero');

        $this->assertCount(2, $numeros);
        $this->assertArrayHasKey(0, $numeros);
        $this->assertArrayHasKey(1, $numeros);

        $numeros = PIPE::tabla('telefonos')->extraer('numero', PIPE::JSON);

        $this->assertJson($numeros);

        // Prueba de modelo.

        $this->generarRegistros();

        $numeros = Telefono::seleccionar()->extraer('numero');

        $this->assertCount(2, $numeros);
        $this->assertArrayHasKey(0, $numeros);
        $this->assertArrayHasKey(1, $numeros);

        $numeros = Telefono::seleccionar()->extraer('numero', PIPE::JSON);

        $this->assertJson($numeros);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
