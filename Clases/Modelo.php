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
abstract class Modelo{
	//Inicio métodos públicos.
	//Inicio palabras reservadas representadas en métodos para construir una consulta SQL.
	/*
     * Establece un alias al nombre de la tabla.
     *
     * @parametro string $alias
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function alias($alias){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->alias(...func_get_args());
	}
	/*
     * Obtiene todos los datos de la tabla seleccionada.
     *
     * @parametro array|string $campos
     * @parametro string $tipo
     * @retorno array|json|string
     */
	public static function todo($campos=[],$tipo=ConstructorConsulta::OBJETO){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->todo(...func_get_args());
	}
	/*
     * Establece los campos que serán seleccionados.
     *
     * @parametro array|mixto $campos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function seleccionar($campos=['*']){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->seleccionar(...func_get_args());
	}
	/*
     * Elimina duplicados del conjunto de resultados.
     *
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function distinto(){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->distinto(...func_get_args());
	}
	/*
     * Combina registros de una o más tablas relacionadas.
     *
     * @parametro string $tablaUnion
     * @parametro string $llaveForanea
     * @parametro string $union
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function unir($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->unir(...func_get_args());
	}
	/*
     * Combina registros de una o más tablas relacionadas obteniendo todos los registros de la tabla de la derecha.
     *
     * @parametro string $tablaUnion
     * @parametro string $llaveForanea
     * @parametro string $union
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function unirDerecha($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->unirDerecha(...func_get_args());
	}
	/*
     * Combina registros de una o más tablas relacionadas obteniendo todos los registros de la tabla de la izquierda.
     *
     * @parametro string $tablaUnion
     * @parametro string $llaveForanea
     * @parametro string $union
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function unirIzquierda($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->unirIzquierda(...func_get_args());
	}
	/*
     * Establece una condición en la consulta SQL.
     *
     * @parametro string $condicion
     * @parametro array $datos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function donde($condicion,$datos=[]){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->donde(...func_get_args());
	}
	/*
     * Agrupa registros que tienen los mismos valores.
     *
     * @parametro string|array $grupos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function agruparPor($grupos){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->agruparPor(...func_get_args());
	}
	/*
     * Establece una condición a una función de agregación.
     *
     * @parametro string $condicion
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function teniendo($condicion){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->teniendo(...func_get_args());
	}
	/*
     * Ordena el resultado de la consulta SQL.
     *
     * @parametro string|array $ordenar
     * @parametro string $tipo
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function ordenarPor($ordenar,$tipo='asc'){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->ordenarPor(...func_get_args());
	}
	/*
     * Limita el número de registros retornados en la consulta SQL.
     *
     * @parametro int $inicio
     * @parametro int $final
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function limite($inicio,$cantidad=''){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->limite(...func_get_args());
	}
	/*
     * Obtiene una cantidad específca de registros retornados.
     *
     * @parametro int $inicio
     * @parametro int|string $cantidad
     * @retorno array|json
     */
	public static function tomar($inicio,$cantidad='',$tipo=ConstructorConsulta::OBJETO){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->tomar(...func_get_args());
	}
	//Fin palabras reservadas representadas en métodos para construir una consulta SQL.
	//Inicio consultas básicas por medio de métodos.
	/*
     * Obtiene los primeros registros retornados en la consulta SQL.
     *
     * @parametro int|string $limite
     * @parametro string $tipo
     * @retorno array|json
     */
	public static function primero($limite=1,$tipo=ConstructorConsulta::OBJETO){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->primero(...func_get_args());
	}
	/*
     * Obtiene los últimos registros retornados en la consulta SQL.
     *
     * @parametro string|int $llavePrimaria
     * @parametro int|string $limite
     * @parametro string $tipo
     * @retorno array|json
     */
	public static function ultimo($llavePrimaria='id',$limite=1,$tipo=ConstructorConsulta::OBJETO){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->ultimo(...func_get_args());
	}
	/*
     * Obtiene la cantidad general o específica de registros retornados.
     *
     * @parametro string $campo
     * @retorno int
     */
	public static function contar($campo='*'){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->contar(...func_get_args());
	}
	/*
     * Obtiene el valor máximo del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
	public static function maximo($campo){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->maximo(...func_get_args());
	}
	/*
     * Obtiene el valor mímino del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
	public static function minimo($campo){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->minimo(...func_get_args());
	}
	/*
     * Obtiene el valor promedio del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
	public static function promedio($campo){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->promedio(...func_get_args());
	}
	/*
     * Obtiene la suma del campo especificado.
     *
     * @parametro string $campo
     * @retorno int
     */
	public static function suma($campo){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->suma(...func_get_args());
	}
	/*
     * Verifica que la consulta SQL ha retornado un resultado.
     *
     * @retorno boolean
     */
	public static function existe(){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->existe(...func_get_args());
	}
	/*
     * Verifica que la consulta SQL no ha retornado un resultado.
     *
     * @retorno boolean
     */
	public static function noExiste(){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->noExiste(...func_get_args());
	}
	/*
     * Incrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $incremento
     * @retorno int
     */
	public static function incrementar($campo,$incremento=1){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->incrementar(...func_get_args());
	}
	/*
     * Decrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $decremento
     * @retorno int
     */
	public static function decrementar($campo,$decremento=1){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->decrementar(...func_get_args());
	}
	/*
     * Obtiene una instancia del Modelo con los datos asociados a la llave primaria.
     *
     * @parametro array|int|string $valor
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta|array|null
     */
	public static function encontrar($valor=[],$llavePrimaria='id'){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->encontrar(...func_get_args());
	}
	//Fin consultas básicas por medio de métodos.
	//Inicio instrucciones insertar, actualizar, eliminar y vaciar.
	/*
     * Inserta un nuevo registro en la base de datos.
     *
     * @parametro array $valores
     * @retorno int
     */
	public function insertar($valores=[]){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		foreach($this as $clave=>$valor){
			if(!property_exists($pipe,$clave)) $pipe->$clave=$valor;
		}
		return $pipe->insertar(...func_get_args());
	}
	/*
     * Inserta un nuevo registro en la base de datos y obtiene el último id generado.
     *
     * @parametro array $valores
     * @retorno int
     */
	public static function insertarObtenerId($valores){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->insertarObtenerId(...func_get_args());
	}
	/*
     * Actualiza un registro en la base de datos.
     *
     * @parametro array $valores
     * @retorno int
     */
	public static function actualizar($valores=[]){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->actualizar(...func_get_args());
	}
	/*
     * Actualiza o inserta un nuevo registro en la base de datos.
     *
     * @parametro array $valores
     * @parametro array $inserciones
     * @retorno int|boolean
     */
	public function actualizarOInsertar($valores,$inserciones=[]){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->actualizarOInsertar(...func_get_args());
	}
	/*
     * Elimina un registro en la base de datos.
     *
     * @retorno int
     */
	public static function eliminar(){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->eliminar(...func_get_args());
	}
	/*
     * Elimina todos los registros en la tabla y reinicia el contador autoincrementable.
     *
     * @parametro string $sentencia
     * @retorno int
     */
	public static function vaciar($sentencia=''){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		return $pipe->vaciar(...func_get_args());
	}
	//Fin instrucciones insertar, actualizar, eliminar y vaciar.
	//Inicio instrucciones crear, editar y destruir.
	/*
     * Crea un nuevo registro en la base de datos.
     *
     * @retorno object|array
     */
	public static function crear(){
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
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
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		if(is_array($ids) && !empty($ids)){
			foreach($ids as $id){
				$objeto=$pipe->donde($atributosClase['llavePrimaria'].'=?',[$id]);
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
			$objeto=$pipe->donde($atributosClase['llavePrimaria'].'=?',[$ids]);
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
		$atributosClase=self::obtenerAtributosClase(get_called_class());
		$pipe=new ConstructorConsulta($atributosClase);
		if(is_array($ids) && !empty($ids)){
			foreach($ids as $id){
				$objeto=$pipe->encontrar($id);
				$eliminaciones[]=$objeto ? clone $objeto : $objeto;
				if($objeto) $objeto->eliminar();
			}
		}
		else{
			if(is_array($ids)) return null;
			$objeto=$pipe->encontrar($ids);
			$eliminaciones=$objeto;
			if($objeto) $objeto->eliminar();
		}
		return $eliminaciones;
	}
	//Fin instrucciones crear, editar y destruir.
	/*
     * Obtiene los atributos de la clase (modelo) instanciada.
     *
     * @parametro string $claseLlamada
     * @retorno array
     */
	public static function obtenerAtributosClase($claseLlamada){		
		$modelo=self::obtenerClaseLlamada($claseLlamada);
		$atributosClase=get_class_vars($claseLlamada);
		$atributosClase['clase']=$modelo;
		$atributosClase['tabla']=$atributosClase['tabla'] ?? self::convertirModeloTabla($modelo);
		$atributosClase['llavePrimaria']=$atributosClase['llavePrimaria'] ?? 'id';
		$atributosClase['registroTiempo']=$atributosClase['registroTiempo'] ?? true;
		$atributosClase['creadoEn']=$atributosClase['creadoEn'] ?? 'creado_en';
		$atributosClase['actualizadoEn']=$atributosClase['actualizadoEn'] ?? 'actualizado_en';
		$atributosClase['tieneUno']=$atributosClase['tieneUno'] ?? [];
		$atributosClase['tieneMuchos']=$atributosClase['tieneMuchos'] ?? [];
		$atributosClase['perteneceAUno']=$atributosClase['perteneceAUno'] ?? [];
		$atributosClase['perteneceAMuchos']=$atributosClase['perteneceAMuchos'] ?? [];
		$atributosClase['insertables']=$atributosClase['insertables'] ?? [];
		$atributosClase['actualizables']=$atributosClase['actualizables'] ?? [];
		$atributosClase['visibles']=$atributosClase['visibles'] ?? [];
		$atributosClase['ocultos']=$atributosClase['ocultos'] ?? [];
		return $atributosClase;
	}
	/*
     * Obtiene el nombre de la clase instanciada que ha hecho la invocación.
     *
     * @parametro string $nombreCompleto
     * @retorno string
     */
	public static function obtenerClaseLlamada($nombreCompleto){
		$partesClase=explode('\\',$nombreCompleto);
		return $partesClase[count($partesClase)-1];
	}
	/*
     * Convierte el nombre del modelo (clase) en el nombre de la tabla de la base de datos.
     *
     * @parametro string $modelo
     * @retorno string
     */
	public static function convertirModeloTabla($modelo){
		$alfabeto=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		$letras=str_split($modelo);
		foreach($alfabeto as $alfa){
			foreach($letras as $letra){
				if($letra==$alfa){
					$modelo=str_replace($letra,'_'.$letra,$modelo);
					break;					
				}
			}
		}
		$tabla=strtolower(substr($modelo,1).'s');
		return $tabla;
	}
	//Fin métodos públicos.
}