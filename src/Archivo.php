<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  8.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE;

use PIPE\Error;
use PIPE\Mensaje;
use PIPE\Configuracion;
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
     * @throws \PIPE\Excepciones\ORMExcepcion
     */
    public function importarModelos()
    {
        $config = Configuracion::obtenerConfig();

        $rutas = [];

        if (isset($config['RUTA_MODELOS'])) {
            $rutas[] = $config['RUTA_MODELOS'];
        } else {
            foreach ($config as $valor) {
                $rutas[] = $valor['RUTA_MODELOS'];
            }
        }

        foreach ($rutas as $ruta) {
            if (!file_exists($ruta)) {
                Error::mostrar(
                    Mensaje::$mensajes['RUTA_MODELOS_NO_ENCONTRADA']
                        . ': ' . $ruta
                );
            }

            $iterador =  new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($ruta),
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
