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

class SQLServerTest extends TestCase
{
    public $conexion = 'sqlsrv';

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
            ->enteroGrande('entero_grande', (new Atributo)->llavePrimaria()->autoincrementable())
            ->enteroMuyPequeno('entero_muy_pequeno', (new Atributo)->nulo())
            ->enteroPequeno('entero_pequeno', (new Atributo)->noNulo())
            ->entero('entero', (new Atributo)->unico())
            ->decimal('campo_decimal', 20, 2, (new Atributo)->predeterminado(7.8))
            ->numerico('numerico', 20, 2)
            ->flotante('flotante', null, null)
            ->real('campo_real', null, null)
            ->caracter('caracter', 255, (new Atributo)->cotejamiento('SQL_Latin1_General_CP1_CI_AS'))
            ->cadena('cadena')
            ->nCaracter('n_caracter', 255, (new Atributo)->cotejamiento('Latin1_General_CI_AS'))
            ->nCadena('n_cadena')
            ->texto('texto')
            ->fecha('fecha')
            ->fechaHora('fecha_hora')
            ->fechaHora2('fecha_hora2')
            ->marcaTiempo('marca_tiempo')
            ->hora('hora')
            ->digitoBinario('digito_binario')
            ->personalizado("personalizado varchar(255) null default 'valor'")
            ->crearTabla();

        Migracion::tabla('tabla_uno')
            ->enteroGrande('entero_grande', (new Atributo)->autoincrementable())
            ->cadena('cadena_uno')
            ->cadena('cadena_dos')
            ->cadena('cadena_tres')
            ->llavePrimaria('entero_grande')
            ->crearTabla();

        Migracion::tabla('tabla_uno')->crearIndice(
            ['cadena_uno', 'cadena_dos'], 'indice_cadena_uno_cadena_dos'
        );

        Migracion::tabla('tabla_uno')->crearIndiceUnico(
            'cadena_tres', 'indice_unico_cadena_tres'
        );

        Migracion::tabla('tabla_dos')
            ->enteroGrande('entero_grande', (new Atributo)->autoincrementable())
            ->enteroGrande('tabla_uno_entero_grande')
            ->cadena('cadena')
            ->restriccion('llave_foranea_tabla_uno_entero_grande')
            ->llaveForanea('tabla_uno_entero_grande', 'tabla_uno', 'entero_grande', null, Atributo::CASCADA)
            ->crearTabla();

        Migracion::tabla('tabla_tres')
            ->enteroGrande('entero_grande', (new Atributo)->autoincrementable())
            ->enteroGrande('tabla_dos_entero_grande')
            ->cadena('cadena')
            ->cadena('cadena_uno')
            ->crearTabla();

        Migracion::tabla(['tabla_dos', 'tabla_tres'])->crearLlavePrimaria(
            'entero_grande'
        );

        Migracion::tabla('tabla_tres')->crearLlaveForanea(
            'tabla_dos_entero_grande', 'tabla_dos',
            'entero_grande', 'llave_foranea_tabla_dos_entero_grande',
            null, Atributo::CASCADA
        );

        Migracion::tabla('tabla_tres')->crearCampo(
            'cadena_dos', Atributo::CADENA, null
        );

        Migracion::tabla('tabla_tres')->cambiarCampo(
            'cadena', 'cadena_cero', Atributo::CARACTER,
            (new Atributo)->cotejamiento('SQL_Latin1_General_CP1_CI_AS'), 255
        );

        Migracion::tabla('tabla_tres')->borrarCampo('cadena_dos');

        Migracion::tabla('tabla_tres')->borrarRestriccion(
            'llave_foranea_tabla_dos_entero_grande', true
        );

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
