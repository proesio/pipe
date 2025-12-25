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

namespace PIPE\Conectores;

use PIPE\Configuracion;

class SQLite
{
    /**
     * Obtiene el dsn para la conexión.
     *
     * @return string
     */
    public static function obtenerDSN()
    {
        $controlador = Configuracion::config('BD_CONTROLADOR');
        $basedatos = Configuracion::config('BD_BASEDATOS');

        $dsn = $controlador.':'.$basedatos;

        return $dsn;
    }

    /**
     * Obtiene sentencia para cláusula limit.
     *
     * @param int      $cantidad cantidad
     * @param int|null $inicio   inicio
     * 
     * @return string
     */
    public static function obtenerCadenaLimite($cantidad, $inicio = null)
    {
        $limite = 'limit '.$cantidad;

        if ($inicio) {
            $limite = 'limit '.$inicio.', '.$cantidad;
        }

        return $limite;
    }

    /**
     * Obtiene sentencias para cláusula truncate.
     *
     * @param string $tabla   cantidad
     * @param bool   $forzado forzado
     * 
     * @return array
     */
    public static function obtenerSentenciasTruncar($tabla, $forzado = false)
    {
        return [
            'delete from '.$tabla,
            'update sqlite_sequence set seq = 0 where name = '."'".$tabla."'"
        ];
    }

    /**
     * Obtiene el atributo para que un campo sea autoincrementable.
     * 
     * @return string
     */
    public static function obtenerAtributoAutoincrementable()
    {
        return 'autoincrement';
    }

    /**
     * Obtiene la sentencia para borrar un índice.
     * 
     * @param string $nombre nombre
     * 
     * @return string
     */
    public static function obtenerSentenciaBorrarIndice($nombre)
    {
        return 'drop index if exists '.$nombre;
    }

    /**
     * Obtiene la sentencia para cambiar un campo.
     * 
     * @param string $tabla        tabla
     * @param string $nombreActual nombreActual
     * @param string $nombreNuevo  nombreNuevo
     * @param string $tipo         tipo
     * @param string $atributos    atributos
     * 
     * @return string
     */
    public static function obtenerSentenciaCambiarCampo(
        $tabla, $nombreActual, $nombreNuevo, $tipo, $atributos
    ) {
        return 'alter table '.$tabla.' rename column '
            .$nombreActual.' to '.$nombreNuevo;
    }
}
