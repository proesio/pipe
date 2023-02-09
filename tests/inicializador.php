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

error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/PIPE/inicializador.php';

$configGlobal = include __DIR__.'/../tests/config.php';

require __DIR__.'/funciones.php';
