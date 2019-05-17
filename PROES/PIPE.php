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
	use PROES\Conexion;
	class PIPE{
		private $_distinto='';
		private $_campos='';
		private $_tabla='';
		private $_unir='';
		private $_unirDerecha='';
		private $_unirIzquierda='';
		private $_condiciones='';
		private $_agrupar='';
		private $_teniendo='';
		private $_ordenar='';
		private $_limite='';
		private $_datos='';
		protected $tabla=null;
		protected $llavePrimaria='id';
		protected $registroTiempo=true;
		protected $zonaHoraria='UTC';
		const OBJETO='objeto';
		const ARREGLO='arreglo';
		const JSON='json';
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
		//Inicio palabras reservadas de una consulta sql.
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
			return new PIPE($datosTabla);
		}
		public function alias($alias){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
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
			return new PIPE($datosTabla);
		}
		public function todo($campos='',$tipo=PIPE::OBJETO){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if(is_array($campos)){
				$camposUsuario='';
				foreach($campos as $campo){
					$camposUsuario=$camposUsuario.$campo.',';
				}
				$camposUsuario=substr($camposUsuario,0,-1);
				return $pipe->seleccionar($camposUsuario)->obtener($tipo);
			}
			else{
				if($campos==PIPE::OBJETO) $tipo=$campos;
				if($campos==PIPE::ARREGLO) $tipo=$campos;
				if($campos==PIPE::JSON) $tipo=$campos;
				return $pipe->obtenerDatosConsultaSQL($tipo);
			}
		}		
		public function distinto(){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
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
			return new PIPE($datosTabla);
		}
		public function seleccionar($campos=['*']){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
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
			return new PIPE($datosTabla);
		}
		public function unir($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union='=';
			}		
			$union=$pipe->_unir.' inner join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
			$union=$pipe->traducirConsultaSQL($union);
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
			return new PIPE($datosTabla);
		}
		public function unirDerecha($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union='=';
			}
			$union=$pipe->_unir.' right join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
			$union=$pipe->traducirConsultaSQL($union);
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
			return new PIPE($datosTabla);
		}
		public function unirIzquierda($tablaUnion,$llaveForanea,$union,$llavePrimaria=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union='=';
			}
			$union=$pipe->_unir.' left join '.$tablaUnion.' on '.$llaveForanea.' '.$union.' '.$llavePrimaria;
			$union=$pipe->traducirConsultaSQL($union);
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
			return new PIPE($datosTabla);
		}
		public function donde($condicion,$datos=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				$registroTiempo=true;
				$zonaHoraria='UTC';
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				if(get_class_vars($clase[count($clase)-1])['registroTiempo']==false) $registroTiempo=false;
				if(get_class_vars($clase[count($clase)-1])['zonaHoraria']!='UTC') $zonaHoraria=get_class_vars($clase[count($clase)-1])['zonaHoraria'];
				$pipe=PIPE::tabla($tabla);
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
			if($clase[count($clase)-1]=='PIPE'){
				return new PIPE($datosTabla);
			}
			else if($clase[count($clase)-1]!='PIPE'){
				$pipe=new PIPE($datosTabla);
				$pipe->registroTiempo=$registroTiempo;
				$pipe->zonaHoraria=$zonaHoraria;
				return $pipe;
			}	
		}
		public function agruparPor($grupo){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$grupo=$pipe->traducirConsultaSQL('group by '.$grupo);
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
			return new PIPE($datosTabla);
		}
		public function teniendo($condicion){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
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
			return new PIPE($datosTabla);
		}
		public function ordenarPor($ordenar,$tipo='asc'){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$ordenar=$pipe->traducirConsultaSQL('order by '.$ordenar.' '.$tipo);
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
			return new PIPE($datosTabla);
		}
		public function limite($inicio,$final=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
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
			return new PIPE($datosTabla);
		}
		public function primero($limite=1,$tipo=PIPE::OBJETO){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($limite==PIPE::OBJETO or $limite==PIPE::ARREGLO or $limite==PIPE::JSON){
				$tipo=$limite;
				$limite=1;
			}
			return $pipe->limite($limite)->obtener($tipo);
		}
		public function ultimo($llavePrimaria='id',$limite=1,$tipo=PIPE::OBJETO){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				if($llavePrimaria==PIPE::OBJETO or $llavePrimaria==PIPE::ARREGLO or $llavePrimaria==PIPE::JSON){
					$tipo=$llavePrimaria;
					$llavePrimaria='id';
				}
				else if(is_numeric($llavePrimaria)){
					if($limite==PIPE::OBJETO or $limite==PIPE::ARREGLO or $limite==PIPE::JSON) $tipo=$limite;
					$limite=$llavePrimaria;
					$llavePrimaria='id';
				}
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				if(get_class_vars($clase[count($clase)-1])['llavePrimaria']!='id') $llavePrimaria=get_class_vars($clase[count($clase)-1])['llavePrimaria'];
				$pipe=PIPE::tabla($tabla);
			}
			if($limite==PIPE::OBJETO or $limite==PIPE::ARREGLO or $limite==PIPE::JSON){
				$tipo=$limite;
				$limite=1;
			}
			return $pipe->ordenarPor($llavePrimaria,'desc')->limite($limite)->obtener($tipo);
		}
		public function contar(){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			return count($pipe->obtenerDatosConsultaSQL());
		}
		public function obtener($tipo=PIPE::OBJETO){
			return $this->obtenerDatosConsultaSQL($tipo);
		}
		//Fin palabras reservadas de una consulta sql.
		//Inicio instrucciones insertar, actualizar, eliminar y vaciar.
		public static function instanciar(){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				$llavePrimaria='id';
				$registroTiempo=true;
				$zonaHoraria='UTC';
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				if(get_class_vars($clase[count($clase)-1])['llavePrimaria']!='id') $llavePrimaria=get_class_vars($clase[count($clase)-1])['llavePrimaria'];
				if(get_class_vars($clase[count($clase)-1])['registroTiempo']==false) $registroTiempo=false;
				if(get_class_vars($clase[count($clase)-1])['zonaHoraria']!='UTC') $zonaHoraria=get_class_vars($clase[count($clase)-1])['zonaHoraria'];
				$pipe=PIPE::tabla($tabla);
				$pipe->tabla=$tabla;
				$pipe->llavePrimaria=$llavePrimaria;
				$pipe->registroTiempo=$registroTiempo;
				$pipe->zonaHoraria=$zonaHoraria;
					return $pipe;
			}
			else{
				exit('El método <b>instanciar()</b> solo puede ser usado por <b>clases (modelos)</b> que hacen referencia a una tabla en la base de datos.');
			}
		}
		public function insertar($valores=''){
			$creado_en='creado_en';
			$actualizado_en='actualizado_en';
			if(BD_CONTROLADOR=='oci') $creado_en=strtoupper($creado_en);
			if(BD_CONTROLADOR=='oci') $actualizado_en=strtoupper($actualizado_en);
			$campos=$this->obtenerCamposTabla();
			$cantCampos=count($campos);
			if($valores==''){
				if($this->registroTiempo==true){
					$this->$creado_en=$this->obtenerFechaHoraActual($this->zonaHoraria);
					$this->$actualizado_en=$this->obtenerFechaHoraActual($this->zonaHoraria);
				}
				else{
					$this->$creado_en='null';
					$this->$actualizado_en='null';
				}
				$atributos='';
				$valores='';
				for($i=0; $i<$cantCampos; $i++){
					$atributo=$campos[$i];
					$atributos=$atributos.$atributo.',';
					if(is_string($this->$atributo) and $this->$atributo!=='null' and $this->$atributo!=='default' and strpos($this->$atributo,'nextval')>-1===false) $this->$atributo="'".$this->$atributo."'";
					if(isset($this->$atributo)) $valores=$valores.$this->$atributo.',';
				}
				$atributos=substr($atributos,0,-1);
				$valores=substr($valores,0,-1);
					return $this->procesarConsultaSQL('insert into '.$this->_tabla.' ('.$atributos.') values ('.$valores.')');
			}
			else{
				$atributos='';
				$datos='';
				foreach($valores as $campo=>$valor){
					$atributos=$atributos.$campo.',';
					if(is_string($valor) and $valor!=='null' and $valor!=='default' and strpos($valor,'nextval')>-1===false) $valor="'".$valor."'";
					if(isset($valor)) $datos=$datos.$valor.',';
				}
				$j=0;
				for($i=0; $i<$cantCampos; $i++){
					if($campos[$i]==$creado_en or $campos[$i]==$actualizado_en) $j++;
				}
				$atributo_tiempo='';
				$valor_tiempo='';
				if($this->registroTiempo==true and $j==2){
					$atributo_tiempo=','.$creado_en.','.$actualizado_en;
					$valor_tiempo=','."'".$this->obtenerFechaHoraActual($this->zonaHoraria)."'".','."'".$this->obtenerFechaHoraActual($this->zonaHoraria)."'";
				}
				$atributos=substr($atributos,0,-1).$atributo_tiempo;
				$datos=substr($datos,0,-1).$valor_tiempo;
					return $this->procesarConsultaSQL('insert into '.$this->_tabla.' ('.$atributos.') values ('.$datos.')');
			}
		}
		public function encontrar($valor='',$llavePrimaria='id'){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				$registroTiempo=true;
				$zonaHoraria='UTC';
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				if(get_class_vars($clase[count($clase)-1])['llavePrimaria']!='id') $llavePrimaria=get_class_vars($clase[count($clase)-1])['llavePrimaria'];
				if(get_class_vars($clase[count($clase)-1])['registroTiempo']==false) $registroTiempo=false;
				if(get_class_vars($clase[count($clase)-1])['zonaHoraria']!='UTC') $zonaHoraria=get_class_vars($clase[count($clase)-1])['zonaHoraria'];
				$pipe=PIPE::tabla($tabla);
				$pipe->tabla=$tabla;
				$pipe->llavePrimaria=$llavePrimaria;
				$pipe->registroTiempo=$registroTiempo;
				$pipe->zonaHoraria=$zonaHoraria;
			}
			if(is_string($valor) and strlen($valor)>0) $valor="'".$valor."'";
			$consulta=Conexion::$cnx->query('select * from '.$pipe->_tabla.' where '.$llavePrimaria.'='.$valor);
			if($consulta){
				$pipe->_llavePrimaria37812_=$llavePrimaria;
				$pipe->_valor37812_=$valor;
				$datosArreglo=$consulta->fetch();
				if(empty($datosArreglo)) exit('No existe registro cuyo valor de la llave primaria <b>'.$llavePrimaria.'</b> sea <b>'.$valor.'</b>');
				$campos=$pipe->obtenerCamposTabla();
				$cantCampos=count($campos);
				for($j=0; $j<$cantCampos; $j++){
					//Creamos los atributos de los campos de la base de datos en el objeto $pipe.
					$atributo=$campos[$j];
					$valor=$datosArreglo[$atributo];
					if(is_numeric($valor)) $valor=intval($valor);
					$pipe->$atributo=$valor;
				}
				return $pipe;
			}
			else{
				$pipe->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
			}
		}
		public function actualizar($valores=''){
			$actualizado_en='actualizado_en';
			if(BD_CONTROLADOR=='oci') $actualizado_en=strtoupper($actualizado_en);
			$campos=$this->obtenerCamposTabla();
			$cantCampos=count($campos);
			if($valores==''){
				$consulta=Conexion::$cnx->query('select * from '.$this->_tabla.' where '.$this->_llavePrimaria37812_.'='.$this->_valor37812_);
				if($consulta){
					$j=0;
					for($i=0; $i<$cantCampos; $i++){
						$atributo=$campos[$i];
						if(($atributo=='creado_en' or $atributo=='CREADO_EN' or $atributo==$actualizado_en) and empty($this->$atributo)){
							$valores=$valores.$atributo."=null,";
						}
						else{
							if(is_string($this->$atributo)) $this->$atributo="'".$this->$atributo."'";
							$valores=$valores.$atributo.'='.$this->$atributo.',';
						}
						if($this->registroTiempo==true and $atributo==$actualizado_en) $j=1;
					}
					$valores=substr($valores,0,-1);
					$resultado=$this->procesarConsultaSQL('update '.$this->_tabla.' set '.$valores.' where '.$this->_llavePrimaria37812_.'='.$this->_valor37812_);
					if($resultado>0 and $this->registroTiempo==true and $j==1) $this->procesarConsultaSQL('update '.$this->_tabla.' set '.$actualizado_en."='".$this->obtenerFechaHoraActual($this->zonaHoraria)."' where ".$this->_llavePrimaria37812_.'='.$this->_valor37812_);
						return $resultado;
				}
				else{
					$this->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
				}
			}
			else{
				if(is_array($this->_datos)){
					$consulta=Conexion::$cnx->prepare('select * from '.$this->_tabla.' '.$this->_condiciones);
					if(!$consulta->execute($this->_datos)) $this->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
				}
				else{
					$consulta=Conexion::$cnx->query('select * from '.$this->_tabla.' '.$this->_condiciones);
					if(!$consulta) $this->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
				}
				$datos='';
				foreach($valores as $campo=>$valor){
					if(is_string($valor)) $valor="'".$valor."'";
					$datos=$datos.$campo.'='.$valor.',';
				}
				$j=0;
				for($i=0; $i<$cantCampos; $i++){
					if($this->registroTiempo==true and $campos[$i]==$actualizado_en) $j=1;
				}
				$datos=substr($datos,0,-1);
				$resultado=$this->procesarConsultaSQL('update '.$this->_tabla.' set '.$datos.' '.$this->_condiciones,$this->_datos);
				if($resultado>0 and $this->registroTiempo==true and $j==1) $this->procesarConsultaSQL('update '.$this->_tabla.' set '.$actualizado_en."='".$this->obtenerFechaHoraActual($this->zonaHoraria)."' ".$this->_condiciones,$this->_datos);
					return $resultado;
			}
		}
		public function eliminar(){
			if(empty($this->_condiciones) and !isset($this->_llavePrimaria37812_) and !isset($this->_valor37812_)){
				return $this->procesarConsultaSQL('delete from '.$this->_tabla);
			}
			else if(empty($this->_condiciones)){
				return $this->procesarConsultaSQL('delete from '.$this->_tabla.' where '.$this->_llavePrimaria37812_.'='.$this->_valor37812_);
			}
			else if(!empty($this->_condiciones)){
				return $this->procesarConsultaSQL('delete from '.$this->_tabla.' '.$this->_condiciones,$this->_datos);
			}
		}
		public function vaciar($sentencia=''){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if(BD_CONTROLADOR=='sqlite'){
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
		//Inicio autenticación de usuarios
		public function autenticar($credenciales,$tipo=PIPE::OBJETO){
			$clase=explode('\\',get_called_class());
			if($clase[count($clase)-1]=='PIPE'){
				$pipe=$this;
				$tabla=$this->_tabla;
			}
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				$pipe=PIPE::tabla($tabla);
			}
			$condicion='';
			$valores=[];
			$i=0;
			foreach($credenciales as $campo=>$valor){
				$condicion=$condicion.$campo.'=? and ';
				$valores[$i]=$valor;
				$i++;
			}
			$condicion=substr($condicion,0,-5);
			$autenticado=$pipe->procesarConsultaSQL('select * from '.$tabla.' where '.$condicion,$valores,$tipo);
			if($autenticado) return $autenticado[0];
			if(!$autenticado) return false;
		}
		//Fin autenticación de usuarios
		public static function consulta($consulta,$datos='',$tipo=PIPE::OBJETO){	
			$clase=explode('\\',get_called_class());
			$tabla=null;
			if($clase[count($clase)-1]!='PIPE') $tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
			$datosTabla=array(
				'distinto'=>'',
				'campos'=>'',
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
			$pipe=new PIPE($datosTabla);
				return $pipe->procesarConsultaSQL($consulta,$datos,$tipo,false);
		}			
		public static function consultaNativa($consulta,$datos='',$tipo=PIPE::OBJETO){
			$clase=explode('\\',get_called_class());
			$tabla=null;
			if($clase[count($clase)-1]!='PIPE') $tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
			$datosTabla=array(
				'distinto'=>'',
				'campos'=>'',
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
			$pipe=new PIPE($datosTabla);
				return $pipe->procesarConsultaSQL($consulta,$datos,$tipo);
		}
		//Inicio métodos privados.
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
		private function obtenerDatosConsultaSQL($tipo=PIPE::OBJETO,$consultaUsuario='',$datos=''){
			if($consultaUsuario=='') $consultaUsuario='select '.$this->_distinto.' '.$this->_campos.' from '.$this->_tabla.' '.$this->_unir.' '.$this->_unirDerecha.' '.$this->_unirIzquierda.' '.$this->_condiciones.' '.$this->_agrupar.' '.$this->_teniendo.' '.$this->_ordenar.' '.$this->_limite;
			if(is_array($this->_datos)) $datos=$this->_datos;
			if(is_array($datos)){
				$consulta=Conexion::$cnx->prepare($consultaUsuario);
				if($consulta->execute($datos)) $datosArreglo=$consulta->fetchAll(\PDO::FETCH_ASSOC);
				if(!$consulta->execute($datos)) $this->mostrarErrorSQL($consulta->errorInfo()[1],$consulta->errorInfo()[2]);
			}
			else{
				if($datos==PIPE::OBJETO) $tipo=$datos;
				if($datos==PIPE::ARREGLO) $tipo=$datos;
				if($datos==PIPE::JSON) $tipo=$datos;
				$consulta=Conexion::$cnx->query($consultaUsuario);
				if($consulta) $datosArreglo=$consulta->fetchAll(\PDO::FETCH_ASSOC);
				if(!$consulta) $this->mostrarErrorSQL(Conexion::$cnx->errorInfo()[1],Conexion::$cnx->errorInfo()[2]);
			}
			$campos=$this->obtenerCamposConsultaSQL($datosArreglo);
			$cantDatosArreglo=count($datosArreglo);
			if($cantDatosArreglo!=0 and count($campos)!=$consulta->columnCount()) exit('Error: ambiguedad de campos en la consulta SQL. Verifique la pertenencia de los campos a su respectiva tabla y asigne un alias a cada campo donde el nombre sea igual en otra tabla.');
			$datosConsulta=[];
			for($i=0; $i<$cantDatosArreglo; $i++){
				if($tipo==PIPE::OBJETO) $registro=new \stdClass();
				if($tipo==PIPE::ARREGLO or $tipo==PIPE::JSON) $registro=[];
				for($j=0; $j<$consulta->columnCount(); $j++){
					$atributo=$campos[$j];
					$valor=$datosArreglo[$i][$atributo];
					if($tipo==PIPE::OBJETO) $registro->$atributo=$valor;
					if($tipo==PIPE::ARREGLO or $tipo==PIPE::JSON) $registro[$atributo]=$valor;
				}
				if($tipo==PIPE::JSON) $registro=json_encode($registro);
				$datosConsulta[$i]=$registro;
			}
			return $datosConsulta;
		}
		private function obtenerCamposConsultaSQL($datosArreglo){
			$campos=null;
			if(!empty($datosArreglo)) $campos=array_keys($datosArreglo[0]);
			return $campos;
		}
		private function obtenerCamposTabla(){
			switch(BD_CONTROLADOR){
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
			$i=0;
			$campos=[];
			foreach($consulta->fetchAll() as $datos){
				$campos[$i]=$datos[$atributo];
				$i++;
			}
			return $campos;
		}
		private function procesarConsultaSQL($consulta,$datos='',$tipo=PIPE::OBJETO,$nativa=true){
			if($nativa==false) $consulta=$this->traducirConsultaSQL($consulta);
			if((strpos($consulta,'select')>-1 and strpos($consulta,'from')>-1) and (strpos($consulta,'select')<strpos($consulta,'from'))){
				return $this->obtenerDatosConsultaSQL($tipo,$consulta,$datos);
			}
			else{
				if(is_array($datos)){
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
		private function remplazarPrimeraCadena($viejo,$nuevo,$cadena,$sensible=true){
			if($sensible==true){
				if(strpos($cadena,$viejo)==true) $cadena=substr_replace($cadena,$nuevo,strpos($cadena,$viejo),strlen($viejo));
			}
			else if($sensible==false){
				if(stripos($cadena,$viejo)==true) $cadena=substr_replace($cadena,$nuevo,stripos($cadena,$viejo),strlen($viejo));
			}
			//$cadena=preg_replace('/'.preg_quote($viejo,'/').'/',$nuevo,$cadena,1);
			return $cadena;
		}
		private function remplazarCadenaIndependiente($viejo,$nuevo,$cadena,$sensible=true){
			if($sensible==true){
				while(strpos($cadena,$viejo)>-1){
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
			}
			else if($sensible==false){
				while(stripos($cadena,$viejo)>-1){
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
			}
			/*
			Volvemos a poner los *# por los catacteres $viejo
			Volvemos a poner los *#*# por los catacteres $nuevo.
			*/
			$cadena=str_replace('*#*#',$nuevo,$cadena);
			$cadena=str_replace('*#',$viejo,$cadena);
			return $cadena;
		}
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
			$consulta=str_ireplace('contar','count',$consulta);
			$consulta=str_ireplace('concatenar','concat',$consulta);
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
		private function mostrarErrorSQL($codigoError,$infoError){
			exit('
			<div style="background-color:pink; padding:10px; border:1px solid maroon; border-radius:5px; margin-bottom:10px;">
				<b>Error de SQL | Espa&ntilde;ol</b>
				<hr style="border:1px solid red;">
				#'.$codigoError.' - '.$this->traducirErrorSQL(' '.$infoError).'
			</div>
			<div style="background-color:#f1948a; padding:10px; border:1px solid maroon; border-radius:5px;">
				<b>SQL Error | English</b>
				<hr style="border:1px solid red;">
				#'.$codigoError.' - '.$infoError.'
			</div>');
		}
		private function obtenerFechaHoraActual($zonaHoraria){
			date_default_timezone_set($zonaHoraria);
			$tiempo=date('Y-m-d H:i:s');
			if(BD_CONTROLADOR=='oci') $tiempo=date('d-m-Y h:i:s');
			return $tiempo;
		}
		//Fin métodos privados.
	}