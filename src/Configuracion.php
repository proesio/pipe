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

use PIPE\PIPE;
use PIPE\Error;
use PIPE\Archivo;
use PIPE\Mensaje;
use PIPE\Conexion;

class Configuracion
{
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
     * Configuraciones del ORM PIPE.
     *
     * @var array
     */
    private static $_configs = [];

    /**
     * Configuración del ORM PIPE.
     *
     * @var array
     */
    private static $_config = [];

    /**
     * Inicializa la configuración del ORM PIPE.
     *
     * @param array $configs           config
     * @param mixed $predeterminado    predeterminado
     * @param bool  $reiniciarConexion reiniciarConexion
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\ORMExcepcion
     */
    public static function inicializar(
        $configs, $predeterminado = null, $reiniciarConexion = false
    ) {
        if ($predeterminado === true || $reiniciarConexion === true) {
            Conexion::$conexion = null;

            self::$_configs = [];

            self::$_config = [];
        }

        if (is_array($configs)) {
            $predeterminado ??= '';

            if (self::_validarMatrizBidimencional($configs) 
                && array_key_exists($predeterminado, $configs)
            ) {
                if (!self::$_config) {
                    PIPE::$conexionPredeterminada['nombre'] = $predeterminado;
                }

                self::$_configs = $configs;
                self::$_config = $configs[$predeterminado];
                self::_instanciarClases();
            } elseif (!self::_validarMatrizBidimencional($configs)) {
                self::$_configs = $configs;
                self::$_config = $configs;
                self::_instanciarClases();
            } else {
                Error::mostrar(
                    'Inicialización de configuración incorrecta.'
                );
            }
        } else {
            Error::mostrar(
                'Inicialización de configuración incorrecta.'
            );
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
     * Inicializa la configuración del ORM PIPE definiendo un nombre de conexión.
     *
     * @param string $nombre nombre
     * 
     * @return void
     */
    public static function inicializarConfig($nombre)
    {
        self::inicializar(self::$_configs, $nombre);
    }

    /**
     * Obtiene la configuración del ORM PIPE definiendo un nombre de conexión.
     *
     * @param string $nombre nombre
     * 
     * @return array
     */
    public static function obtenerConfig($nombre = '')
    {
        return self::$_configs[$nombre] ?? self::$_configs;
    }

    /**
     * Establece la configuración del ORM PIPE definiendo
     * un nombre de conexión sin reasignar la instancia de PDO.
     *
     * @param string $nombre nombre
     * 
     * @return void
     */
    public static function establecerConfig($nombre)
    {
        if (self::_validarMatrizBidimencional(self::$_configs)
            && array_key_exists($nombre, self::$_configs)
        ) {
            self::$_config = self::$_configs[$nombre];
        }
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
     * @return bool
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
