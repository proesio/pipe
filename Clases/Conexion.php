<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 13-05-2020
 * Versión: 4.2.0
 * Sitio web: https://proes.tk/pipe
 *
 * Copyright (C) 2018 - 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
   
 * Traducción al español de la licencia MIT
   
 * Copyright (C) 2018 - 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>

 * Se concede permiso por la presente, libre de cargos, a cualquier persona
 * que obtenga una copia de este software y de los archivos de documentación asociados 
 * (el "Software"), a utilizar el Software sin restricción, incluyendo sin limitación 
 * los derechos a usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar, 
 * y/o vender copias del Software, y a permitir a las personas a las que se les proporcione 
 * el Software a hacer lo mismo, sujeto a las siguientes condiciones:

 * El aviso de copyright anterior y este aviso de permiso se incluirán 
 * en todas las copias o partes sustanciales del Software.

 * EL SOFTWARE SE PROPORCIONA "COMO ESTÁ", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA,
 * INCLUYENDO PERO NO LIMITADO A GARANTÍAS DE COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO
 * PARTICULAR E INCUMPLIMIENTO. EN NINGÚN CASO LOS AUTORES O PROPIETARIOS DE LOS DERECHOS DE AUTOR
 * SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN
 * DE CONTRATO, AGRAVIO O CUALQUIER OTRO MOTIVO, DERIVADAS DE, FUERA DE O EN CONEXIÓN
 * CON EL SOFTWARE O SU USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.
 */
namespace PIPE\Clases;
class Conexion{
	/*
     * Instancia de PDO
     * @tipo \PDO
     */
	public static $cnx=null;
	/*
     * Crea una nueva instancia de la clase Conexion.
     *
     * @retorno void
     */
	public function __construct(){
		Conexion::$cnx=$this->conexion();
	}
	/*
     * Obtiene la conexión de la base de datos.
     *
     * @retorno \PDO
     */
	private function conexion(){
		try{
			$constantes=$this->obtenerConstantesConexion();
			if($this->validarControladorAdmitido($constantes['BD_CONTROLADOR'])){
				$dsn=$this->obtenerDSN($constantes);
				$cnx=new \PDO($dsn,$constantes['BD_USUARIO'] ?? '',$constantes['BD_CONTRASENA'] ?? '');
				if($constantes['BD_CODIFICACION']) $cnx->exec('set names '.$constantes['BD_CODIFICACION']);
				return $cnx;
			}
			else{
				exit('BD_CONTROLADOR <b>'.$constantes['BD_CONTROLADOR'].'</b>'.Mensaje::$mensajes['CONTROLADOR_DESCONOCIDO']);
			}
		}
		catch(\PDOException $e){
			exit($e->getMessage());
		}
	}
	/*
     * Obtiene las constantes necesarias para la conexión.
     *
     * @retorno array
     */
	private function obtenerConstantesConexion(){
		$constantes['BD_CONTROLADOR']=Configuracion::obtenerVariable('BD_CONTROLADOR');
		$constantes['BD_HOST']=Configuracion::obtenerVariable('BD_HOST');
		$constantes['BD_PUERTO']=Configuracion::obtenerVariable('BD_PUERTO');
		$constantes['BD_USUARIO']=Configuracion::obtenerVariable('BD_USUARIO');
		$constantes['BD_CONTRASENA']=Configuracion::obtenerVariable('BD_CONTRASENA');
		$constantes['BD_BASEDATOS']=Configuracion::obtenerVariable('BD_BASEDATOS');
		$constantes['BD_CODIFICACION']=Configuracion::obtenerVariable('BD_CODIFICACION');
		return $constantes;
	}
	/*
     * Valida que se ingrese un controlador correcto.
     *
     * @parametro string $controlador
     * @retorno boolean
     */
	private function validarControladorAdmitido($controlador){
		if($controlador=='mysql' || $controlador=='pgsql'  || $controlador=='sqlite' || $controlador=='sqlsrv') return true;
		return false;
	}
	/*
     * Obtiene la cadena DSN con los parámetros de conexión.
     *
     * @parametro array $constantes
     * @retorno string
     */
	private function obtenerDSN($constantes){
		$controlador=$constantes['BD_CONTROLADOR'];
		$host=$constantes['BD_HOST'];
		$puerto=$constantes['BD_PUERTO'];
		$basedatos=$constantes['BD_BASEDATOS'];
		if($controlador=='mysql' || $controlador=='pgsql'){
			$host=$host ? 'host='.$host.';' : '';
			$puerto=$puerto ? 'port='.$puerto.';' : '';
			$basedatos=$basedatos ? 'dbname='.$basedatos.';' : '';
			$dsn=$controlador.':'.$host.$puerto.$basedatos;
		}
		else if($controlador=='sqlite'){
			$dsn=$controlador.':'.$basedatos;
		}
		else if($controlador=='sqlsrv'){
			if($host && $puerto)
				$host='server='.$host.','.$puerto.';';
			else if($host)
				$host='server='.$host.';';
			else
				$host='';
			$basedatos=$basedatos ? 'database='.$basedatos.';' : '';
			$dsn=$controlador.':'.$host.$basedatos;
		}
		return $dsn;
	}
}
new Conexion();