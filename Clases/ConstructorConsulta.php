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
class ConstructorConsulta{
	/*
     * Palabra reservada distinct.
     * @tipo string
     */
	private $_distinto='';
	/*
     * Campos seleccionados en la consulta SQL.
     * @tipo string
     */
	private $_campos='';
	/*
     * Nombre de la tabla en la base de datos.
     * @tipo string
     */
	private $_tabla='';
	/*
     * Uniones con la cláusula inner join.
     * @tipo string
     */
	private $_unir='';
	/*
     * Uniones con la cláusula right join.
     * @tipo string
     */
	private $_unirDerecha='';
	/*
     * Uniones con la cláusula left join.
     * @tipo string
     */
	private $_unirIzquierda='';
	/*
     * Condiciones con la cláusula where.
     * @tipo string
     */
	private $_condiciones='';
	/*
     * Agrupaciones con la cláusula group by.
     * @tipo string
     */
	private $_agrupar='';
	/*
     * Condiciones con la cláusula having.
     * @tipo string
     */
	private $_teniendo='';
	/*
     * Ordenamiento de registros con la cláusula order by.
     * @tipo string
     */
	private $_ordenar='';
	/*
     * Limitación de registros con la cláusula limit.
     * @tipo string
     */
	private $_limite='';
	/*
     * Valores de la consulta SQL para ejecutar consultas preparadas.
     * @tipo array
     */
	private $_datos=[];
	/*
     * Datos relacionados con el modelo(s) establecido.
     * @tipo array
     */
	private $_datosModeloRelacion=[];
	/*
     * Nombre de la tabla en representación de un modelo.
     * @tipo string
     */
	protected $tabla='';
	/*
     * Llave primaria de la tabla en representación de un modelo.
     * @tipo string
     */
	protected $llavePrimaria='id';
	/*
     * Indica si se almacena el registro del tiempo en los campos creado_en y actualizado_en.
     * @tipo boolean
     */
	protected $registroTiempo=true;
	/*
     * Indica que el modelo tiene una relación de Uno a Uno.
     * @tipo array
     */
	protected $tieneUno=[];
	/*
     * Indica que el modelo tiene una relación de Uno a Muchos.
     * @tipo array
     */
	protected $tieneMuchos=[];
	/*
     * Indica la relación inversa de las relaciones Uno a Uno y Uno a Muchos.
     * @tipo array
     */
	protected $perteneceAUno=[];
	/*
     * Indica que el modelo tiene una relación de Muchos a Muchos.
     * @tipo array
     */
	protected $perteneceAMuchos=[];
	/*
     * Indica el retorno de resultados de una consulta SQL como un objeto.
     * @tipo string
     */
	const OBJETO='objeto';
	/*
     * Indica el retorno de resultados de una consulta SQL como un arreglo.
     * @tipo string
     */
	const ARREGLO='arreglo';
	/*
     * Indica el retorno de resultados de una consulta SQL como una cadena de json.
     * @tipo string
     */
	const JSON='json';
	/*
     * Crea una nueva instancia de la clase ConstructorConsulta.
     *
     * @parametro array $datosTabla
     * @retorno void
     */
	public function __construct($datosTabla){
		$this->_distinto=$datosTabla['distinto'];
		$this->_campos=$datosTabla['campos'];
		$this->_tabla=$datosTabla['tabla'];
		$this->_unir=$datosTabla['unir'];
		$this->_unirDerecha=$datosTabla['unirDerecha'];
		$this->_unirIzquierda=$datosTabla['unirIzquierda'];
		$this->_condiciones=$datosTabla['condiciones'];
		$this->_agrupar=$datosTabla['agrupar'];
		$this->_teniendo=$datosTabla['teniendo'];
		$this->_ordenar=$datosTabla['ordenar'];
		$this->_limite=$datosTabla['limite'];
		if(array_key_exists('datos',$datosTabla)) $this->_datos=$datosTabla['datos'];
	}
	//Inicio métodos públicos.
	//Inicio palabras reservadas representadas en métodos para construir una consulta SQL.
	/*
     * Establece el nombre de la tabla en el Constructor de Consultas.
     *
     * @parametro string $tabla
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function tabla($tabla){
		$datosTabla=array(
			'distinto'=>'',
			'campos'=>'*',
			'tabla'=>$tabla,
			'unir'=>'',
			'unirDerecha'=>'',
			'unirIzquierda'=>'',
			'condiciones'=>'',
			'agrupar'=>'',
			'teniendo'=>'',
			'ordenar'=>'',
			'limite'=>''
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Establece un alias al nombre de la tabla.
     *
     * @parametro string $alias
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function alias($alias){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$tabla=$pipe->_tabla.' as '.$alias;
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Obtiene todos los datos de la tabla seleccionada.
     *
     * @parametro array|string $campos
     * @parametro string $tipo
     * @retorno array|json
     */
	public function todo($campos=[],$tipo=ConstructorConsulta::OBJETO){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(is_array($campos) and !empty($campos)){
			return $pipe->seleccionar($campos)->obtener($tipo);
		}
		else{
			if($campos==ConstructorConsulta::OBJETO or $campos==ConstructorConsulta::ARREGLO or $campos==ConstructorConsulta::JSON) $tipo=$campos;
			return $pipe->obtenerDatosConsultaSQL($tipo);
		}
	}
	/*
     * Establece los campos que serán seleccionados.
     *
     * @parametro array|mixto $campos
     * @parametro string $tipo
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function seleccionar($campos=['*']){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$campos=is_array($campos) ? $campos : func_get_args();
		$_campos='';
		foreach($campos as $campo){
			$_campos=$_campos.$campo.',';
		}
		$_campos=$pipe->traducirConsultaSQL(substr($_campos,0,-1));
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Elimina duplicados del conjunto de resultados.
     *
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function distinto(){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$datosTabla=array(
			'distinto'=>'distinct',
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
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
	public function unir($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($llavePrimaria==''){
			$llavePrimaria=$union;
			$union='=';
		}		
		$union=$pipe->_unir.' inner join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$union,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
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
	public function unirDerecha($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($llavePrimaria==''){
			$llavePrimaria=$union;
			$union='=';
		}
		$union=$pipe->_unir.' right join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$union,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
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
	public function unirIzquierda($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($llavePrimaria==''){
			$llavePrimaria=$union;
			$union='=';
		}
		$union=$pipe->_unir.' left join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$union,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Establece una condición en la consulta SQL.
     *
     * @parametro string $condicion
     * @parametro array $datos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function donde($condicion,$datos=[]){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$registroTiempo=$atributosClase['registroTiempo'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$condicion=$pipe->traducirConsultaSQL('where '.$condicion);
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$condicion,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite,
			'datos'=>$datos
		);
		if($clase=='ConstructorConsulta'){
			return new ConstructorConsulta($datosTabla);
		}
		else{
			$pipe=new ConstructorConsulta($datosTabla);
			$pipe->registroTiempo=$registroTiempo;
			return $pipe;
		}	
	}
	/*
     * Agrupa registros que tienen los mismos valores.
     *
     * @parametro string|array $grupos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function agruparPor($grupos){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(is_string($grupos)){
			$grupo=$pipe->traducirConsultaSQL('group by '.$grupos);
		}
		else if(is_array($grupos)){
			$agrupaciones='';
			foreach($grupos as $grupo){
				$agrupaciones=$agrupaciones.$grupo.',';
			}
			$agrupaciones=substr($agrupaciones,0,-1);
			$grupo=$pipe->traducirConsultaSQL('group by '.$agrupaciones);
		}
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$grupo,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Establece una condición a una función de agregación.
     *
     * @parametro string $condicion
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function teniendo($condicion){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$condicion=$pipe->traducirConsultaSQL('having '.$condicion);
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$condicion,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Ordena el resultado de la consulta SQL.
     *
     * @parametro string|array $ordenar
     * @parametro string $tipo
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function ordenarPor($ordenar,$tipo='asc'){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(is_string($ordenar)){
			$ordenar=$pipe->traducirConsultaSQL('order by '.$ordenar.' '.$tipo);
		}
		else if(is_array($ordenar)){
			$ordenaciones='';
			foreach($ordenar as $orden){
				$ordenaciones=$ordenaciones.$orden.',';
			}
			$ordenaciones=substr($ordenaciones,0,-1);
			$ordenar=$pipe->traducirConsultaSQL('order by '.$ordenaciones.' '.$tipo);
		}
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$ordenar,
			'limite'=>$pipe->_limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	/*
     * Limita el número de registros retornados en la consulta SQL.
     *
     * @parametro int $inicio
     * @parametro int $final
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function limite($inicio,$final=''){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$limite='limit '.$inicio;
		if($final!='') $limite='limit '.$inicio.','.$final;		
		$datosTabla=array(
			'distinto'=>$pipe->_distinto,
			'campos'=>$pipe->_campos,
			'tabla'=>$pipe->_tabla,
			'unir'=>$pipe->_unir,
			'unirDerecha'=>$pipe->_unirDerecha,
			'unirIzquierda'=>$pipe->_unirIzquierda,
			'condiciones'=>$pipe->_condiciones,
			'agrupar'=>$pipe->_agrupar,
			'teniendo'=>$pipe->_teniendo,
			'ordenar'=>$pipe->_ordenar,
			'limite'=>$limite
		);
		return new ConstructorConsulta($datosTabla);
	}
	//Fin palabras reservadas representadas en métodos para construir una consulta SQL.
	//Inicio consultas básicas por medio de métodos().
	/*
     * Obtiene los primeros registros retornados en la consulta SQL.
     *
     * @parametro int|string $limite
     * @parametro string $tipo
     * @retorno array
     */
	public function primero($limite=1,$tipo=ConstructorConsulta::OBJETO){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($limite==ConstructorConsulta::OBJETO or $limite==ConstructorConsulta::ARREGLO or $limite==ConstructorConsulta::JSON){
			$tipo=$limite;
			$limite=1;
		}
		return $pipe->limite($limite)->obtener($tipo);
	}
	/*
     * Obtiene los últimos registros retornados en la consulta SQL.
     *
     * @parametro string|int $llavePrimaria
     * @parametro int|string $limite
     * @parametro string $tipo
     * @retorno array
     */
	public function ultimo($llavePrimaria='id',$limite=1,$tipo=ConstructorConsulta::OBJETO){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			if($llavePrimaria==ConstructorConsulta::OBJETO or $llavePrimaria==ConstructorConsulta::ARREGLO or $llavePrimaria==ConstructorConsulta::JSON){
				$tipo=$llavePrimaria;
				$llavePrimaria='id';
			}
			else if(is_numeric($llavePrimaria)){
				if($limite==ConstructorConsulta::OBJETO or $limite==ConstructorConsulta::ARREGLO or $limite==ConstructorConsulta::JSON) $tipo=$limite;
				$limite=$llavePrimaria;
				$llavePrimaria='id';
			}
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$llavePrimaria=$atributosClase['llavePrimaria'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($limite==ConstructorConsulta::OBJETO or $limite==ConstructorConsulta::ARREGLO or $limite==ConstructorConsulta::JSON){
			$tipo=$limite;
			$limite=1;
		}
		return $pipe->ordenarPor($llavePrimaria,'desc')->limite($limite)->obtener($tipo);
	}
	/*
     * Obtiene la cantidad general o específica de registros retornados.
     *
     * @parametro string $campo
     * @retorno int
     */
	public function contar($campo='*'){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$conteo=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'CONTEO' : 'conteo';
		return intval($pipe->procesarConsultaSQL('select count('.$campo.') as conteo from '.$pipe->_tabla.' '.$pipe->_condiciones,$pipe->_datos)[0]->$conteo);
	}
	/*
     * Obtiene el valor máximo del campo especificado.
     *
     * @parametro string $campo
     * @retorno string
     */
	public function maximo($campo){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$maximo=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'MAXIMO' : 'maximo';
		return $pipe->procesarConsultaSQL('select max('.$campo.') as maximo from '.$pipe->_tabla.' '.$pipe->_condiciones,$pipe->_datos)[0]->$maximo;
	}
	/*
     * Obtiene el valor mímino del campo especificado.
     *
     * @parametro string $campo
     * @retorno string
     */
	public function minimo($campo){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$minimo=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'MINIMO' : 'minimo';
		return $pipe->procesarConsultaSQL('select min('.$campo.') as minimo from '.$pipe->_tabla.' '.$pipe->_condiciones,$pipe->_datos)[0]->$minimo;
	}
	/*
     * Obtiene el valor promedio del campo especificado.
     *
     * @parametro string $campo
     * @retorno string
     */
	public function promedio($campo){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$promedio=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'PROMEDIO' : 'promedio';
		return $pipe->procesarConsultaSQL('select avg('.$campo.') as promedio from '.$pipe->_tabla.' '.$pipe->_condiciones,$pipe->_datos)[0]->$promedio;
	}
	/*
     * Obtiene la suma del campo especificado.
     *
     * @parametro string $campo
     * @retorno string
     */
	public function suma($campo){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		$suma=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'SUMA' : 'suma';
		return $pipe->procesarConsultaSQL('select sum('.$campo.') as suma from '.$pipe->_tabla.' '.$pipe->_condiciones,$pipe->_datos)[0]->$suma;
	}
	/*
     * Verifica que la consulta SQL ha retornado un resultado.
     *
     * @retorno boolean
     */
	public function existe(){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if($pipe->obtenerDatosConsultaSQL()) return true;
		return false;
	}
	/*
     * Verifica que la consulta SQL no ha retornado un resultado.
     *
     * @retorno boolean
     */
	public function noExiste(){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(!$pipe->obtenerDatosConsultaSQL()) return true;
		return false;
	}
	/*
     * Incrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $incremento
     * @retorno int
     */
	public function incrementar($campo,$incremento=1){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		return $pipe->procesarConsultaSQL('update '.$pipe->_tabla.' set '.$campo.'='.$campo.'+'.$incremento.' '.$pipe->_condiciones,$pipe->_datos);
	}
	/*
     * Decrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $decremento
     * @retorno int
     */
	public function decrementar($campo,$decremento=1){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		return $pipe->procesarConsultaSQL('update '.$pipe->_tabla.' set '.$campo.'='.$campo.'-'.$decremento.' '.$pipe->_condiciones,$pipe->_datos);
	}
	//Fin consultas básicas por medio de métodos().
	/*
     * Obtiene el resultado de una consulta SQL.
     *
     * @parametro string $tipo
     * @retorno array
     */
	public function obtener($tipo=ConstructorConsulta::OBJETO){
		return $this->obtenerDatosConsultaSQL($tipo);
	}
	/*
     * Obtiene los datos relacionados a un modelo.
     *
     * @parametro string $tipo
     * @retorno object|array|json
     */
	public function relaciones($tipo=ConstructorConsulta::OBJETO){
		switch($tipo){
			case ConstructorConsulta::OBJETO:
				return json_decode(json_encode($this->_datosModeloRelacion));
			break;
			case ConstructorConsulta::ARREGLO:
				return json_decode(json_encode($this->_datosModeloRelacion),true);
			break;
			case ConstructorConsulta::JSON:
				return json_encode($this->_datosModeloRelacion);
			break;
			default:
				exit(Mensaje::$mensajes['TIPO_DATO_DESCONOCIDO'].'<b>'.$tipo.'</b>');
			break;
		}
	}
	//Inicio instrucciones insertar, actualizar, eliminar y vaciar.
	/*
     * Instancia un modelo.
     *
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public static function instanciar(){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase!='ConstructorConsulta' and $clase!='PIPE'){
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$llavePrimaria=$atributosClase['llavePrimaria'];
			$registroTiempo=$atributosClase['registroTiempo'];
			$pipe=ConstructorConsulta::tabla($tabla);
			$pipe->tabla=$tabla;
			$pipe->llavePrimaria=$llavePrimaria;
			$pipe->registroTiempo=$registroTiempo;
				return $pipe;
		}
		else{
			exit(Mensaje::$mensajes['INSTANCIAR_NO_PERMITIDO']);
		}
	}
	/*
     * Inserta un nuevo registro en la base de datos.
     *
     * @parametro array $valores
     * @retorno int
     */
	public function insertar($valores=[]){
		$creado_en=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'CREADO_EN' : 'creado_en';
		$actualizado_en=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'ACTUALIZADO_EN' : 'actualizado_en';
		$camposTabla=$this->obtenerCamposTabla();
		$cantCamposTabla=count($camposTabla);
		if(is_array($valores) and !empty($valores)){
			$j=0;
			for($i=0; $i<$cantCamposTabla; $i++){
				if($camposTabla[$i]==$creado_en or $camposTabla[$i]==$actualizado_en) $j++;
			}
			$atributo_tiempo='';
			$valor_tiempo='';
			if($this->registroTiempo==true and $j==2){
				$atributo_tiempo=','.$creado_en.','.$actualizado_en;
				$valor_tiempo=','."'".$this->obtenerFechaHoraActual()."'".','."'".$this->obtenerFechaHoraActual()."'";
			}
			$registros=func_get_args();
			if(Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' and count($registros)>1){
				$valores=[];
				$inserciones=0;
				foreach($registros as $registro){
					$campos='';
					$parametros='';
					$i=0;
					foreach($registro as $campo=>$valor){
						$campos=$campos.$campo.',';
						if(!isset($valor)) $valor=null;
						if(is_string($valor) and strpos($valor,'.nextval')>-1===true){
							$parametros=$parametros.$valor.',';
						}
						else{
							$parametros=$parametros.'?,';
							$valores[$i]=$valor;
						}
						$i++;
					}
					$inserciones=$inserciones+$this->procesarConsultaSQL('insert into '.$this->_tabla.' ('.substr($campos,0,-1).$atributo_tiempo.') values ('.substr($parametros,0,-1).$valor_tiempo.')',array_values($valores));
				}
				return $inserciones;
			}
			else{
				$campos='';
				$parametros='';
				$valores=[];
				$i=0;
				$j=0;
				foreach($registros as $registro){
					$parametros=$parametros.'(';
					foreach($registro as $campo=>$valor){
						if($i==0) $campos=$campos.$campo.',';
						if(!isset($valor)) $valor=null;
						if(is_string($valor) and ($valor==='default' or strpos($valor,'.nextval')>-1===true)){
							$parametros=$parametros.$valor.',';
						}
						else{
							$parametros=$parametros.'?,';
							$valores[$j]=$valor;
						}
						$j++;
					}
					$i++;
					$parametros=substr($parametros,0,-1).$valor_tiempo.'),';
				}
				$campos=substr($campos,0,-1).$atributo_tiempo;
				$parametros=substr($parametros,0,-1);
				$valores=array_values($valores);
					return $this->procesarConsultaSQL('insert into '.$this->_tabla.' ('.$campos.') values '.$parametros,$valores);
			}
		}
		else{
			if($this->registroTiempo==true){
				$this->$creado_en=$this->obtenerFechaHoraActual();
				$this->$actualizado_en=$this->obtenerFechaHoraActual();
			}
			else{
				$this->$creado_en=null;
				$this->$actualizado_en=null;
			}
			$campos='';
			$parametros='';
			$valores=[];
			for($i=0; $i<$cantCamposTabla; $i++){
				$atributo=$camposTabla[$i];
				$campos=$campos.$atributo.',';
				if(is_string($this->$atributo) and ($this->$atributo==='default' or strpos($this->$atributo,'.nextval')>-1===true)){
					$parametros=$parametros.$this->$atributo.',';
				}
				else{
					$parametros=$parametros.'?,';
					$valores[$i]=$this->$atributo;
				}
			}
			$campos=substr($campos,0,-1);
			$parametros=substr($parametros,0,-1);
			$valores=array_values($valores);
				return $this->procesarConsultaSQL('insert into '.$this->_tabla.' ('.$campos.') values ('.$parametros.')',$valores);
		}
	}
	/*
     * Inserta un nuevo registro en la base de datos y obtiene el último id generado.
     *
     * @parametro array $valores
     * @retorno int
     */
	public function insertarObtenerId($valores){
		if(Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci') exit(Mensaje::$mensajes['INSERTAR_OBTENER_ID_NO_SOPORTADO']);
		$this->insertar($valores);
		return intval(Conexion::$cnx->lastInsertId());
	}
	/*
     * Obtiene una instancia del Constructor de Consultas con los datos asociados a la llave primaria.
     *
     * @parametro array|int|string $valor
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
	public function encontrar($valor=[],$llavePrimaria='id'){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$llavePrimaria=$atributosClase['llavePrimaria'];
			$registroTiempo=$atributosClase['registroTiempo'];
			$tieneUno=$atributosClase['tieneUno'];
			$tieneMuchos=$atributosClase['tieneMuchos'];
			$perteneceAUno=$atributosClase['perteneceAUno'];
			$perteneceAMuchos=$atributosClase['perteneceAMuchos'];
			$pipe=ConstructorConsulta::tabla($tabla);
			$pipe->tabla=$tabla;
			$pipe->llavePrimaria=$llavePrimaria;
			$pipe->registroTiempo=$registroTiempo;
			$pipe->tieneUno=$tieneUno;
			$pipe->tieneMuchos=$tieneMuchos;
			$pipe->perteneceAUno=$perteneceAUno;
			$pipe->perteneceAMuchos=$perteneceAMuchos;
			$pipe->clase=$clase;
		}
		if(is_array($valor) and !empty($valor)){
			$objetos=[];
			$cantValor=count($valor);
			for($i=0; $i<$cantValor; $i++){
				$consulta=Conexion::$cnx->prepare('select * from '.$pipe->_tabla.' where '.$llavePrimaria.'=?');
				if($consulta->execute([$valor[$i]])){
					$pipe->_llavePrimaria37812_=$llavePrimaria;
					$pipe->_valor37812_=$valor[$i];
					$datosArreglo=$consulta->fetch();
					$nulo=false;
					if(empty($datosArreglo)) $nulo=true;
					$campos=$pipe->obtenerCamposTabla();
					$cantCampos=count($campos);
					for($j=0; $j<$cantCampos; $j++){
						//Creamos los atributos de los campos de la base de datos en el objeto $pipe.
						$atributo=$campos[$j];
						$valorAtributo=$pipe->convertirValorNumerico($datosArreglo[$atributo]);
						$pipe->$atributo=$valorAtributo;
					}
					if($nulo==false){
						$pipe->asignarDatosModeloRelacion($pipe);
						$objetos[$i]=clone $pipe;
					}
					else{
						$objetos[$i]=null;
					}
				}
				else{
					$pipe->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
				}
			}
			return $objetos;
		}
		else{
			$consulta=Conexion::$cnx->prepare('select * from '.$pipe->_tabla.' where '.$llavePrimaria.'=?');
			if($consulta->execute([$valor])){
				$pipe->_llavePrimaria37812_=$llavePrimaria;
				$pipe->_valor37812_=$valor;
				$datosArreglo=$consulta->fetch();
				if(empty($datosArreglo)) return null;
				$campos=$pipe->obtenerCamposTabla();
				$cantCampos=count($campos);
				for($i=0; $i<$cantCampos; $i++){
					//Creamos los atributos de los campos de la base de datos en el objeto $pipe.
					$atributo=$campos[$i];
					$valorAtributo=$pipe->convertirValorNumerico($datosArreglo[$atributo]);
					$pipe->$atributo=$valorAtributo;
				}
				$pipe->asignarDatosModeloRelacion($pipe);
				return $pipe;
			}
			else{
				$pipe->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
			}
		}
	}
	/*
     * Actualiza un registro en la base de datos.
     *
     * @parametro array $valores
     * @retorno int
     */
	public function actualizar($valores=[]){
		$actualizado_en=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? 'ACTUALIZADO_EN' : 'actualizado_en';
		$camposTabla=$this->obtenerCamposTabla();
		$cantCamposTabla=count($camposTabla);
		if(is_array($valores) and !empty($valores)){
			$j=0;
			for($i=0; $i<$cantCamposTabla; $i++){
				if($this->registroTiempo==true and $camposTabla[$i]==$actualizado_en) $j=1;
			}
			$parametros='';
			foreach($valores as $campo=>$valor){
				if(is_string($valor)) $valor="'".$valor."'";
				if(!isset($valor)) $valor='null';
				$parametros=$parametros.$campo.'='.$valor.',';
			}
			$parametros=substr($parametros,0,-1);
			$resultado=$this->procesarConsultaSQL('update '.$this->_tabla.' set '.$parametros.' '.$this->_condiciones,$this->_datos);
			if($resultado>0 and $this->registroTiempo==true and $j==1) $this->procesarConsultaSQL('update '.$this->_tabla.' set '.$actualizado_en."='".$this->obtenerFechaHoraActual()."' ".$this->_condiciones,$this->_datos);
				return $resultado;
		}
		else{
			$j=0;
			$parametros='';
			for($i=0; $i<$cantCamposTabla; $i++){
				$campo=$camposTabla[$i];
				if(empty($this->$campo)){
					$parametros=$parametros.$campo."=null,";
				}
				else{
					if(is_string($this->$campo)) $this->$campo="'".$this->$campo."'";
					$parametros=$parametros.$campo.'='.$this->$campo.',';
				}
				if($this->registroTiempo==true and $campo==$actualizado_en) $j=1;
			}
			$parametros=substr($parametros,0,-1);
			$resultado=$this->procesarConsultaSQL('update '.$this->_tabla.' set '.$parametros.' where '.$this->_llavePrimaria37812_.'=?',[$this->_valor37812_]);
			if($resultado>0 and $this->registroTiempo==true and $j==1) $this->procesarConsultaSQL('update '.$this->_tabla.' set '.$actualizado_en."='".$this->obtenerFechaHoraActual()."' where ".$this->_llavePrimaria37812_.'='.$this->_valor37812_);
				return $resultado;
		}
	}
	/*
     * Actualiza o inserta un nuevo registro en la base de datos.
     *
     * @parametro array $valores
     * @parametro array $inserciones
     * @retorno int|boolean
     */
	public function actualizarOInsertar($valores,$inserciones=[]){
		$condiciones=substr($this->_condiciones,7);
		if($this->donde($condiciones,$this->_datos)->existe()){
			if(is_array($valores) and !empty($valores)) return $this->actualizar($valores);
			return false;
		}
		else{
			if(is_array($inserciones) and !empty($inserciones)) return $this->insertar($inserciones);
			return false;		
		}
	}
	/*
     * Elimina un registro en la base de datos.
     *
     * @retorno int
     */
	public function eliminar(){
		if(empty($this->_condiciones) and empty($this->_llavePrimaria37812_) and empty($this->_valor37812_)){
			return $this->procesarConsultaSQL('delete from '.$this->_tabla);
		}
		else if(empty($this->_condiciones)){
			return $this->procesarConsultaSQL('delete from '.$this->_tabla.' where '.$this->_llavePrimaria37812_.'=?',[$this->_valor37812_]);
		}
		else if(!empty($this->_condiciones)){
			return $this->procesarConsultaSQL('delete from '.$this->_tabla.' '.$this->_condiciones,$this->_datos);
		}
	}
	/*
     * Elimina todos los registros en la tabla y reinicia el contador autoincrementable.
     *
     * @parametro string $sentencia
     * @retorno int
     */
	public function vaciar($sentencia=''){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$pipe=$this;
		}
		else{
			$atributosClase=ConstructorConsulta::obtenerAtributosClase($clase);
			$tabla=$atributosClase['tabla'];
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(Configuracion::obtenerVariable('BD_CONTROLADOR')=='sqlite'){
			$consulta=Conexion::$cnx->exec('delete from '.$pipe->_tabla);
			$consulta1=Conexion::$cnx->exec('update sqlite_sequence set seq=0 where name='."'".$pipe->_tabla."'".'');
			if($consulta===false or $consulta1===false){
				$pipe->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);	
			}
			else{
				return 1;
			}
		}
		else{
			$sentencia=$pipe->traducirConsultaSQL($sentencia);
			if(is_string($sentencia) and $sentencia!='') Conexion::$cnx->exec($sentencia);
			$consulta=Conexion::$cnx->exec('truncate table '.$pipe->_tabla);
			if($consulta===false){
				$pipe->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
			}
			else{
				return 1;
			}
		}
	}
	//Fin instrucciones insertar, actualizar, eliminar y vaciar.
	//Inicio autenticación de usuarios.
	/*
     * Autentica un registro en la base de datos.
     *
     * @parametro array $credencialesY
     * @parametro array|string $credencialesO
     * @parametro string $tipo
     * @retorno object|array|json|boolean
     */
	public function autenticar($credencialesY,$credencialesO=[],$tipo=ConstructorConsulta::OBJETO){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$metodo=ConstructorConsulta::obtenerMetodoLlamado(debug_backtrace());
			exit(Mensaje::$mensajes['TABLA_NO_DEFINIDA'].'<b>'.$metodo.'()</b>.');
		}
		else if($clase=='ConstructorConsulta'){
			$tabla=$this->_tabla;
			$pipe=$this;	
		}
		else{
			$tabla=ConstructorConsulta::convertirModeloTabla($clase);
			$pipe=ConstructorConsulta::tabla($tabla);
		}
		if(is_string($credencialesO) and ($credencialesO==ConstructorConsulta::OBJETO or $credencialesO==ConstructorConsulta::ARREGLO or $credencialesO==ConstructorConsulta::JSON)) $tipo=$credencialesO;
		$condicion='';
		$valores=[];
		$i=0;
		foreach($credencialesY as $campo=>$valor){
			$condicion=$condicion.$campo.'=? and ';
			$valores[$i]=$valor;
			$i++;
		}
		if(is_array($credencialesO) and !empty($credencialesO)){
			$condicion=$condicion.'(';
			foreach($credencialesO as $campo=>$valor){
				$condicion=$condicion.$campo.'=? or ';
				$valores[$i]=$valor;
				$i++;
			}
			$condicion=substr($condicion,0,-4);
			$condicion=$condicion.')';
		}
		else{
			$condicion=substr($condicion,0,-5);
		}
		$autenticado=$pipe->procesarConsultaSQL('select * from '.$tabla.' where '.$condicion,$valores,$tipo);
		if($tipo==ConstructorConsulta::JSON){
			if($autenticado!='[]') return $autenticado;
			return false;
		}
		else{
			if($autenticado) return $autenticado[0];
			return false;
		}
	}
	//Fin autenticación de usuarios.
	/*
     * Realiza una consulta SQL en español.
     *
     * @parametro string $consulta
     * @parametro array|string $datos
     * @parametro string $tipo
     * @retorno array|json|int
     */
	public static function consulta($consulta,$datos=[],$tipo=ConstructorConsulta::OBJETO){	
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$pipe=ConstructorConsulta::tabla('tabla');
			return $pipe->procesarConsultaSQL($consulta,$datos,$tipo,false);
		}
		else{
			exit(Mensaje::$mensajes['CONSULTA_NO_PERMITIDO']);
		}
	}
	/*
     * Realiza una consulta SQL nativa.
     *
     * @parametro string $consulta
     * @parametro array|string $datos
     * @parametro string $tipo
     * @retorno array|json|int
     */
	public static function consultaNativa($consulta,$datos=[],$tipo=ConstructorConsulta::OBJETO){
		$clase=ConstructorConsulta::obtenerClaseLlamada(get_called_class());
		if($clase=='PIPE'){
			$pipe=ConstructorConsulta::tabla('tabla');
			return $pipe->procesarConsultaSQL($consulta,$datos,$tipo);
		}
		else{
			exit(Mensaje::$mensajes['CONSULTA_NATIVA_NO_PERMITIDO']);
		}
	}
	//Fin métodos públicos.
	//Inicio métodos protegidos.
	/*
     * Obtiene el nombre de la clase instanciada que ha hecho la invocación.
     *
     * @parametro string $nombreCompleto
     * @retorno string
     */
	protected static function obtenerClaseLlamada($nombreCompleto){
		$partesClase=explode('\\',$nombreCompleto);
		return $partesClase[count($partesClase)-1];
	}
	/*
     * Obtiene los atributos de la clase (modelo) instanciada.
     *
     * @parametro string $clase
     * @retorno array
     */
	protected static function obtenerAtributosClase($clase){
		$atributosClase=get_class_vars($clase);
		$atributos['tabla']=$atributosClase['tabla']!='' ? $atributosClase['tabla'] : ConstructorConsulta::convertirModeloTabla($clase);
		$atributos['llavePrimaria']=$atributosClase['llavePrimaria']!='id' ? $atributosClase['llavePrimaria'] : 'id';
		$atributos['registroTiempo']=$atributosClase['registroTiempo']!==true ? $atributosClase['registroTiempo'] : true;
		$atributos['tieneUno']=$atributosClase['tieneUno']!=[] ? $atributosClase['tieneUno'] : [];
		$atributos['tieneMuchos']=$atributosClase['tieneMuchos']!=[] ? $atributosClase['tieneMuchos'] : [];
		$atributos['perteneceAUno']=$atributosClase['perteneceAUno']!=[] ? $atributosClase['perteneceAUno'] : [];
		$atributos['perteneceAMuchos']=$atributosClase['perteneceAMuchos']!=[] ? $atributosClase['perteneceAMuchos'] : [];
		return $atributos;
	}
	//Fin métodos protegidos.
	//Inicio métodos privados.
	/*
     * Convierte el nombre del modelo (clase) en el nombre de la tabla de la base de datos.
     *
     * @parametro string $modelo
     * @retorno string
     */
	private static function convertirModeloTabla($modelo){
		$alfabeto=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		$letras=str_split($modelo);
		$buscar=[];
		$remplazar=[];
		$i=0;
		foreach($alfabeto as $alfa){
			foreach($letras as $letra){
				if($letra==$alfa){
					$buscar[$i]=$letra;						
					$remplazar[$i]='_'.$letra;
					$i++;							
				}
			}
		}
		return strtolower(substr(str_replace($buscar,$remplazar,$modelo),1).'s');
	}
	/*
     * Obtiene el nombre del método invocado.
     *
     * @parametro array $depuracion
     * @retorno string
     */
	private static function obtenerMetodoLlamado($depuracion){
		return $depuracion[0]['function'];
	}
	/*
     * Procesa y obtiene los datos de una consulta SQL.
     *
     * @parametro string $tipo
     * @parametro string $consultaUsuario
     * @parametro array|string $datos
     * @retorno array
     */
	private function obtenerDatosConsultaSQL($tipo=ConstructorConsulta::OBJETO,$consultaUsuario='',$datos=[]){
		if($consultaUsuario=='') $consultaUsuario='select '.$this->_distinto.' '.$this->_campos.' from '.$this->_tabla.' '.$this->_unir.' '.$this->_unirDerecha.' '.$this->_unirIzquierda.' '.$this->_condiciones.' '.$this->_agrupar.' '.$this->_teniendo.' '.$this->_ordenar.' '.$this->_limite;
		if(is_array($this->_datos) and !empty($this->_datos)) $datos=$this->_datos;
		if(is_array($datos) and !empty($datos)){
			$consulta=Conexion::$cnx->prepare($consultaUsuario);
			if($consulta->execute($datos)) $datosArreglo=$consulta->fetchAll(\PDO::FETCH_ASSOC);
			if(!$consulta->execute($datos)) $this->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
		}
		else{
			if($datos==ConstructorConsulta::OBJETO or $datos==ConstructorConsulta::ARREGLO or $datos==ConstructorConsulta::JSON) $tipo=$datos;
			$consulta=Conexion::$cnx->query($consultaUsuario);
			if($consulta) $datosArreglo=$consulta->fetchAll(\PDO::FETCH_ASSOC);
			if(!$consulta) $this->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
		}
		$campos=$this->obtenerCamposConsultaSQL($datosArreglo);
		$cantDatosArreglo=count($datosArreglo);
		if($cantDatosArreglo!=0 and count($campos)!=$consulta->columnCount()) exit(Mensaje::$mensajes['AMBIGUEDAD_DE_CAMPOS']);
		if($tipo!=ConstructorConsulta::OBJETO and $tipo!=ConstructorConsulta::ARREGLO and $tipo!=ConstructorConsulta::JSON) exit(Mensaje::$mensajes['TIPO_DATO_DESCONOCIDO'].'<b>'.$tipo.'</b>');
		$datosConsulta=[];
		for($i=0; $i<$cantDatosArreglo; $i++){
			if($tipo==ConstructorConsulta::OBJETO) $registro=new \stdClass();
			if($tipo==ConstructorConsulta::ARREGLO or $tipo==ConstructorConsulta::JSON) $registro=[];
			for($j=0; $j<$consulta->columnCount(); $j++){
				$atributo=$campos[$j];
				$valor=$this->convertirValorNumerico($datosArreglo[$i][$atributo]);
				if($tipo==ConstructorConsulta::OBJETO) $registro->$atributo=$valor;
				if($tipo==ConstructorConsulta::ARREGLO or $tipo==ConstructorConsulta::JSON) $registro[$atributo]=$valor;
			}
			$datosConsulta[$i]=$registro;
		}
		if($tipo==ConstructorConsulta::JSON) $datosConsulta=json_encode($datosConsulta);
		return $datosConsulta;
	}
	/*
     * Obtiene los campos seleccionados de una consulta SQL.
     *
     * @parametro array $datosArreglo
     * @retorno array|null
     */
	private function obtenerCamposConsultaSQL($datosArreglo){
		if(!empty($datosArreglo)) return array_keys($datosArreglo[0]);
		return null;
	}
	/*
     * Obtiene todos los campos de la tabla en la base de datos.
     *
     * @retorno array
     */
	private function obtenerCamposTabla(){
		switch(Configuracion::obtenerVariable('BD_CONTROLADOR')){
			case 'mysql':
				$consulta=Conexion::$cnx->query('describe '.$this->_tabla);
				$atributo='Field';
			break;
			case 'pgsql':
				$consulta=Conexion::$cnx->query('select column_name from information_schema.columns where table_schema='."'public'".' and table_name='."'".$this->_tabla."'".'');
				$atributo='column_name';
			break;
			case 'sqlite':
				$consulta=Conexion::$cnx->query('pragma table_info('.$this->_tabla.')');
				$atributo='name';
			break;
			case 'oci':
				$consulta=Conexion::$cnx->query('select column_name,data_length, data_type from all_tab_columns where table_name='."'".strtoupper($this->_tabla)."'".'');
				$atributo='COLUMN_NAME';
			break;
			case 'sqlsrv':
				$consulta=Conexion::$cnx->query('select column_name from information_schema.columns where table_name='."'".$this->_tabla."'".'');
				$atributo='column_name';
			break;
		}
		foreach($consulta->fetchAll() as $datos){
			$campos[]=$datos[$atributo];
		}
		return $campos;
	}
	/*
     * Procesa una consulta SQL.
     *
     * @parametro string $consulta
     * @parametro array $datos
     * @parametro string $tipo
     * @parametro boolean $nativa
     * @retorno array|json|int
     */
	private function procesarConsultaSQL($consulta,$datos=[],$tipo=ConstructorConsulta::OBJETO,$nativa=true){
		if($nativa==false) $consulta=$this->traducirConsultaSQL($consulta);
		if((strpos($consulta,'select')>-1 and strpos($consulta,'from')>-1) and (strpos($consulta,'select')<strpos($consulta,'from'))){
			return $this->obtenerDatosConsultaSQL($tipo,$consulta,$datos);
		}
		else{
			if(is_array($datos) and !empty($datos)){
				$consulta=Conexion::$cnx->prepare($consulta);
				if($consulta->execute($datos)) return $consulta->rowCount();
				if(!$consulta->execute($datos)) $this->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
			}
			else{
				$resultado=$consulta=Conexion::$cnx->exec($consulta);
				if($resultado==true or $resultado===0) return $resultado;
				if($resultado==false) $this->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
			}
		}
	}
	/*
     * Asigna los datos relacionados a un modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
	private function asignarDatosModeloRelacion(ConstructorConsulta $pipe){
		if($pipe->tieneUno){
			if(is_string($pipe->tieneUno)) $pipe->tieneUno=[$pipe->tieneUno=>null];
			foreach($pipe->tieneUno as $clase=>$valores){
				if(!class_exists($clase)) exit(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].'<b>'.$clase.'</b>');
				$atributosClaseUnion=ConstructorConsulta::obtenerAtributosClase($clase);
				$tablaUnion=$atributosClaseUnion['tabla'];
				$atributo=substr($tablaUnion,0,-1);
				$llaveForanea=isset($valores['llaveForanea']) ? $valores['llaveForanea'] : strtolower($pipe->clase).'_id';
				if(isset($valores['llavePrincipal'])){
					$llavePrincipal=$valores['llavePrincipal'];
					$valorllavePrincipal=$pipe->tabla($pipe->tabla)->seleccionar($llavePrincipal)->donde($pipe->_llavePrimaria37812_.'=?',[$pipe->_valor37812_])->obtener()[0]->$llavePrincipal;
				}
				else{
					$valorllavePrincipal=$pipe->_valor37812_;
				}
				$datos=$pipe->tabla($tablaUnion)->limite(1)->donde($llaveForanea.'=?',[$valorllavePrincipal]);
				$datos=$datos->existe() ? $datos->obtener()[0] : null;
				$pipe->_datosModeloRelacion[$atributo]=$datos;
			}
		}
		if($pipe->tieneMuchos){
			if(is_string($pipe->tieneMuchos)) $pipe->tieneMuchos=[$pipe->tieneMuchos=>null];
			foreach($pipe->tieneMuchos as $clase=>$valores){
				if(!class_exists($clase)) exit(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].'<b>'.$clase.'</b>');
				$atributosClaseUnion=ConstructorConsulta::obtenerAtributosClase($clase);
				$tablaUnion=$atributosClaseUnion['tabla'];
				$llaveForanea=isset($valores['llaveForanea']) ? $valores['llaveForanea'] : strtolower($pipe->clase).'_id';
				if(isset($valores['llavePrincipal'])){
					$llavePrincipal=$valores['llavePrincipal'];
					$valorllavePrincipal=$pipe->tabla($pipe->tabla)->seleccionar($llavePrincipal)->donde($pipe->_llavePrimaria37812_.'=?',[$pipe->_valor37812_])->obtener()[0]->$llavePrincipal;
				}
				else{
					$valorllavePrincipal=$pipe->_valor37812_;
				}
				$datos=$pipe->tabla($tablaUnion)->donde($llaveForanea.'=?',[$valorllavePrincipal])->obtener();
				$pipe->_datosModeloRelacion[$tablaUnion]=$datos;
			}
		}
		if($pipe->perteneceAUno){
			if(is_string($pipe->perteneceAUno)) $pipe->perteneceAUno=[$pipe->perteneceAUno=>null];
			foreach($pipe->perteneceAUno as $clase=>$valores){
				if(!class_exists($clase)) exit(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].'<b>'.$clase.'</b>');
				$atributosClaseUnion=ConstructorConsulta::obtenerAtributosClase($clase);
				$tablaUnion=$atributosClaseUnion['tabla'];
				$llavePrimariaUnion=$atributosClaseUnion['llavePrimaria'];
				$atributo=substr($tablaUnion,0,-1);
				$llaveForanea=isset($valores['llaveForanea']) ? $valores['llaveForanea'] : strtolower($clase).'_id';
				$valorForanea=$pipe->tabla($pipe->_tabla)->seleccionar($llaveForanea)->donde($pipe->_llavePrimaria37812_.'=?',[$pipe->_valor37812_])->obtener()[0]->$llaveForanea;
				if(isset($valores['llavePrincipal'])){
					$llavePrincipal=$valores['llavePrincipal'];
					$valorllavePrincipal=$pipe->tabla($tablaUnion)->seleccionar($llavePrincipal)->donde($llavePrimariaUnion.'=?',[$valorForanea])->obtener()[0]->$llavePrincipal;
				}
				else{
					$valorllavePrincipal=$valorForanea;
				}
				$datos=$pipe->tabla($tablaUnion)->donde($llavePrimariaUnion.'=?',[$valorllavePrincipal]);
				$datos=$datos->existe() ? $datos->obtener()[0] : null;
				$pipe->_datosModeloRelacion[$atributo]=$datos;
			}
		}
		if($pipe->perteneceAMuchos){
			if(is_string($pipe->perteneceAMuchos)) $pipe->perteneceAMuchos=[$pipe->perteneceAMuchos=>null];
			foreach($pipe->perteneceAMuchos as $clase=>$valores){
				if(!class_exists($clase)) exit(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].'<b>'.$clase.'</b>');
				$atributosClaseUnion=ConstructorConsulta::obtenerAtributosClase($clase);
				$tablaUnion=$atributosClaseUnion['tabla'];
				$llavePrimariaUnion=$atributosClaseUnion['llavePrimaria'];
				$modelos=[$pipe->clase,$clase];
				sort($modelos);
				$tablaUnionRelacion=isset($valores['tablaUnion']) ? $valores['tablaUnion'] : strtolower($modelos[0].'_'.$modelos[1]);
				$llaveForaneaLocal=isset($valores['llaveForaneaLocal']) ? $valores['llaveForaneaLocal'] : strtolower($pipe->clase).'_id';
				$llaveForaneaUnion=isset($valores['llaveForaneaUnion']) ? $valores['llaveForaneaUnion'] : strtolower($clase).'_id';
				$relacion=$pipe->tabla($tablaUnion)->unir($tablaUnionRelacion,$tablaUnion.'.'.$llavePrimariaUnion,$tablaUnionRelacion.'.'.$llaveForaneaUnion);
				$datos=$relacion->seleccionar($tablaUnion.'.*')->donde($tablaUnionRelacion.'.'.$llaveForaneaLocal.'=?',[$pipe->_valor37812_])->obtener();
				foreach($datos as $dato){
					$datosTablaUnionRelacion=$relacion->seleccionar($tablaUnionRelacion.'.*')
					->donde($tablaUnionRelacion.'.'.$llaveForaneaLocal.'=? y '.$tablaUnionRelacion.'.'.$llaveForaneaUnion.'=?',[$pipe->_valor37812_,$dato->$llavePrimariaUnion])->obtener()[0];
					$dato->$tablaUnionRelacion=$datosTablaUnionRelacion;
				}
				$pipe->_datosModeloRelacion[$tablaUnion]=$datos;
			}
		}
	}
	/*
     * Convierte el valor de tipo string en int o float.
     *
     * @parametro string $valor
     * @retorno int|float|string
     */
	private function convertirValorNumerico($valor){
		if(is_numeric($valor)) return $valor+0;
		return $valor;
	}
	/*
     * Valida que un valor a buscar se encuentre separado por espacios en ambos extremos dentro de una cadena.
     *
     * @parametro string $buscar
     * @parametro string $cadena
     * @parametro string|boolean $IF
     * @parametro boolean $sensible
     * @retorno boolean|string
     */
	private function validarCadenaIndependiente($buscar,$cadena,$IF='',$sensible=true){
		//Valida si la cadena $buscar es independiente o se encuentra dentro de otra.
		if($sensible==true or $IF===true) $posicion=strpos($cadena,$buscar);
		if($sensible==false or $IF===false) $posicion=stripos($cadena,$buscar);
		$tamano=strlen($buscar);
		$I=substr($cadena,$posicion-1,1);
		$F=substr($cadena,$posicion+$tamano,1);
		if($IF=='I'){
			return trim($I);
		}
		else if($IF=='F'){
			return trim($F);
		}
		else{
			if(trim($I)=='' and trim($F)==''){
				return true;
			}
			else{
				return false;
			}
		}
	}
	/*
     * Remplaza la primera coincidencia que encuentra en una cadena.
     *
     * @parametro string $viejo
     * @parametro string $nuevo
     * @parametro string $cadena
     * @parametro boolean $sensible
     * @retorno string
     */
	private function remplazarPrimeraCadena($viejo,$nuevo,$cadena,$sensible=true){
		$condicion=$sensible===true ? strpos($cadena,$viejo)>-1 : stripos($cadena,$viejo)>-1;
		$posicionInicial=$sensible===true ? strpos($cadena,$viejo) : stripos($cadena,$viejo);
		if($condicion) $cadena=substr_replace($cadena,$nuevo,$posicionInicial,strlen($viejo));
		//$cadena=preg_replace('/'.preg_quote($viejo,'/').'/',$nuevo,$cadena,1);
		return $cadena;
	}
	/*
     * Remplaza un valor que se encuentre separado por espacios en ambos extremos dentro de una cadena.
     *
     * @parametro string $viejo
     * @parametro string $nuevo
     * @parametro string $cadena
     * @parametro boolean $sensible
     * @retorno string
     */
	private function remplazarCadenaIndependiente($viejo,$nuevo,$cadena,$sensible=true){
		$condicion=$sensible===true ? strpos($cadena,$viejo)>-1 : stripos($cadena,$viejo)>-1;
		while($condicion){
			$condicion=$sensible===true ? strpos($cadena,$viejo)>-1 : stripos($cadena,$viejo)>-1;
			/*
			Buscamos elementos al inicio y al final de la busqueda ($viejo) recibida
			para definir si lo encontrado en la $cadena es una palabra independiente o está dentro de otra.
			*/
			$I=$this->validarCadenaIndependiente($viejo,$cadena,'I',$sensible);
			$F=$this->validarCadenaIndependiente($viejo,$cadena,'F',$sensible);
			if($I!='' or $F!=''){
				/*
				En caso de que la palabra encontrada no este independiente
				se procede a remplazarla por *# para que pueda continuar buscando y remplazando.
				*/
				$cadena=$this->remplazarPrimeraCadena($viejo,'*#',$cadena,$sensible);
			}
			else{
				/*
				En caso de que la palabra encontrada este independiente
				se procede a reemplazarla por *#*# para que pueda continuar buscando y remplazando.
				*/
				$cadena=$this->remplazarPrimeraCadena($viejo,'*#*#',$cadena,$sensible);
				//$cadena=preg_replace('/'.preg_quote($viejo,'/').'/',$nuevo,$cadena,1);
			}
		}
		/*
		Volvemos a poner los *# por los catacteres $viejo
		Volvemos a poner los *#*# por los catacteres $nuevo.
		*/
		$cadena=str_replace('*#*#',$nuevo,$cadena);
		$cadena=str_replace('*#',$viejo,$cadena);
		return $cadena;
	}
	/*
     * Traduce una consulta SQL en español a una consulta SQL nativa.
     *
     * @parametro string $consulta
     * @retorno string
     */
	private function traducirConsultaSQL($consulta){
		//Palabras reservadas para la consulta en español.
		$consultaUsuario=$consulta;
		$consulta=' '.$consulta.' ';
		$consulta=str_ireplace('seleccionar',' seleccionar ',$consulta);
		$palabras=explode(' ',$consulta);
		$cantPalabras=count($palabras);
		for($i=0; $i<$cantPalabras; $i++){
			if($this->validarCadenaIndependiente('seleccionar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('seleccionar',' select ',$palabras[$i]);
			if($this->validarCadenaIndependiente('distinto'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('distinto',' distinct ',$palabras[$i]);	
			if($this->validarCadenaIndependiente('todo'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('todo',' * ',$palabras[$i]);
			if($this->validarCadenaIndependiente('alias'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('alias',' as ',$palabras[$i]);
			if($this->validarCadenaIndependiente('de'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('de',' from ',$palabras[$i]);
			if($this->validarCadenaIndependiente('unir'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('unir',' join ',$palabras[$i]);
			if($this->validarCadenaIndependiente('derecha'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('derecha',' right ',$palabras[$i]);
			if($this->validarCadenaIndependiente('izquierda'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('izquierda',' left ',$palabras[$i]);
			if($this->validarCadenaIndependiente('en'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('en',' on ',$palabras[$i]);
			if($this->validarCadenaIndependiente('donde'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('donde',' where ',$palabras[$i]);
			if($this->validarCadenaIndependiente('agrupar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('agrupar',' group ',$palabras[$i]);
			if($this->validarCadenaIndependiente('teniendo'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('teniendo',' having ',$palabras[$i]);
			if($this->validarCadenaIndependiente('ordenar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('ordenar',' order ',$palabras[$i]);
			if($this->validarCadenaIndependiente('limite'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('limite',' limit ',$palabras[$i]);
			if($this->validarCadenaIndependiente('por'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('por',' by ',$palabras[$i]);
			if($this->validarCadenaIndependiente('existe'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('existe',' exists ',$palabras[$i]);
			if($this->validarCadenaIndependiente('es'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('es',' is ',$palabras[$i]);				
			if($this->validarCadenaIndependiente('nulo'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('nulo','null ',$palabras[$i]);				
			//Operadores lógicos.
			if($this->validarCadenaIndependiente('o'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('o',' or ',$palabras[$i]);
			if($this->validarCadenaIndependiente('xo'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('xo',' xor ',$palabras[$i]);
			if($this->validarCadenaIndependiente('y'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('y',' and ',$palabras[$i]);
			if($this->validarCadenaIndependiente('no'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('no',' not ',$palabras[$i]);
			if($this->validarCadenaIndependiente('entre'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('entre',' between ',$palabras[$i]);
			if($this->validarCadenaIndependiente('como'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('como',' like ',$palabras[$i]);
			//Manejo de datos
			if($this->validarCadenaIndependiente('insertar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('insertar',' insert ',$palabras[$i]);
			if($this->validarCadenaIndependiente('dentro'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('dentro',' into ',$palabras[$i]);
			if($this->validarCadenaIndependiente('valores'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('valores',' values ',$palabras[$i]);
			if($this->validarCadenaIndependiente('actualizar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('actualizar',' update ',$palabras[$i]);
			if($this->validarCadenaIndependiente('asignar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('asignar',' set ',$palabras[$i]);
			if($this->validarCadenaIndependiente('eliminar'," $palabras[$i] ",false) and strlen($palabras[$i])>0) $palabras[$i]=str_ireplace('eliminar',' delete ',$palabras[$i]);
		}
		$consulta=implode(' ',$palabras);
		//Funciones
		$consulta=str_ireplace('concatenar','concat',$consulta);
		$consulta=str_ireplace('promedio','avg',$consulta);
		$consulta=str_ireplace('contar','count',$consulta);
		$consulta=str_ireplace('maximo','max',$consulta);
		$consulta=str_ireplace('minimo','min',$consulta);
		$consulta=str_ireplace('suma','sum',$consulta);
		$consultaTraducida=$consulta;
		//Traducir solo lo que esta fuera de comillas.
		$partesUsuario=[];
		$partesTraducido=[];
		//Buscamos todo lo que se encuentre dentro de comillas dobles o simples.
		$i=0;
		while(strpos($consultaUsuario,"'")>-1 or strpos($consultaUsuario,'"')>-1){
			$consultaUsuario=$this->remplazarPrimeraCadena("'","?$i",$consultaUsuario);
			$consultaUsuario=$this->remplazarPrimeraCadena('"',"?$i",$consultaUsuario);
			$i++;
		}
		$k=0;
		//Guardamos en un arreglo lo que el usuario ingreso dentro de comillas.
		for($j=0; $j<$i; $j++){
			$in=$j;
			$fn=$j+1;
			if($j%2==0){
				$partesUsuario[$k]="'".substr($consultaUsuario,strpos($consultaUsuario,"?$in")+2,(strpos($consultaUsuario,"?$fn")-strpos($consultaUsuario,"?$in")-2))."'";
				$k++;
			}		
		}
		//Buscamos todo lo que se encuentre dentro de comillas dobles o simples en la consulta traducida.
		$i=0;
		while(strpos($consulta,"'")>-1 or strpos($consulta,'"')>-1){
			$consulta=$this->remplazarPrimeraCadena("'","?$i",$consulta);
			$consulta=$this->remplazarPrimeraCadena('"',"?$i",$consulta);
			$i++;
		}
		$k=0;
		//Guardamos en un arreglo lo que se encuentre dentro de comillas en la consulta traducida.
		for($j=0; $j<$i; $j++){
			$in=$j;
			$fn=$j+1;
			if($j%2==0){
				$partesTraducido[$k]=substr($consulta,strpos($consulta,"?$in")+2,(strpos($consulta,"?$fn")-strpos($consulta,"?$in")-2));
				$k++;
			}		
		}
		//Remplazamos lo que esta dentro de comillas traducido por lo que ingreso el usuario entre comillas.
		$cantPartesTraducido=count($partesTraducido);
		for($i=0; $i<$cantPartesTraducido; $i++){
			if(strpos($consultaTraducida,"'".$partesTraducido[$i])."'">-1) $consultaTraducida=str_replace("'".$partesTraducido[$i]."'",$partesUsuario[$i],$consultaTraducida);
			if(strpos($consultaTraducida,'"'.$partesTraducido[$i]).'"'>-1) $consultaTraducida=str_replace('"'.$partesTraducido[$i].'"',$partesUsuario[$i],$consultaTraducida);
		}
		return $consultaTraducida;
	}
	/*
     * Traduce errores SQL.
     *
     * @parametro string $error
     * @retorno string
     */
	private function traducirErrorSQL($error){
		//Texto largo
		$error=$this->remplazarCadenaIndependiente('You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near','tienes un error en tu sintaxis sql; consulte el manual que corresponde a la versión de su servidor MariaDB para conocer la sintaxis correcta para usar cerca de',$error);
		$error=$this->remplazarCadenaIndependiente('No function matches the given name and argument types. You might need to add explicit type casts.','Ninguna función coincide con los tipos de nombre y argumento dados. Es posible que necesite agregar conversiones de tipo explícito.',$error);
		$error=$this->remplazarCadenaIndependiente("is specified twice, both as a target for 'UPDATE' and as a separate source for data","se especifica dos veces, como objetivo para 'ACTUALIZAR' y como fuente separada para datos",$error);
		$error=$this->remplazarCadenaIndependiente('Cannot delete or update a parent row: a foreign key constraint fails','No se puede actualizar el valor de una llave primaria ni eliminar el registro donde el campo primario este ligado a una llave foránea',$error);
		$error=$this->remplazarCadenaIndependiente('Cannot add or update a child row: a foreign key constraint fails','No se puede agregar o actualizar una fila secundaria: error en la llave foránea',$error);
		$error=$this->remplazarCadenaIndependiente('invalid user.table.column, table.column, or column specification','user.table.column, table.column o especificación de columna no válida',$error);
		$error=$this->remplazarCadenaIndependiente('unique/primary keys in table referenced by enabled foreign keys','llaves únicas / primarias en la tabla referenciada por llaves foráneas habilitadas',$error);
		$error=$this->remplazarCadenaIndependiente('Cannot truncate a table referenced in a foreign key constraint','No se puede vaciar una tabla a la que se hace referencia en una restricción de llave foránea',$error);
		$error=$this->remplazarCadenaIndependiente('cannot truncate a table referenced in a foreign key constraint','no se puede vaciar una tabla a la que se hace referencia en una llave foránea',$error);
		$error=$this->remplazarCadenaIndependiente('a non-numeric character was found where a numeric was expected','se encontró un carácter no numérico donde se esperaba un número',$error);
		$error=$this->remplazarCadenaIndependiente('the numeric value does not match the length of the format item','el valor numérico no coincide con la longitud del elemento de formato',$error);
		$error=$this->remplazarCadenaIndependiente('argument of WHERE must be type boolean, not type','argumento de WHERE debe ser de tipo booleano, no de tipo',$error);
		$error=$this->remplazarCadenaIndependiente('could not connect to server: Connection refused','no se pudo conectar al servidor: conexión rechazada',$error);
		$error=$this->remplazarCadenaIndependiente('duplicate key value violates unique constraint','el valor de la llave duplicada viola la restricción única',$error);
		$error=$this->remplazarCadenaIndependiente("Column count doesn't match value count at row",'El conteo de columnas no coincide con el conteo de valores en la fila',$error);
		$error=$this->remplazarCadenaIndependiente('input value not long enough for date format','el valor de entrada no es lo suficientemente largo para el formato de fecha',$error);
		$error=$this->remplazarCadenaIndependiente('Perhaps you meant to reference the column','Tal vez deseaste hacer referencia a la columna',$error);
		$error=$this->remplazarCadenaIndependiente('has more target columns than expressions','tiene más columnas de destino que expresiones',$error);
		$error=$this->remplazarCadenaIndependiente('has more expressions than target columns','tiene más expresiones que columnas de destino',$error);
		$error=$this->remplazarCadenaIndependiente('invalid input syntax for type timestamp:','sintaxis de entrada no válida para el registro de tiempo de tipo:',$error);	
		$error=$this->remplazarCadenaIndependiente('invalid username/password; logon denied','usuario/contraseña invalida; inicio de sesión denegado',$error);
		$error=$this->remplazarCadenaIndependiente('FROM keyword not found where expected','palabra clave FROM no se encuentra donde se esperaba',$error);
		$error=$this->remplazarCadenaIndependiente('bad parameter or other API misuse','mal parámetro u otro uso incorrecto de la API',$error);			
		$error=$this->remplazarCadenaIndependiente('missing FROM-cláusula entry for','falta la entrada de FROM-cláusula para',$error);
		$error=$this->remplazarCadenaIndependiente('violates foreign key constraint','viola la restricción de llave foránea',$error);
		$error=$this->remplazarCadenaIndependiente('is still referenced from table','todavía está referenciado en la tabla',$error);
		$error=$this->remplazarCadenaIndependiente('SQL command not properly ended','El comando SQL no ha finalizado correctamente',$error);
		$error=$this->remplazarCadenaIndependiente('could not translate host name','no se pudo traducir el nombre del host',$error);
		$error=$this->remplazarCadenaIndependiente('violated - child record found','violado - registro hijo encontrado',$error);
		$error=$this->remplazarCadenaIndependiente('syntax error at end of input','tienes un error en tu sintaxis sql al final de la entrada',$error);
		$error=$this->remplazarCadenaIndependiente('day of month must be between','el día del mes debe estar entre',$error);
		$error=$this->remplazarCadenaIndependiente('column ambiguously defined','columna ambiguamente definida',$error);
		$error=$this->remplazarCadenaIndependiente('update or delete on table','actualizar o eliminar en la tabla',$error);
		$error=$this->remplazarCadenaIndependiente('UNIQUE constraint failed:','La restricción ÚNICA ha fallado:',$error);
		$error=$this->remplazarCadenaIndependiente('clause is required before','cláusula es requerido antes de',$error);
		$error=$this->remplazarCadenaIndependiente('at the same time, or use','al mismo tiempo, o usar',$error);
		$error=$this->remplazarCadenaIndependiente('syntax error at or near','tienes un error en tu sintaxis sql cerca de',$error);
		$error=$this->remplazarCadenaIndependiente('Not unique table/alias:','Tabla/Alias no únicos:',$error);
		$error=$this->remplazarCadenaIndependiente('minutes must be between','los minutos deben estar entre',$error);
		$error=$this->remplazarCadenaIndependiente('seconds must be between','los segundos deben estar entre',$error);
		$error=$this->remplazarCadenaIndependiente('cannot insert NULL into','no se puede insertar NULO en',$error);
		$error=$this->remplazarCadenaIndependiente('Access denied for user','Acceso denegado para el usuario',$error);
		$error=$this->remplazarCadenaIndependiente('ambiguous column name:','nombre de columna ambiguo:',$error);
		$error=$this->remplazarCadenaIndependiente('could not find driver','No se pudo encontrar el controlador',$error);
		$error=$this->remplazarCadenaIndependiente('invalid SQL statement','sentencia SQL inválida',$error);
		$error=$this->remplazarCadenaIndependiente('and last day of month','y el último día del mes',$error);
		$error=$this->remplazarCadenaIndependiente('hour must be between','la hora debe estar entre',$error);
		$error=$this->remplazarCadenaIndependiente('has no column named','no tiene una columna llamada',$error);
		$error=$this->remplazarCadenaIndependiente('no such function:','no existe dicha función:',$error);
		$error=$this->remplazarCadenaIndependiente('not a valid month','no es un mes válido',$error);
		$error=$this->remplazarCadenaIndependiente('Query was empty','La consulta esta vacía',$error);
		$error=$this->remplazarCadenaIndependiente('no such column:','no existe dicha columna:',$error);
		$error=$this->remplazarCadenaIndependiente('does not exist','no existe',$error);
		$error=$this->remplazarCadenaIndependiente('no such table:','no existe dicha tabla:',$error);
		//Texto con 2 palabras
		$error=$this->remplazarCadenaIndependiente('Undeclared variable:','Variable no declarada:',$error);
		$error=$this->remplazarCadenaIndependiente('integrity constraint','restricción de integridad',$error);
		$error=$this->remplazarCadenaIndependiente('unrecognized token:','símbolo no reconocido:',$error);
		$error=$this->remplazarCadenaIndependiente('missing expression','expresión perdida',$error);
		$error=$this->remplazarCadenaIndependiente('invalid identifier','identificador no válido',$error);
		$error=$this->remplazarCadenaIndependiente('column reference','la columna de referencia',$error);
		$error=$this->remplazarCadenaIndependiente('incomplete input','entrada incompleta',$error);
		$error=$this->remplazarCadenaIndependiente('Duplicate entry','entrada duplicada',$error);
		$error=$this->remplazarCadenaIndependiente('already exists.','ya existe.',$error);	
		$error=$this->remplazarCadenaIndependiente('Unknown column','columna desconocida',$error);
		$error=$this->remplazarCadenaIndependiente("doesn't exist",'no existe',$error);
		$error=$this->remplazarCadenaIndependiente('syntax error','error de sintaxis',$error);
		$error=$this->remplazarCadenaIndependiente('field list','la lista de campos de la tabla '.$this->_tabla,$error);
		$error=$this->remplazarCadenaIndependiente('for key','para la llave',$error);
		$error=$this->remplazarCadenaIndependiente('at line','en la línea',$error);																				
		//Texto con 1 palabra
		$error=$this->remplazarCadenaIndependiente('references','referencias',$error);	
		$error=$this->remplazarCadenaIndependiente('ambiguous','ambigua',$error);
		$error=$this->remplazarCadenaIndependiente('database','base de datos',$error);
		$error=$this->remplazarCadenaIndependiente('relation','relación',$error);
		$error=$this->remplazarCadenaIndependiente('Truncate','vaciar',$error);
		$error=$this->remplazarCadenaIndependiente('FUNCTION','FUNCIÓN',$error,false);
		$error=$this->remplazarCadenaIndependiente('address:','dirección:',$error);
		$error=$this->remplazarCadenaIndependiente('sequence','secuencia',$error);
		$error=$this->remplazarCadenaIndependiente('DETAIL:','DETALLE:',$error);
		$error=$this->remplazarCadenaIndependiente('unknown','desconocido',$error,false);
		$error=$this->remplazarCadenaIndependiente('columns','columnas',$error,false);
		$error=$this->remplazarCadenaIndependiente('clause','cláusula',$error);
		$error=$this->remplazarCadenaIndependiente('column','la columna',$error,false);
		$error=$this->remplazarCadenaIndependiente('values','valores',$error);
		$error=$this->remplazarCadenaIndependiente('HINT:','PISTA:',$error);
		$error=$this->remplazarCadenaIndependiente('value','valor',$error);
		$error=$this->remplazarCadenaIndependiente('table','la tabla',$error,false);
		$error=$this->remplazarCadenaIndependiente('LINE','LÍNEA',$error);
		$error=$this->remplazarCadenaIndependiente('role','rol',$error);
		$error=$this->remplazarCadenaIndependiente('view','vista',$error);
		$error=$this->remplazarCadenaIndependiente('near','cerca de',$error);
		$error=$this->remplazarCadenaIndependiente('key','llave',$error,false);
		$error=$this->remplazarCadenaIndependiente('for','para',$error,false);
		$error=$this->remplazarCadenaIndependiente('and','y',$error);
		$error=$this->remplazarCadenaIndependiente('is','es',$error);
		$error=$this->remplazarCadenaIndependiente('in','en',$error);
		$error=$this->remplazarCadenaIndependiente('of','de',$error);
		$error=$this->remplazarCadenaIndependiente('to','a',$error);
		$error=$this->remplazarCadenaIndependiente('on','en',$error);
		$error=$this->remplazarCadenaIndependiente('or','o',$error);
		$error=$this->remplazarCadenaIndependiente('a','un',$error);
		return ucfirst(trim($error));
	}
	/*
     * Muestra el error de SQL y detiene la ejecución del script.
     *
     * @parametro int $codigoError
     * @parametro string $inforError
     * @retorno html
     */
	private function mostrarErrorSQL($codigoError,$infoError){
		switch(Configuracion::obtenerVariable('IDIOMA')){
			case 'es':
				$titulo='Error de SQL';
				$infoError=$this->traducirErrorSQL(' '.$infoError);
			break;
			case 'en':
				$titulo='SQL error';
			break;
		}
		exit('
		<div style="background-color:pink; padding:10px; border:1px solid maroon; border-radius:5px;">
			<b>'.$titulo.'</b>
			<hr style="border:1px solid red;">
			#'.$codigoError.' - '.$infoError.'
		</div>
		');
	}
	/*
     * Obtiene la fecha y la hora actual según la zona horaria.
     *
     * @retorno string
     */
	private function obtenerFechaHoraActual(){
		$zonaHoraria=Configuracion::obtenerVariable('ZONA_HORARIA');
		$zonaHoraria=$zonaHoraria ? $zonaHoraria : 'UTC';
		$dateTime=new \DateTime($zonaHoraria);
		$tiempo=Configuracion::obtenerVariable('BD_CONTROLADOR')=='oci' ? $dateTime->format('d-m-Y h:i:s') : $dateTime->format('Y-m-d H:i:s');
		return $tiempo;
	}
	//Fin métodos privados.
}