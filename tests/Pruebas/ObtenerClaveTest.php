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

class ObtenerClaveTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDeRegistrosDefiniendoClavePersonalizada()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDeRegistrosDefiniendoClavePersonalizada();
        }
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorConstructorDeConsultaEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorConstructorDeConsultaEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::SQL);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoClasePorModeloEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::CLASE);
    }

    public function testDeFalloAlDefinirUnTipoDeRetornoSQLPorModeloEnSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        Telefono::seleccionar()->obtenerClave('numero', PIPE::SQL);
    }

    private function baseTestDeObtencionDeRegistrosDefiniendoClavePersonalizada()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $numeros = PIPE::tabla('telefonos')->obtenerClave('numero');

        $this->assertCount(2, $numeros);

        foreach ($numeros as $clave => $valor) {
            $this->assertArrayHasKey($clave, $numeros);
        }

        $numeros = PIPE::tabla('telefonos')->obtenerClave('numero', PIPE::JSON);

        $this->assertJson($numeros);

        // Prueba de modelo.

        $this->generarRegistros();

        $numeros = Telefono::seleccionar()->obtenerClave('numero');

        $this->assertCount(2, $numeros);

        foreach ($numeros as $clave => $valor) {
            $this->assertArrayHasKey($clave, $numeros);
        }

        $numeros = Telefono::seleccionar()->obtenerClave('numero', PIPE::JSON);

        $this->assertJson($numeros);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
    }
}
