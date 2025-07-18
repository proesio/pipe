<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP versión 8. 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  6.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Clases\Conectores;

use PIPE\Clases\Configuracion;

class SQLServer
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
        $datosDsn = Configuracion::config('BD_DATOS_DSN');

        $basedatos = $basedatos ? 'database='.$basedatos.';' : '';

        if ($host && $puerto) {
            $host = 'server='.$host.','.$puerto.';';
        } elseif ($host) {
            $host = 'server='.$host.';';
        }

        $dsn = $controlador.':'.$host.$basedatos.$datosDsn;

        return $dsn;
    }

    /**
     * Obtiene sentencia para cláusula limit.
     *
     * @param string   $ordenar       ordenar
     * @param string   $llavePrimaria llavePrimaria
     * @param int      $cantidad      cantidad
     * @param int|null $inicio        inicio
     * 
     * @return string
     */
    public static function obtenerCadenaLimite(
        $ordenar, $llavePrimaria, $cantidad, $inicio = null
    ) {
        $inicio = $inicio ? $inicio : 0;

        if ($ordenar) {
            $limite = 'offset '.$inicio.' rows '
                .'fetch next '.$cantidad.' rows only';
        } else {
            $limite = 'order by '.$llavePrimaria.' asc '
                .'offset '.$inicio.' rows '
                .'fetch next '.$cantidad.' rows only';
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
            $sentencias[] = 'alter table '.$tabla.' nocheck constraint all';
        }

        $sentencias[] = 'delete from '.$tabla;
        $sentencias[] = 'dbcc checkident('.$tabla.', reseed, 0)';

        if ($forzado) {
            $sentencias[] = 'alter table '.$tabla.' with check check constraint all';
        }

        return $sentencias;
    }
}
