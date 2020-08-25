<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 24-08-2020
 * Versión: 4.2.6
 * Sitio web: https://pipe.proes.tk
 *
 * Copyright (C) 2018 - 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
   
 * Traducción al español de la licencia MIT
   
 * Copyright (C) 2018 - 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>

 * Se concede permiso por la presente, libre de cargos, a cualquier persona
 * que obtenga una copia de este software y de los archivos de documentación asociados 
 * (el "Software"), a utilizar el Software sin restricción, incluyendo sin limitación 
 * los derechos a usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar, 
 * y/o vender copias del Software, y a permitir a las personas a las que se les proporcione 
 * el Software a hacer lo mismo, sujeto a las siguientes condiciones:

 * El aviso de copyright anterior y este aviso de permiso se incluirán 
 * en todas las copias o partes sustanciales del Software.

 * EL SOFTWARE SE PROPORCIONA "COMO ESTÁ", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA,
 * INCLUYENDO PERO NO LIMITADO A GARANTÍAS DE COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO
 * PARTICULAR E INCUMPLIMIENTO. EN NINGÚN CASO LOS AUTORES O PROPIETARIOS DE LOS DERECHOS DE AUTOR
 * SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN
 * DE CONTRATO, AGRAVIO O CUALQUIER OTRO MOTIVO, DERIVADAS DE, FUERA DE O EN CONEXIÓN
 * CON EL SOFTWARE O SU USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.
 */

namespace PIPE\Rasgos;

trait Encadenable{
    
    /*
     * Valida que un valor a buscar se encuentre separado por espacios en ambos extremos dentro de una cadena.
     *
     * @parametro string $buscar
     * @parametro string $cadena
     * @parametro string|boolean $IF
     * @parametro boolean $sensible
     * @retorno boolean|string
     */
    public function validarCadenaIndependiente($buscar, $cadena, $IF='', $sensible = true){
        //Valida si la cadena $buscar es independiente o se encuentra dentro de otra.
        if($sensible == true || $IF === true) $posicion = strpos($cadena, $buscar);
        if($sensible == false || $IF === false) $posicion = stripos($cadena, $buscar);
        $tamano = strlen($buscar);
        $I = substr($cadena, $posicion-1, 1);
        $F = substr($cadena, $posicion+$tamano, 1);
        if($IF == 'I'){
            return trim($I);
        }
        else if($IF == 'F'){
            return trim($F);
        }
        else{
            if(trim($I) == '' && trim($F) == '')
                return true;
            else
                return false;
        }
    }
    
    /*
     * Remplaza la primera coincidencia que encuentra en una cadena.
     *
     * @parametro string $viejo
     * @parametro string $nuevo
     * @parametro string $cadena
     * @parametro boolean $sensible
     * @retorno string
     */
    public function remplazarPrimeraCadena($viejo, $nuevo, $cadena, $sensible = true){
        $condicion = $sensible === true ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;
        $posicionInicial = $sensible === true ? strpos($cadena, $viejo) : stripos($cadena, $viejo);
        if($condicion) $cadena = substr_replace($cadena, $nuevo, $posicionInicial, strlen($viejo));
        //$cadena = preg_replace('/'.preg_quote($viejo, '/').'/', $nuevo, $cadena, 1);
        return $cadena;
    }
    
    /*
     * Remplaza un valor que se encuentre separado por espacios en ambos extremos dentro de una cadena.
     *
     * @parametro string $viejo
     * @parametro string $nuevo
     * @parametro string $cadena
     * @parametro boolean $sensible
     * @retorno string
     */
    public function remplazarCadenaIndependiente($viejo, $nuevo, $cadena, $sensible = true){
        $condicion = $sensible === true ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;
        while($condicion){
            $condicion = $sensible === true ? strpos($cadena, $viejo) > -1 : stripos($cadena, $viejo) > -1;
            /*
             Buscamos elementos al inicio y al final de la busqueda ($viejo) recibida
             para definir si lo encontrado en la $cadena es una palabra independiente o está dentro de otra.
            */
            $I = $this->validarCadenaIndependiente($viejo, $cadena, 'I', $sensible);
            $F = $this->validarCadenaIndependiente($viejo, $cadena, 'F', $sensible);
            if($I != '' || $F != ''){
                /*
                 En caso de que la palabra encontrada no este independiente
                 se procede a remplazarla por __DEPENDIENTE37812__ para que pueda continuar buscando y remplazando.
                */
                $cadena = $this->remplazarPrimeraCadena($viejo, '__DEPENDIENTE37812__', $cadena, $sensible);
            }
            else{
                /*
                 En caso de que la palabra encontrada este independiente
                 se procede a reemplazarla por __INPENDIENTE37812__ para que pueda continuar buscando y remplazando.
                */
                $cadena = $this->remplazarPrimeraCadena($viejo, '__INPENDIENTE37812__', $cadena, $sensible);
                //$cadena = preg_replace('/'.preg_quote($viejo, '/').'/', $nuevo, $cadena, 1);
            }
        }
        /*
         Volvemos a poner los __DEPENDIENTE37812__ por los catacteres $viejo
         Volvemos a poner los __INPENDIENTE37812__ por los catacteres $nuevo.
        */
        $cadena = str_replace('__DEPENDIENTE37812__', $viejo, $cadena);
        $cadena = str_replace('__INPENDIENTE37812__', $nuevo, $cadena);
        return $cadena;
    }
}