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

class MySQLTest extends TestCase
{
    public $conexion = 'mysql';

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
            ->enteroGrande('entero_grande', (new Atributo)->sinSigno()->autoincrementable()->llavePrimaria())
            ->enteroMuyPequeno('entero_muy_pequeno', (new Atributo)->nulo())
            ->enteroPequeno('entero_pequeno', (new Atributo)->noNulo())
            ->enteroMediano('entero_mediano', (new Atributo)->unico())
            ->entero('entero', (new Atributo)->predeterminado(7))
            ->decimal('campo_decimal', 20, 2)
            ->numerico('numerico', 20, 2)
            ->flotante('flotante', 20, 2)
            ->doble('doble', 20, 2)
            ->real('campo_real', 20, 2)
            ->caracter('caracter', 255, (new Atributo)->cotejamiento('utf8mb4_general_ci'))
            ->cadena('cadena')
            ->textoMuyPequeno('texto_muy_pequeno')
            ->textoMediano('texto_mediano')
            ->texto('texto')
            ->textoLargo('texto_largo')
            ->fecha('fecha')
            ->fechaHora('fecha_hora')
            ->marcaTiempo('marca_tiempo')
            ->hora('hora')
            ->anio('anio')
            ->booleano('booleano')
            ->binario('binario')
            ->binarioVariable('binario_variable')
            ->binarioGrande('binario_grande')
            ->coordenada('coordenada')
            ->coordenadaLinea('coordenada_linea')
            ->poligono('poligono')
            ->enumerado('enumerado', ['Valor1', 'Valor2'])
            ->conjunto('conjunto', ['Valor1', 'Valor2'])
            ->json('json')
            ->personalizado("personalizado varchar(255) null default 'valor'")
            ->motor('InnoDB')
            ->crearTabla();

        Migracion::tabla('tabla_uno')
            ->enteroGrande('entero_grande', (new Atributo)->sinSigno()->autoincrementable())
            ->cadena('cadena_uno')
            ->cadena('cadena_dos')
            ->cadena('cadena_tres')
            ->restriccion('llave_primaria_entero_grande')
            ->llavePrimaria('entero_grande')
            ->crearTabla(true);

        Migracion::tabla('tabla_uno')->crearIndice(
            ['cadena_uno', 'cadena_dos'], 'indice_cadena_uno_cadena_dos'
        );

        Migracion::tabla('tabla_uno')->crearIndiceUnico(
            'cadena_tres', 'indice_unico_cadena_tres'
        );

        Migracion::tabla('tabla_dos')
            ->enteroGrande('entero_grande', (new Atributo)->sinSigno())
            ->enteroGrande('tabla_uno_entero_grande', (new Atributo)->sinSigno())
            ->cadena('cadena')
            ->restriccion('llave_foranea_tabla_uno_entero_grande')
            ->llaveForanea('tabla_uno_entero_grande', 'tabla_uno', 'entero_grande', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla(true);

        Migracion::tabla('tabla_tres')
            ->enteroGrande('entero_grande', (new Atributo)->sinSigno())
            ->enteroGrande('tabla_dos_entero_grande', (new Atributo)->sinSigno())
            ->cadena('cadena')
            ->cadena('cadena_uno')
            ->crearTabla(true);

        Migracion::tabla(['tabla_dos', 'tabla_tres'])->crearLlavePrimaria(
            'entero_grande', 'llave_primaria_entero_grande'
        );

        Migracion::tabla('tabla_tres')->crearLlaveForanea(
            'tabla_dos_entero_grande', 'tabla_dos',
            'entero_grande', 'llave_foranea_tabla_dos_entero_grande',
            Atributo::RESTRICCION, Atributo::CASCADA
        );

        Migracion::tabla('tabla_tres')->crearCampo(
            'cadena_dos', Atributo::CADENA, null, 255, 'cadena_uno'
        );

        Migracion::tabla('tabla_tres')->cambiarCampo(
            'cadena', 'cadena_cero', Atributo::CARACTER,
            (new Atributo)->cotejamiento('utf8mb4_general_ci'), 255
        );

        Migracion::tabla('tabla_tres')->borrarCampo('cadena_dos');

        Migracion::tabla('tabla_tres')->borrarLlavePrimaria();

        Migracion::tabla('tabla_tres')->borrarLlaveForanea(
            'llave_foranea_tabla_dos_entero_grande'
        );

        Migracion::tabla('tabla_tres')->borrarIndice(
            'llave_foranea_tabla_dos_entero_grande'
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
