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

namespace Modelos;

use DateTime;
use PIPE\Clases\Modelo;

class Documento extends Modelo
{
    public $perteneceAUno = Usuario::class;

    public function mutarNumeroAsignar($numero)
    {
        return 'C.C. '.$numero;
    }

    public function mutarActualizadoEnObtener($actualizadoEn)
    {
        return new DateTime($actualizadoEn);
    }
}
