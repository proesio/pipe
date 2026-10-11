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

use PDO;
use PIPE\PIPE;
use PIPE\Error;
use PDOException;
use PIPE\Mensaje;
use PIPE\Configuracion;
use PIPE\Conectores\MySQL;
use PIPE\Conectores\SQLite;
use PIPE\Conectores\SQLServer;
use PIPE\Conectores\PostgreSQL;

class Conexion
{
    /**
     * Instancia de PDO.
     *
     * @var \PDO|null
     */
    public static $conexion = null;

    /**
     * Crea una nueva instancia de la clase Conexion.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_conectar();
    }

    /**
     * Realiza la conexión a la base de datos.
     *
     * @return \PDO
     * 
     * @throws \PIPE\Excepciones\ORMExcepcion|\PIPE\Excepciones\SQLExcepcion
     */
    private function _conectar()
    {
        if ($this->_validarControlador(Configuracion::config('BD_CONTROLADOR'))) {
            $dsn = match (Configuracion::config('BD_CONTROLADOR')) {
                'mysql' => MySQL::obtenerDSN(),
                'pgsql' => PostgreSQL::obtenerDSN(),
                'sqlite' => SQLite::obtenerDSN(),
                'sqlsrv' => SQLServer::obtenerDSN(),
                default => ''
            };

            try {
                $opciones = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

                $opciones += (Configuracion::config('OPCIONES') ?? []);

                $pdo = new PDO(
                    $dsn,
                    Configuracion::config('BD_USUARIO') ?? null,
                    Configuracion::config('BD_CONTRASENA') ?? null,
                    $opciones
                );

                if (Configuracion::config('COMANDO_INICIAL')) {
                    $pdo->exec(Configuracion::config('COMANDO_INICIAL'));
                }

                if (!self::$conexion) {
                    PIPE::$conexionPredeterminada['pdo'] = $pdo;
                }

                self::$conexion = $pdo;
            } catch(PDOException $e) {
                Error::mostrar(
                    $e->errorInfo[0]
                        . ' - ' . $e->errorInfo[1]
                        . ' - ' . $e->errorInfo[2], true
                );
            }
        } else {
            Error::mostrar(
                'BD_CONTROLADOR ' . Configuracion::config('BD_CONTROLADOR')
                    . ' ' . Mensaje::$mensajes['CONTROLADOR_DESCONOCIDO']
            );
        }
    }

    /**
     * Valida que se ingrese un controlador correcto.
     *
     * @param string $controlador controlador
     * 
     * @return bool
     */
    private function _validarControlador($controlador)
    {
        $controladores = [
            'mysql',
            'pgsql',
            'sqlite',
            'sqlsrv'
        ];

        return in_array($controlador, $controladores);
    }
}
