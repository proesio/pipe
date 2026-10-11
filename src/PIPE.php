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

use Closure;
use Exception;
use Throwable;
use PIPE\Conexion;
use PIPE\Configuracion;
use PIPE\ConstructorConsulta;
use PIPE\Excepciones\ORMExcepcion;
use PIPE\Excepciones\SQLExcepcion;

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
    public const VERSION = '8.0.0';

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
     * Indica la conexión predeterminada a la base de datos por medio de PDO.
     *
     * @var array
     */
    public static $conexionPredeterminada = [
        'nombre' => null,
        'pdo' => null
    ];

    /**
     * Indica las conexiones a las bases de datos por medio de PDO.
     *
     * @var array
     */
    private static $_conexiones = [];

    /**
     * Indica si la conexión ha sido reasignada.
     *
     * @var bool
     */
    private static $_conexionReasignada = false;

    /**
     * Indica la cantidad de intentos transaccionales.
     *
     * @var int
     */
    private static $_intentosTransaccion = 0;

    /**
     * Indica la cantidad de tiempo de espera
     * para reintentar la transacción (milisegundos).
     *
     * @var int
     */
    private static $_tiempoReintentoTransaccion = 10;

    /**
     * Establece el nombre de la tabla en el Constructor de Consulta.
     *
     * @param string $tabla tabla
     * 
     * @return \PIPE\ConstructorConsulta
     */
    public static function tabla($tabla)
    {
        $propiedades = ['tabla' => $tabla];

        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;
        } else {
            $propiedades['conexion'] = self::$conexionPredeterminada['nombre'];
        }

        return new ConstructorConsulta($propiedades);
    }

    /**
     * Realiza una consulta SQL en español.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|string|int
     */
    public static function consulta($consulta, $parametros = [], $tipoRetorno = null)
    {
        $propiedades = [];

        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;
        } else {
            $propiedades['conexion'] = self::$conexionPredeterminada['nombre'];
        }

        $pipe = new ConstructorConsulta($propiedades);

        return $pipe->consulta(...func_get_args());
    }

    /**
     * Realiza una consulta SQL nativa.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|string|int
     */
    public static function consultaNativa(
        $consulta, $parametros = [], $tipoRetorno = null
    ) {
        $propiedades = [];

        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;
        } else {
            $propiedades['conexion'] = self::$conexionPredeterminada['nombre'];
        }

        $pipe = new ConstructorConsulta($propiedades);

        return $pipe->consultaNativa(...func_get_args());
    }

    /**
     * Realiza una sentencia SQL en español.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|bool
     */
    public static function sentencia($sentencia)
    {
        $propiedades = [];

        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;
        } else {
            $propiedades['conexion'] = self::$conexionPredeterminada['nombre'];
        }

        $pipe = new ConstructorConsulta($propiedades);

        return $pipe->sentencia(...func_get_args());
    }

    /**
     * Realiza una sentencia SQL nativa.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|bool
     */
    public static function sentenciaNativa($sentencia)
    {
        $propiedades = [];

        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;
        } else {
            $propiedades['conexion'] = self::$conexionPredeterminada['nombre'];
        }

        $pipe = new ConstructorConsulta($propiedades);

        return $pipe->sentenciaNativa(...func_get_args());
    }

    /**
     * Obtiene la instancia de PDO.
     *
     * @return \PDO
     */
    public static function obtenerPDO()
    {
        if (self::$_conexionReasignada) {
            self::$_conexionReasignada = false;

            return Conexion::$conexion;
        }

        return self::$conexionPredeterminada['pdo'];
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
        self::$_conexionReasignada = true;

        Configuracion::establecerConfig($nombre);

        if (isset(self::$_conexiones[$nombre])) {
            Conexion::$conexion = self::$_conexiones[$nombre];
        } else {
            if ($nombre == self::$conexionPredeterminada['nombre']) {
                self::$_conexiones[$nombre] = self::$conexionPredeterminada['pdo'];

                Conexion::$conexion = self::$_conexiones[$nombre];
            } else {
                Configuracion::inicializarConfig($nombre);

                self::$_conexiones[$nombre] = Conexion::$conexion;
            }
        }

        return new self();
    }

    /**
     * Procesa SQL de forma transaccional.
     *
     * @param Closure $accion   accion
     * @param int     $intentos intentos
     * 
     * @return mixed
     */
    public static function transaccion($accion, $intentos = 1)
    {
        if (!($accion instanceof Closure)) {
            Error::mostrar(
                Mensaje::$mensajes['INSTANCIA_CLOSURE_NO_DEFINIDA']
            );
        }

        $pdo = self::obtenerPDO();

        $pdo->beginTransaction();

        try {
            $resultado = $accion();

            $pdo->commit();

            return $resultado;
        } catch (ORMExcepcion $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            Error::mostrar($e->getMessage());
        } catch (SQLExcepcion $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            if (isset($e->errorInfo)) {
                $sqlCodigosInterbloqueos = ['40001', '40p01', '40P01'];

                $controladorCodigosInterbloqueos = [1205, 1213];

                $sqliteInterbloqueo = (
                    $e->errorInfo[1] == 5 && str_contains($e->errorInfo[2], 'locked')
                );

                if (in_array($e->errorInfo[0], $sqlCodigosInterbloqueos)
                    || in_array($e->errorInfo[1], $controladorCodigosInterbloqueos)
                    || $sqliteInterbloqueo
                ) {
                    if (++self::$_intentosTransaccion <= $intentos) {
                        usleep(self::$_tiempoReintentoTransaccion * 1000);

                        self::$_tiempoReintentoTransaccion += (
                            self::$_tiempoReintentoTransaccion
                        );

                        return self::transaccion($accion, $intentos);
                    } else {
                        Error::mostrar(
                            $e->errorInfo[0]
                                . ' - ' . $e->errorInfo[1]
                                . ' - ' . $e->errorInfo[2], true
                        );
                    }
                } else {
                    Error::mostrar(
                        $e->errorInfo[0]
                            . ' - ' . $e->errorInfo[1]
                            . ' - ' . $e->errorInfo[2], true
                    );
                }
            } else {
                Error::mostrar($e->getMessage(), true);
            }
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw new Exception($e->getMessage());
        }
    }

    /**
     * Inicia una transacción SQL.
     *
     * @return void
     */
    public static function iniciarTransaccion()
    {
        $pdo = self::obtenerPDO();

        $pdo->beginTransaction();
    }

    /**
     * Confirma una transacción SQL.
     *
     * @return void
     */
    public static function confirmar()
    {
        $pdo = self::obtenerPDO();

        $pdo->commit();
    }

    /**
     * Revierte una transacción SQL.
     *
     * @return void
     */
    public static function revertir()
    {
        $pdo = self::obtenerPDO();

        $pdo->rollBack();
    }
}
