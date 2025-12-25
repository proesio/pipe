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

namespace PIPE\Tests\Pruebas\Migracion;

use PIPE\Configuracion;
use PIPE\Excepciones\ORM;
use PIPE\Migracion\Atributo;
use PIPE\Migracion\Migracion;
use PHPUnit\Framework\TestCase;

class SQLiteTest extends TestCase
{
    public $conexion = 'sqlite';

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeMigracion()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        Migracion::tabla(
            ['tabla_tres', 'tabla_dos', 'tabla_uno', 'tabla']
        )->borrarTabla(true);

        Migracion::tabla('tabla')
            ->entero('entero', (new Atributo)->llavePrimaria()->autoincrementable())
            ->numerico('numerico', null, null, (new Atributo)->nulo())
            ->real('campo_real', null, null, (new Atributo)->chequeo('campo_real > 1')->noNulo())
            ->caracter('caracter', 255, (new Atributo)->cotejamiento('nocase')->unico())
            ->cadena('cadena', 255, (new Atributo)->predeterminado('cadena'))
            ->texto('texto')
            ->fecha('fecha')
            ->fechaHora('fecha_hora')
            ->marcaTiempo('marca_tiempo')
            ->hora('hora')
            ->booleano('booleano')
            ->binarioGrande('binario_grande')
            ->personalizado("personalizado varchar(255) null default 'valor'")
            ->crearTabla();

        Migracion::tabla('tabla_uno')
            ->entero('entero')
            ->entero('entero_uno')
            ->cadena('cadena_uno')
            ->cadena('cadena_dos')
            ->cadena('cadena_tres')
            ->restriccion('llave_primaria_entero')
            ->llavePrimaria('entero')
            ->crearTabla(true);

        Migracion::tabla('tabla_uno')->crearIndice(
            ['cadena_uno', 'cadena_dos'], 'indice_cadena_uno_cadena_dos'
        );

        Migracion::tabla('tabla_uno')->crearIndiceUnico(
            'cadena_tres', 'indice_unico_cadena_tres'
        );

        Migracion::tabla('tabla_dos')
            ->entero('entero', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('tabla_uno_entero')
            ->cadena('cadena')
            ->restriccion('llave_foranea_tabla_uno_entero')
            ->llaveForanea('tabla_uno_entero', 'tabla_uno', 'entero', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla(true);

        Migracion::tabla('tabla_tres')
            ->entero('entero', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('tabla_dos_entero')
            ->cadena('cadena')
            ->cadena('cadena_uno')
            ->crearTabla(true);

        Migracion::tabla('tabla_tres')->crearCampo(
            'cadena_dos', Atributo::CADENA, null, 255
        );

        Migracion::tabla('tabla_tres')->cambiarCampo(
            'cadena', 'cadena_cero', Atributo::CARACTER,
            (new Atributo)->cotejamiento('nocase'), 255
        );

        Migracion::tabla('tabla_tres')->borrarCampo('cadena_dos');

        Migracion::tabla('tabla_uno')->borrarIndice(
            'indice_cadena_uno_cadena_dos'
        );

        Migracion::tabla('tabla_uno')->borrarIndice(
            'indice_unico_cadena_tres'
        );

        $this->assertTrue(true);
    }

    public function testDeFalloAlEstablecerTipoDeAtributoIncorrecto()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        $this->expectException(ORM::class);

        Migracion::tabla('tabla')->entero('entero', 'not null');
    }
}
