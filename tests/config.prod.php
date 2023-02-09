<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * Cree una copia de este archivo con el nombre config.php 
 * para sobrescribir la configuración en modo desarrollo.
 * En el directorio ./SQL encontrará las sentencias SQL para
 * crear las tablas por cada controlador.
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

use PIPE\Clases\Configuracion;

return [
    'mysql' => [
        'BD_CONTROLADOR' => 'mysql',
        'BD_HOST' => 'mysql',
        'BD_PUERTO' => 3306,
        'BD_USUARIO' => 'root',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'pipe',
        'IDIOMA' => 'es',
        'RUTA_MODELOS' => __DIR__.'/Modelos',
        'ZONA_HORARIA' => 'America/Bogota',
        'COMANDO_INICIAL' => 'set names utf8mb4 collate utf8mb4_unicode_ci',
        'TIPO_RETORNO' => Configuracion::CLASE,
        'OPCIONES' => [
            PDO::MYSQL_ATTR_LOCAL_INFILE => 1
        ]
    ],
    'pgsql' => [
        'BD_CONTROLADOR' => 'pgsql',
        'BD_HOST' => 'postgresql',
        'BD_PUERTO' => 5432,
        'BD_USUARIO' => 'root',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'pipe',
        'IDIOMA' => 'es',
        'RUTA_MODELOS' => __DIR__.'/Modelos',
        'ZONA_HORARIA' => 'America/Bogota',
        'COMANDO_INICIAL' => '',
        'TIPO_RETORNO' => Configuracion::CLASE,
        'OPCIONES' => []
    ],
    'sqlite' => [
        'BD_CONTROLADOR' => 'sqlite',
        'BD_BASEDATOS' => __DIR__.'/ruta/a/mi/basedatos.sqlite',
        'IDIOMA' => 'es',
        'RUTA_MODELOS' => __DIR__.'/Modelos',
        'ZONA_HORARIA' => 'America/Bogota',
        'COMANDO_INICIAL' => '',
        'TIPO_RETORNO' => Configuracion::CLASE,
        'OPCIONES' => []
    ],
    'sqlsrv' => [
        'BD_CONTROLADOR' => 'sqlsrv',
        'BD_HOST' => 'sqlserver',
        'BD_PUERTO' => 1433,
        'BD_USUARIO' => 'sa',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'pipe',
        'IDIOMA' => 'es',
        'RUTA_MODELOS' => __DIR__.'/Modelos',
        'ZONA_HORARIA' => 'America/Bogota',
        'COMANDO_INICIAL' => '',
        'TIPO_RETORNO' => Configuracion::CLASE,
        'OPCIONES' => []
    ],
];
