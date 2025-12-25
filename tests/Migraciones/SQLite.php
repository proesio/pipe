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

namespace PIPE\Tests\Migraciones;

use PIPE\Configuracion;
use PIPE\Migracion\Atributo;
use PIPE\Migracion\Migracion;

class SQLite
{
    /**
     * Ejecuta el proceso de migración.
     * 
     * @return $void
     */
    public static function migrar()
    {
        Configuracion::inicializar($GLOBALS['CONFIG_GLOBAL'], 'sqlite');

        Migracion::tabla(
            [
                'documentos', 'role_usuario', 'temas',
                'roles', 'usuarios', 'telefonos'
            ]
        )->borrarTabla(true);

        Migracion::tabla('telefonos')
            ->entero('id', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('numero', (new Atributo)->nulo())
            ->marcaTiempo('creado_en', (new Atributo)->nulo())
            ->marcaTiempo('actualizado_en', (new Atributo)->nulo())
            ->marcaTiempo('eliminado_en', (new Atributo)->nulo())
            ->crearTabla();

        Migracion::tabla('usuarios')
            ->entero('id', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('telefono_id', (new Atributo)->noNulo())
            ->cadena('nombres', 255, (new Atributo)->nulo())
            ->cadena('apellidos', 255, (new Atributo)->nulo())
            ->marcaTiempo('creado_en', (new Atributo)->nulo())
            ->marcaTiempo('actualizado_en', (new Atributo)->nulo())
            ->marcaTiempo('eliminado_en', (new Atributo)->nulo())
            ->llaveForanea('telefono_id', 'telefonos', 'id', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla();

        Migracion::tabla('roles')
            ->entero('id', (new Atributo)->llavePrimaria()->autoincrementable())
            ->cadena('nombre', 255, (new Atributo)->nulo())
            ->marcaTiempo('creado_en', (new Atributo)->nulo())
            ->marcaTiempo('actualizado_en', (new Atributo)->nulo())
            ->marcaTiempo('eliminado_en', (new Atributo)->nulo())
            ->crearTabla();

        Migracion::tabla('temas')
            ->entero('id', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('usuario_id', (new Atributo)->nulo())
            ->cadena('titulo', 255, (new Atributo)->nulo())
            ->cadena('descripcion', 1000, (new Atributo)->nulo())
            ->marcaTiempo('creado_en', (new Atributo)->nulo())
            ->marcaTiempo('actualizado_en', (new Atributo)->nulo())
            ->marcaTiempo('eliminado_en', (new Atributo)->nulo())
            ->llaveForanea('usuario_id', 'usuarios', 'id', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla();

        Migracion::tabla('role_usuario')
            ->entero('role_id', (new Atributo)->noNulo())
            ->entero('usuario_id', (new Atributo)->noNulo())
            ->llaveForanea('role_id', 'roles', 'id', Atributo::RESTRICCION, Atributo::CASCADA)
            ->llaveForanea('usuario_id', 'usuarios', 'id', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla();

        Migracion::tabla('documentos')
            ->entero('id', (new Atributo)->llavePrimaria()->autoincrementable())
            ->entero('usuario_id', (new Atributo)->noNulo())
            ->cadena('numero', 255, (new Atributo)->nulo())
            ->marcaTiempo('creado_en', (new Atributo)->nulo())
            ->marcaTiempo('actualizado_en', (new Atributo)->nulo())
            ->marcaTiempo('eliminado_en', (new Atributo)->nulo())
            ->llaveForanea('usuario_id', 'usuarios', 'id', Atributo::RESTRICCION, Atributo::CASCADA)
            ->crearTabla();
    }
}
