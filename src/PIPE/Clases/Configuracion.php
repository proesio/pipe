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

use Exception;

class Configuracion
{
    /**
     * Configuraciones del ORM PIPE.
     *
     * @var array
     */
    public static $configs = [];

    /**
     * Configuración del ORM PIPE.
     *
     * @var array
     */
    private static $_config = [];

    /**
     * Indica el retorno de resultados de una consulta SQL como una clase.
     *
     * @var string
     */
    public const CLASE = 'clase';

    /**
     * Indica el retorno de resultados de una consulta SQL como un objeto.
     *
     * @var string
     */
    public const OBJETO = 'objeto';

    /**
     * Indica el retorno de resultados de una consulta SQL como un arreglo.
     *
     * @var string
     */
    public const ARREGLO = 'arreglo';

    /**
     * Indica el retorno de resultados de una consulta SQL como una cadena de json.
     *
     * @var string
     */
    public const JSON = 'json';

    /**
     * Indica el retorno de la consulta SQL generada.
     *
     * @var string
     */
    public const SQL = 'sql';

    /**
     * Inicializa la configuración del ORM PIPE.
     *
     * @param array       $configs        config
     * @param string|null $predeterminado predeterminado
     * 
     * @return void
     * 
     * @throws \Exception
     */
    public static function inicializar($configs, $predeterminado = null)
    {
        if (is_array($configs)) {
            if (self::_validarMatrizBidimencional($configs) 
                && array_key_exists($predeterminado, $configs)
            ) {
                self::$configs = $configs;
                self::$_config = $configs[$predeterminado];
                self::_incluirArchivos();
            } elseif (!self::_validarMatrizBidimencional($configs)) {
                self::$configs = $configs;
                self::$_config = $configs;
                self::_incluirArchivos();
            } else {
                throw new Exception('Inicialización de configuración incorrecta.');
            }
        } else {
            throw new Exception('Inicialización de configuración incorrecta.');
        }
    }

    /**
     * Obtiene una variable de la configuración del ORM PIPE.
     *
     * @param string      $nombre         nombre
     * @param string|null $predeterminado predeterminado
     * 
     * @return string|null
     */
    public static function config($nombre, $predeterminado = null)
    {
        $valor = $predeterminado;

        if (array_key_exists($nombre, self::$_config)
            && !empty(self::$_config[$nombre])
        ) {
            $valor = self::$_config[$nombre];
        }

        return $valor;
    }

    /**
     * Inicializa la configuración del ORM PIPE definiendo un nombre.
     *
     * @param string $nombre nombre
     * 
     * @return void
     */
    public static function inicializarConfig($nombre)
    {
        self::inicializar(self::$configs, $nombre);
    }

    /**
     * Incluye los archivos del ORM PIPE.
     *
     * @return void
     */
    private static function _incluirArchivos()
    {
        include_once __DIR__.'/../Rasgos/Encadenable.php';
        include_once 'Error.php';
        include_once 'Mensaje.php';
        include_once 'Conectores/MySQL.php';
        include_once 'Conectores/PostgreSQL.php';
        include_once 'Conectores/SQLite.php';
        include_once 'Conectores/SQLServer.php';
        include_once 'Excepciones/ORM.php';
        include_once 'Excepciones/SQL.php';
        include_once 'Conexion.php';
        include_once 'ConstructorConsulta.php';
        include_once 'PIPE.php';
        include_once 'Modelo.php';
        include_once 'Archivo.php';

        self::_instanciarClases();
    }

    /**
     * Instancia las clases al inicio de la configuración.
     *
     * @return void
     */
    private static function _instanciarClases()
    {
        new Mensaje();
        new Conexion();
        new Archivo();
    }

    /**
     * Valida que un arreglo sea una matriz bidimencional.
     *
     * @param array $matriz matriz
     * 
     * @return boolean
     */
    private static function _validarMatrizBidimencional($matriz)
    {
        $esMatrizBidimencional = true;

        foreach ($matriz as $elemento) {
            if (!is_array($elemento)) {
                $esMatrizBidimencional = false;
            }
        }

        return $esMatrizBidimencional;
    }
}
