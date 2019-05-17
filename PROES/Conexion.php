<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 16-05-2019
 * Versión: 1.1.0
 * Sitio web: https://pipe.proes.co
 *
 * Copyright (C) 2018 - 2019 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>
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
   
 * Copyright (C) 2018 - 2019 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>

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
	namespace PROES;
	class Conexion{
		public static $cnx=null;
		public function __construct(){
			Conexion::$cnx=$this->conexion();
		}
		private function conexion(){
			try{
				if(defined('BD_CONTROLADOR') and defined('BD_HOST') and defined('BD_PUERTO') and defined('BD_USUARIO') and defined('BD_CONTRASENA') and defined('BD_BASEDATOS')){
					if(!empty(BD_HOST)) $BD_HOST='host='.BD_HOST.';';
					if(empty(BD_HOST)) $BD_HOST='';
					if(!empty(BD_PUERTO)) $BD_PUERTO='port='.BD_PUERTO.';';
					if(empty(BD_PUERTO)) $BD_PUERTO='';
					if(!empty(BD_BASEDATOS)) $BD_BASEDATOS='dbname='.BD_BASEDATOS.';';
					if(empty(BD_BASEDATOS)) $BD_BASEDATOS='';
					if(BD_CONTROLADOR=='mysql' or BD_CONTROLADOR=='pgsql'  or BD_CONTROLADOR=='sqlite' or BD_CONTROLADOR=='oci' or BD_CONTROLADOR=='sqlsrv'){
						if(BD_CONTROLADOR=='sqlite') $BD_BASEDATOS=substr(substr($BD_BASEDATOS,7),0,-1);
						if(BD_CONTROLADOR=='sqlsrv'){
							$BD_HOST='server='.BD_HOST.';';
							$BD_BASEDATOS='database='.BD_BASEDATOS.';';
						}
						return new \PDO(BD_CONTROLADOR.':'.$BD_HOST.$BD_PUERTO.$BD_BASEDATOS,BD_USUARIO,BD_CONTRASENA);
					}
					else{
						exit('BD_CONTROLADOR <b>'.BD_CONTROLADOR.'</b> desconocido.<br><br>Controladores admitidos: mysql, pgsql, sqlite, oci, sqlsrv.');
					}
				}
				else{
					exit('Las siguientes constantes deben estar definidas en el archivo <b>PIPE_CONEXION_BD.php</b><br><br>BD_CONTROLADOR<br>BD_HOST<br>BD_PUERTO<br>BD_USUARIO<br>BD_CONTRASENA<br>BD_BASEDATOS');
				}
			}
			catch(\PDOException $e){
				exit($e->getMessage());
			}
		}
	}
	new Conexion();