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

spl_autoload_register(
    function ($archivo) {
        $prefijo = 'PIPE\\';

        $prefijoLongitud = strlen($prefijo);

        if (strncmp($archivo, $prefijo, $prefijoLongitud) === 0) {
            $ruta = str_replace('\\', '/', $archivo);
            $ruta = substr($ruta, $prefijoLongitud);
            $ruta = __DIR__.'/'.$ruta.'.php';

            if (file_exists($ruta)) {
                include_once $ruta;
            }
        }
    }
);
