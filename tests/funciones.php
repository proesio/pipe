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

use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;

$tiempoInicio = microtimeFloat();

/**
 * Obtiene la marca de tiempo en microsegundos con decimales.
 * 
 * @return float
 */
function microtimeFloat()
{
    list($useg, $seg) = explode(' ', microtime());
    return ((float) $useg + (float) $seg);
}

/**
 * Obtiene la marca de tiempo empleada en la ejecución.
 * 
 * @return string
 */
function obtenerTiempoEmpleado()
{
    $tiempoFin = microtimeFloat();
    global $tiempoInicio;

    return 'Tiempo empleado: '.($tiempoFin - $tiempoInicio);
}

/**
 * Debuguea un elemento sin detener la ejecución.
 * 
 * @return void
 */
function d()
{
    echo obtenerTiempoEmpleado();
    debuguear(...func_get_args());
}

/**
 * Debuguea un elemento deteniendo la ejecución.
 * 
 * @return void
 */
function dd()
{
    echo obtenerTiempoEmpleado();
    debuguear(...func_get_args());
    exit();
}

/**
 * Debuguea un elemento.
 * 
 * @return void
 */
function debuguear()
{
    $argumentos = func_get_args();

    foreach ($argumentos as $argumento) {
        echo "\n";
        var_dump($argumento);
        echo "\n";
    }
}

/**
 * Genera los registros de prueba.
 *
 * @param string $conexion conexion
 * @param string $tabla    tabla
 * @param int    $cantidad cantidad
 * 
 * @return void
 */
function generarRegistros($conexion, $tabla, $cantidad = 1)
{
    global $configGlobal;

    Configuracion::inicializar($configGlobal, $conexion);

    $pdo = PIPE::obtenerPDO();

    $dateTime = new DateTime(Configuracion::config('ZONA_HORARIA'));

    for ($i = 1; $i <= $cantidad; $i++) {
        $tiempo = $dateTime->format('Y-m-d H:i:s');

        switch ($tabla) {
        case 'telefonos':
            $campos = '(numero, creado_en, actualizado_en)';
            $valores = "(".mt_rand(1000000000, 9999999999).", '".$tiempo."', '".$tiempo."')";
            break;
        case 'usuarios':
            $campos = '(telefono_id, nombres, apellidos, creado_en, actualizado_en)';
            $valores = "($i, 'Nombre{$i}', 'Apellido{$i}', '{$tiempo}', '{$tiempo}')";
            break;
        case 'roles':
            $campos = '(nombre, creado_en, actualizado_en)';
            $valores = "('Rol{$i}', '{$tiempo}', '{$tiempo}')";
            break;
        case 'temas':
            $campos = '(usuario_id, titulo, descripcion, creado_en, actualizado_en)';
            $valores = "($i, 'Titulo{$i}', 'Descripcion{$i}', '{$tiempo}', '{$tiempo}')";
            break;
        case 'role_usuario':
            $campos = '(role_id, usuario_id)';
            $valores = "($i, $i)";
            break;
        case 'documentos':
            $campos = '(usuario_id, numero, creado_en, actualizado_en)';
            $valores = "($i, ".mt_rand(1000000000, 9999999999).", '{$tiempo}', '{$tiempo}')";
            break;
        }

        $pdo->exec('insert into '.$tabla.' '.$campos.' values '.$valores);
    } 
}

/**
 * Elimina todos los registros en las tablas y reinicia 
 * el contador auto incrementable.
 *
 * @param string $conexion conexion
 * 
 * @return void
 */
function vaciarTablas($conexion)
{
    global $configGlobal;

    Configuracion::inicializar($configGlobal, $conexion);

    $pdo = PIPE::obtenerPDO();

    switch (Configuracion::config('BD_CONTROLADOR')){
    case 'mysql':
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        $pdo->exec('truncate table documentos');
        $pdo->exec('truncate table role_usuario');
        $pdo->exec('truncate table temas');
        $pdo->exec('truncate table roles');
        $pdo->exec('truncate table usuarios');
        $pdo->exec('truncate table telefonos');
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
        break;
    case 'pgsql':
        $pdo->exec('ALTER TABLE documentos DISABLE TRIGGER ALL');
        $pdo->exec('truncate table documentos restart identity cascade');
        $pdo->exec('ALTER TABLE documentos ENABLE TRIGGER ALL');

        $pdo->exec('ALTER TABLE role_usuario DISABLE TRIGGER ALL');
        $pdo->exec('truncate table role_usuario');
        $pdo->exec('ALTER TABLE role_usuario ENABLE TRIGGER ALL');

        $pdo->exec('ALTER TABLE temas DISABLE TRIGGER ALL');
        $pdo->exec('truncate table temas restart identity cascade');
        $pdo->exec('ALTER TABLE temas ENABLE TRIGGER ALL');

        $pdo->exec('ALTER TABLE roles DISABLE TRIGGER ALL');
        $pdo->exec('truncate table roles restart identity cascade');
        $pdo->exec('ALTER TABLE roles ENABLE TRIGGER ALL');

        $pdo->exec('ALTER TABLE usuarios DISABLE TRIGGER ALL');
        $pdo->exec('truncate table usuarios restart identity cascade');
        $pdo->exec('ALTER TABLE usuarios ENABLE TRIGGER ALL');

        $pdo->exec('ALTER TABLE telefonos DISABLE TRIGGER ALL');
        $pdo->exec('truncate table telefonos restart identity cascade');
        $pdo->exec('ALTER TABLE telefonos ENABLE TRIGGER ALL');
        break;
    case 'sqlite':
        $pdo->exec('delete from documentos');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'documentos'");

        $pdo->exec('delete from role_usuario');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'role_usuario'");

        $pdo->exec('delete from temas');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'temas'");

        $pdo->exec('delete from roles');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'roles'");

        $pdo->exec('delete from usuarios');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'usuarios'");

        $pdo->exec('delete from telefonos');
        $pdo->exec("update sqlite_sequence set seq = 0 where name = 'telefonos'");
        break;
    case 'sqlsrv':
        $pdo->exec('delete from documentos');
        $pdo->exec('dbcc checkident(documentos, reseed, 0)');

        $pdo->exec('delete from role_usuario');

        $pdo->exec('delete from temas');
        $pdo->exec('dbcc checkident(temas, reseed, 0)');

        $pdo->exec('delete from roles');
        $pdo->exec('dbcc checkident(roles, reseed, 0)');

        $pdo->exec('delete from usuarios');
        $pdo->exec('dbcc checkident(usuarios, reseed, 0)');

        $pdo->exec('delete from telefonos');
        $pdo->exec('dbcc checkident(telefonos, reseed, 0)');
        break;
    }
}
