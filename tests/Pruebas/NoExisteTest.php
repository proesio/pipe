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

class NoExisteTest extends TestCase
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

    public function testDeVerificacionDeRegistroInexistente()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeVerificacionDeRegistroInexistente();
        }
    }

    private function baseTestDeVerificacionDeRegistroInexistente()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        // Prueba de constructor de consulta.

        $this->generarRegistros();

        $existe = PIPE::tabla('telefonos')->donde('id = ?', [1])->noExiste();

        $this->assertNotTrue($existe);

        // Prueba de modelo.

        $this->generarRegistros();

        $existe = Telefono::donde('id = ?', [1])->noExiste();

        $this->assertNotTrue($existe);
    }

    private function generarRegistros()
    {
        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
    }
}
