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

namespace PIPE\Clases;

class Mensaje
{
    /**
     * Mensajes según el idioma establecido.
     *
     * @var array
     */
    public static $mensajes = [];

    /**
     * Crea una nueva instancia de la clase Mensaje.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_asignarMensajes();
    }

    /**
     * Asigna los mensajes según el idioma establecido.
     *
     * @return void
     * 
     * @throws PIPE\Clases\Excepciones\ORM
     */
    private function _asignarMensajes()
    {
        $idioma = Configuracion::config('IDIOMA', 'es');

        switch($idioma){
        case 'es':
            self::$mensajes = include __DIR__.'/../Idiomas/es.php';
            break;
        case 'en':
            self::$mensajes = include __DIR__.'/../Idiomas/en.php';
            break;
        default:
            Error::mostrar(
                'IDIOMA '.$idioma.' desconocido. Idiomas admitidos: es, en.'
            );
            break;
        }
    }
}
