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

namespace PIPE\Rasgos;

trait Encadenable
{
    /**
     * Valida que un valor a buscar se encuentre separado 
     * por espacios en ambos extremos dentro de una cadena.
     *
     * @param string         $buscar   buscar
     * @param string         $cadena   cadena
     * @param string|boolean $IF       IF
     * @param boolean        $sensible sensible
     * 
     * @return boolean|string
     */
    public function validarCadenaIndependiente(
        $buscar, $cadena, $IF = '', $sensible = true
    ) {
        /**
         * Valida si la cadena $buscar 
         * es independiente o se encuentra dentro de otra.
         */

        if ($sensible == true || $IF === true) {
            $posicion = strpos($cadena, $buscar);
        }

        if ($sensible == false || $IF === false) {
            $posicion = stripos($cadena, $buscar);
        }

        $tamano = strlen($buscar);

        $I = substr($cadena, $posicion-1, 1);
        $F = substr($cadena, $posicion+$tamano, 1);

        if ($IF == 'I') {
            return trim($I);
        } elseif ($IF == 'F') {
            return trim($F);
        } else {
            if (trim($I) == '' && trim($F) == '') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Remplaza la primera coincidencia que encuentra en una cadena.
     *
     * @param string  $viejo    viejo
     * @param string  $nuevo    nuevo
     * @param string  $cadena   cadena
     * @param boolean $sensible sensible
     * 
     * @return string
     */
    public function remplazarPrimeraCadena(
        $viejo, $nuevo, $cadena, $sensible = true
    ) {
        $condicion = $sensible === true 
            ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;

        $posicionInicial = $sensible === true 
            ? strpos($cadena, $viejo) : stripos($cadena, $viejo);

        if ($condicion) {
            $cadena = substr_replace(
                $cadena, $nuevo, $posicionInicial, strlen($viejo)
            );
        }

        return $cadena;
    }

    /**
     * Remplaza un valor que se encuentre separado 
     * por espacios en ambos extremos dentro de una cadena.
     *
     * @param string  $viejo    viejo
     * @param string  $nuevo    nuevo
     * @param string  $cadena   cadena
     * @param boolean $sensible sensible
     * 
     * @return string
     */
    public function remplazarCadenaIndependiente(
        $viejo, $nuevo, $cadena, $sensible = true
    ) {
        $condicion = $sensible === true 
            ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;

        while ($condicion) {
            $condicion = $sensible === true 
                ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;

            /**
             * Buscamos elementos al inicio y al final de la búsqueda 
             * ($viejo) recibida, para definir si lo encontrado en la $cadena  
             * es una palabra independiente o está dentro de otra.
             */

            $I = $this->validarCadenaIndependiente($viejo, $cadena, 'I', $sensible);
            $F = $this->validarCadenaIndependiente($viejo, $cadena, 'F', $sensible);

            if ($I != '' || $F != '') {
                /**
                 * En caso de que la palabra encontrada no este independiente,
                 * se procede a remplazarla por __DEPENDIENTE37812__ 
                 * para que pueda continuar buscando y remplazando.
                 */

                $cadena = $this->remplazarPrimeraCadena(
                    $viejo, '__DEPENDIENTE37812__', $cadena, $sensible
                );
            } else {
                /**
                 * En caso de que la palabra encontrada este independiente
                 * se procede a reemplazarla por __INPENDIENTE37812__ 
                 * para que pueda continuar buscando y remplazando.
                 */

                $cadena = $this->remplazarPrimeraCadena(
                    $viejo, '__INPENDIENTE37812__', $cadena, $sensible
                );
            }
        }

        // Volvemos a poner los __DEPENDIENTE37812__ por los catacteres $viejo.
        // Volvemos a poner los __INPENDIENTE37812__ por los catacteres $nuevo.

        $cadena = str_replace('__DEPENDIENTE37812__', $viejo, $cadena);
        $cadena = str_replace('__INPENDIENTE37812__', $nuevo, $cadena);

        return $cadena;
    }
}
