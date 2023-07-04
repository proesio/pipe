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

class ActualizarTest extends TestCase
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

    public function testDeActualizacionDeRegistro()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionDeRegistro();
        }
    }

    public function testDeActualizacionDeRegistroConCondicional()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionDeRegistroConCondicional();
        }
    }

    public function testDeActualizacionMasivaDeRegistros()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionMasivaDeRegistros();
        }
    }

    public function testDeActualizacionDeRegistroConMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionDeRegistroConMutador();
        }
    }

    public function testDeActualizacionDeRegistroConCondicionalYMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionDeRegistroConCondicionalYMutador();
        }
    }

    public function testDeActualizacionMasivaDeRegistrosConMutador()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeActualizacionMasivaDeRegistrosConMutador();
        }
    }

    private function baseTestDeActualizacionDeRegistro()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de contructor de consulta.

        $this->generarRegistros();

        $telefono = PIPE::tabla('telefonos')->encontrar(1);
        $telefono->numero = 1234567890;
        $resultado = $telefono->actualizar();

        $this->assertEquals(1, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefono = Telefono::encontrar(1);
        $telefono->numero = 1234567890;
        $resultado = $telefono->actualizar();

        $this->assertEquals(1, $resultado);
    }

    private function baseTestDeActualizacionDeRegistroConCondicional()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de contructor de consulta.

        $this->generarRegistros();

        $resultado = PIPE::tabla('telefonos')
            ->donde('id in(?, ?)', [1, 2])
            ->actualizar(['numero' => 1234567890]);

        $this->assertEquals(2, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $resultado = Telefono::donde('id in(?, ?)', [1, 2])
            ->actualizar(['numero' => 1234567890]);

        $this->assertEquals(2, $resultado);
    }

    private function baseTestDeActualizacionMasivaDeRegistros()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de contructor de consulta.

        $this->generarRegistros();

        $resultado = PIPE::tabla('telefonos')
            ->actualizar(['numero' => 1234567890]);

        $this->assertEquals(3, $resultado);

        // Prueba de modelo.

        $this->generarRegistros();

        $resultado = Telefono::actualizar(['numero' => 1234567890]);

        $this->assertEquals(3, $resultado);
    }

    private function baseTestDeActualizacionDeRegistroConMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 1);
        generarRegistros($this->conexion, 'usuarios', 1);
        generarRegistros($this->conexion, 'documentos', 1);

        $documento = Documento::encontrar(1);
        $documento->numero = 1234567890;
        $documento->actualizar();

        $documento = Documento::encontrar(1);

        $this->assertEquals('C.C. 1234567890', $documento->numero);
    }

    private function baseTestDeActualizacionDeRegistroConCondicionalYMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 1);
        generarRegistros($this->conexion, 'usuarios', 1);
        generarRegistros($this->conexion, 'documentos', 1);

        Documento::donde('id = ?', [1])
            ->actualizar(['numero' => 1234567890]);

        $documento = Documento::encontrar(1);

        $this->assertEquals('C.C. 1234567890', $documento->numero);
    }

    private function baseTestDeActualizacionMasivaDeRegistrosConMutador()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de modelo.

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 2);
        generarRegistros($this->conexion, 'usuarios', 2);
        generarRegistros($this->conexion, 'documentos', 2);

        Documento::actualizar(['numero' => 1234567890]);

        $documentos = Documento::todo();

        $this->assertEquals('C.C. 1234567890', $documentos[0]->numero);
        $this->assertEquals('C.C. 1234567890', $documentos[1]->numero);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos', 3);
    }
}
