<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 22-03-2020
 * Versión: 3.0.0
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
class Modelo extends ConstructorConsulta{
	/*
     * Crea un nuevo registro en la base de datos.
     *
     * @retorno object|array
     */
	public static function crear(){
		$clase=Modelo::obtenerClaseLlamada(get_called_class());
		$atributosClase=Modelo::obtenerAtributosClase($clase);
		$pipe=Modelo::tabla($atributosClase['tabla']);
		$pipe->todo();
		$registros=func_get_args();
		$inserciones=null;
		foreach($registros as $registro){
			$id=$pipe->insertarObtenerId($registro);
			$inserciones[]=clone $pipe->encontrar($id);
		}
		if(isset($inserciones)) $inserciones=count($inserciones)==1 ? $inserciones[0] : $inserciones;
		return $inserciones;
	}
	/*
     * Edita un registro en la base de datos.
     *
     * @parametro array|int|string $ids
     * @parametro array $valores
     * @retorno object|array
     */
	public static function editar($ids=[],$valores=[]){
		$clase=Modelo::obtenerClaseLlamada(get_called_class());
		$atributosClase=Modelo::obtenerAtributosClase($clase);
		$pipe=Modelo::tabla($atributosClase['tabla']);
		$llavePrimaria=$atributosClase['llavePrimaria'];
		if(is_array($ids) && !empty($ids)){
			foreach($ids as $id){
				$objeto=$pipe->donde($llavePrimaria.'=?',[$id]);
				if($objeto->existe()){
					if(is_array($valores) && !empty($valores)) $objeto->actualizar($valores);
					$actualizaciones[]=clone $pipe->encontrar($id);
				}
				else{
					$actualizaciones[]=null;
				}
			}
		}
		else{
			if(is_array($ids)) return null;
			$objeto=$pipe->donde($llavePrimaria.'=?',[$ids]);
			$actualizaciones=null;
			if($objeto->existe()){
				if(is_array($valores) && !empty($valores)) $objeto->actualizar($valores);
				$actualizaciones=$pipe->encontrar($ids);
			}
		}
		return $actualizaciones;
	}
	/*
     * Destruye un registro en la base de datos.
     *
     * @parametro array|int|string $ids
     * @retorno object|array
     */
	public static function destruir($ids=[]){
		$clase=Modelo::obtenerClaseLlamada(get_called_class());
		$atributosClase=Modelo::obtenerAtributosClase($clase);
		$pipe=Modelo::tabla($atributosClase['tabla']);
		if(is_array($ids) && !empty($ids)){
			foreach($ids as $id){
				$objeto=$pipe->encontrar($id);
				$eliminaciones[]=$objeto ? clone $objeto : $objeto;
				$pipe->eliminar();
			}
		}
		else{
			if(is_array($ids)) return null;
			$objeto=$pipe->encontrar($ids);
			$eliminaciones=$objeto;
			$pipe->eliminar();
		}
		return $eliminaciones;
	}
}