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

class SeleccionarTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeSeleccionDeCampos()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeSeleccionDeCampos();
        }
    }

    private function baseTestDeSeleccionDeCampos()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $telefonos = PIPE::tabla('telefonos')
            ->seleccionar('id', 'numero alias n')
            ->obtener(PIPE::OBJETO);

        $this->assertObjectNotHasProperty('numero', $telefonos[0]);
        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);

        // Prueba de modelo.

        $this->generarRegistros();

        $telefonos = Telefono::seleccionar('id', 'numero alias n')
            ->obtener(PIPE::OBJETO);

        $this->assertObjectNotHasProperty('numero', $telefonos[0]);
        $this->assertObjectNotHasProperty('creado_en', $telefonos[0]);
        $this->assertObjectNotHasProperty('actualizado_en', $telefonos[0]);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }
}
