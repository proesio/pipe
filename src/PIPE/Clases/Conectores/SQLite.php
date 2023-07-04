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

namespace PIPE\Clases\Conectores;

use PIPE\Clases\Configuracion;

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
     * @param string  $tabla   cantidad
     * @param boolean $forzado forzado
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
}
