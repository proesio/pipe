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

namespace PIPE\Clases;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class Archivo
{
    /**
     * Crea una nueva instancia de la clase Archivo.
     *
     * @return void
     */
    public function __construct()
    {
        $this->importarModelos();
    }

    /**
     * Importa los modelos ubicados en el directorio especificado.
     *
     * @return void
     * 
     * @throws PIPE\Clases\Excepciones\ORM
     */
    public function importarModelos()
    {
        if ($rutaModelos = Configuracion::config('RUTA_MODELOS')) {
            if (!file_exists($rutaModelos)) {
                Error::mostrar(
                    Mensaje::$mensajes['RUTA_MODELOS_NO_ENCONTRADA']
                    .': '.$rutaModelos
                );
            }

            $iterador =  new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rutaModelos),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterador as $valor) {
                if (substr($valor->getPathname(), -3) == 'php') {
                    include_once $valor->getPathname();
                }
            }
        }
    }
}
