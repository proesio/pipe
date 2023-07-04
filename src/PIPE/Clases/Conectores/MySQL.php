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

class MySQL
{
    /**
     * Obtiene el dsn para la conexión.
     *
     * @return string
     */
    public static function obtenerDSN()
    {
        $controlador = Configuracion::config('BD_CONTROLADOR');
        $host = Configuracion::config('BD_HOST');
        $puerto = Configuracion::config('BD_PUERTO');
        $basedatos = Configuracion::config('BD_BASEDATOS');

        $host = $host ? 'host='.$host.';' : '';
        $puerto = $puerto ? 'port='.$puerto.';' : '';
        $basedatos = $basedatos ? 'dbname='.$basedatos.';' : '';

        $dsn = $controlador.':'.$host.$puerto.$basedatos;

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
        $sentencias = [];

        if ($forzado) {
            $sentencias[] = 'set foreign_key_checks = 0';
        }

        $sentencias[] = 'truncate table '.$tabla;

        if ($forzado) {
            $sentencias[] = 'set foreign_key_checks = 1';
        }

        return $sentencias;
    }
}
