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

namespace PIPE\Rasgos;

trait Matrizable
{
    /**
     * Obtiene los datos asignando una o varias claves personalizadas.
     *
     * @param array        $datos  datos
     * @param array|string $claves claves
     * 
     * @return array
     */
    function obtenerDatosClavePersonalizada($datos, $claves)
    {
        $datosPivote = [];

        if ($datos && is_array($datos)) {
            $datosCopia = $datos;

            $esArreglo = is_array(array_pop($datosCopia));
            $esObjeto = is_object(array_pop($datosCopia));
            $claves = is_array($claves) ? $claves : [$claves];

            foreach ($datos as $clave => $valor) {
                $clavePivote = '';

                foreach ($claves as $valorClave) {
                    if ($esArreglo) {
                        $clavePivote .= ($valor[$valorClave] ?? $clave).'_';
                    } elseif ($esObjeto) {
                        $clavePivote .= ($valor->{$valorClave} ?? $clave).'_';
                    }
                }

                $clavePivote = substr($clavePivote, 0, -1);
                $datosPivote[$clavePivote] = $valor;
            }
        }

        return empty($datosPivote) ? $datos : $datosPivote;
    }

    /**
     * Extrae el valor de la clave seleccionada.
     *
     * @param array  $datos datos
     * @param string $clave clave
     * 
     * @return array
     */
    function extraerClave($datos, $clave)
    {
        $datosExtraidos = [];

        if ($datos && is_array($datos)) {
            $datosCopia = $datos;

            $esArreglo = is_array(array_pop($datosCopia));
            $esObjeto = is_object(array_pop($datosCopia));

            foreach ($datos as $valor) {
                if ($esArreglo && isset($valor[$clave])) {
                    $datosExtraidos[] = $valor[$clave];
                } elseif ($esObjeto && isset($valor->{$clave})) {
                    $datosExtraidos[] = $valor->{$clave};
                }
            }
        }

        return empty($datosExtraidos) ? $datos : $datosExtraidos;
    }
}
