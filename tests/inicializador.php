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

error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$GLOBALS['CONFIG_GLOBAL'] = include __DIR__.'/config.php';
$GLOBALS['CONEXIONES'] = ['mysql', 'pgsql', 'sqlite', 'sqlsrv'];

require __DIR__.'/funciones.php';
