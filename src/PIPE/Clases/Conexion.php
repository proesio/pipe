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

use PDO;
use PDOException;
use PIPE\Clases\Conectores\MySQL;
use PIPE\Clases\Conectores\SQLite;
use PIPE\Clases\Conectores\SQLServer;
use PIPE\Clases\Conectores\PostgreSQL;

class Conexion
{
    /**
     * Instancia de PDO.
     *
     * @var \PDO
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
     * @throws PIPE\Clases\Excepciones\ORM|PIPE\Clases\Excepciones\SQL
     */
    private function _conectar()
    {
        if ($this->_validarControlador(Configuracion::config('BD_CONTROLADOR'))) {
            switch (Configuracion::config('BD_CONTROLADOR')) {
            case 'mysql':
                $dsn = MySQL::obtenerDSN();
                break;
            case 'pgsql':
                $dsn = PostgreSQL::obtenerDSN();
                break;
            case 'sqlite':
                $dsn = SQLite::obtenerDSN();
                break;
            case 'sqlsrv':
                $dsn = SQLServer::obtenerDSN();
                break;
            }

            try {
                $pdo = new PDO(
                    $dsn, 
                    Configuracion::config('BD_USUARIO') ?? null,
                    Configuracion::config('BD_CONTRASENA') ?? null,
                    Configuracion::config('OPCIONES') ?? []
                );

                if (Configuracion::config('COMANDO_INICIAL')) {
                    $pdo->exec(Configuracion::config('COMANDO_INICIAL'));
                }

                self::$conexion = $pdo;
            } catch(PDOException $e) {
                Error::mostrar($e->getMessage(), true);
            }
        } else {
            Error::mostrar(
                'BD_CONTROLADOR '.Configuracion::config('BD_CONTROLADOR')
                .' '.Mensaje::$mensajes['CONTROLADOR_DESCONOCIDO']
            );
        }
    }

    /**
     * Valida que se ingrese un controlador correcto.
     *
     * @param string $controlador controlador
     * 
     * @return boolean
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
