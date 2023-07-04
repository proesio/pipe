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

class PIPE
{
    /**
     * Autor del ORM PIPE.
     *
     * @var string
     */
    public const AUTOR = 'Juan Felipe Valencia Murillo';

    /**
     * Versión actual del ORM PIPE.
     *
     * @var string
     */
    public const VERSION = '5.1.0';

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
     * Establece el nombre de la tabla en el Constructor de Consulta.
     *
     * @param string $tabla tabla
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function tabla($tabla)
    {
        return new ConstructorConsulta(['tabla' => $tabla]);
    }

    /**
     * Realiza una consulta SQL en español.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|json|int
     */
    public static function consulta($consulta, $parametros = [], $tipoRetorno = null)
    {
        $pipe = new ConstructorConsulta();
        return $pipe->consulta(...func_get_args());
    }

    /**
     * Realiza una consulta SQL nativa.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|json|int
     */
    public static function consultaNativa(
        $consulta, $parametros = [], $tipoRetorno = null
    ) {
        $pipe = new ConstructorConsulta();
        return $pipe->consultaNativa(...func_get_args());
    }

    /**
     * Realiza una sentencia SQL en español.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|booleano
     */
    public static function sentencia($sentencia)
    {
        $pipe = new ConstructorConsulta();
        return $pipe->sentencia(...func_get_args());
    }

    /**
     * Realiza una sentencia SQL nativa.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|booleano
     */
    public static function sentenciaNativa($sentencia)
    {
        $pipe = new ConstructorConsulta();
        return $pipe->sentenciaNativa(...func_get_args());
    }

    /**
     * Obtiene la instancia de PDO.
     *
     * @return \PDO
     */
    public static function obtenerPDO()
    {
        return Conexion::$conexion;
    }

    /**
     * Establece la conexión según el nombre definido.
     *
     * @param string $nombre nombre
     * 
     * @return self
     */
    public static function conexion($nombre)
    {
        Configuracion::inicializarConfig($nombre);
        return new self();
    }
}
