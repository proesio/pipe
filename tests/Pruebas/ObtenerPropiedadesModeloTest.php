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

use Modelos\Role;
use Modelos\Tema;
use Modelos\Usuario;
use Modelos\Telefono;
use Modelos\Documento;
use PIPE\Configuracion;
use PHPUnit\Framework\TestCase;

class ObtenerPropiedadesModeloTest extends TestCase
{
    public $conexiones = [];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeObtencionDePropiedadesDeModelo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeObtencionDePropiedadesDeModelo();
        }
    }

    private function baseTestDeObtencionDePropiedadesDeModelo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $propiedadesModelo = Usuario::obtenerPropiedadesModelo();

        $this->assertSame(null, $propiedadesModelo['conexion']);
        $this->assertSame('usuarios', $propiedadesModelo['tabla']);
        $this->assertSame('id', $propiedadesModelo['llavePrimaria']);
        $this->assertSame(true, $propiedadesModelo['registroTiempo']);
        $this->assertSame('creado_en', $propiedadesModelo['creadoEn']);
        $this->assertSame('actualizado_en', $propiedadesModelo['actualizadoEn']);
        $this->assertSame('eliminado_en', $propiedadesModelo['eliminadoEn']);
        $this->assertSame(false, $propiedadesModelo['eliminacionSuave']);
        $this->assertIsArray($propiedadesModelo['tieneUno'][Documento::class]);
        $this->assertIsArray($propiedadesModelo['tieneMuchos'][Tema::class]);
        $this->assertIsArray($propiedadesModelo['perteneceAUno'][Telefono::class]);
        $this->assertIsArray($propiedadesModelo['perteneceAMuchos'][Role::class]);
        $this->assertSame([], $propiedadesModelo['insertables']);
        $this->assertSame([], $propiedadesModelo['actualizables']);
        $this->assertSame([], $propiedadesModelo['visibles']);
        $this->assertSame([], $propiedadesModelo['ocultos']);
    }
}
