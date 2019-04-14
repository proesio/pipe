<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 27-01-2019
 * Versión: 1.0
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
   
 * Traducción de la licencia MIT
   
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
	class PIPE{
		private $cnx;
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
		protected $tabla=null;
		protected $llavePrimaria='id';
		protected $registroTiempo=true;
		protected $zonaHoraria='UTC';
		public function __construct($datosTabla){
			$this->cnx=$this->conexion();
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$tabla="$pipe->_tabla as $alias";
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
		public function todo($tipo='objeto'){
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			return $pipe->obtenerDatosConsulta($tipo);
		}		
		public function distinto(){
			$clase=explode("\\",get_called_class());
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$campos=is_array($campos) ? $campos : func_get_args();
			$_campos="";
			foreach($campos as $campo){
				$_campos=$_campos.$campo.",";
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union="=";
			}		
			$union=$pipe->_unir." inner join $tablaUnion on $llaveForanea $union $llavePrimaria";
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union="=";
			}
			$union=$pipe->_unir." right join $tablaUnion on $llaveForanea $union $llavePrimaria";
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($llavePrimaria==''){
				$llavePrimaria=$union;
				$union="=";
			}
			$union=$pipe->_unir." left join $tablaUnion on $llaveForanea $union $llavePrimaria";
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
			$clase=explode("\\",get_called_class());
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
			if($datos==''){
				$condicion=$pipe->traducirConsultaSQL("where $condicion");
			}
			else{
				$condicion=$pipe->traducirConsultaSQL($condicion);
				$i=0;
				while(strpos($condicion,'?')>-1){
					$I=$pipe->validarCadenaIndependiente('?',$condicion,'I');
					$F=$pipe->validarCadenaIndependiente('?',$condicion,'F');
					if($I=='%' or $F=='%') $datos[$i]="$datos[$i]";
					if(is_string($datos[$i]) and ($I!='%' and $F!='%')) $datos[$i]="'$datos[$i]'";
					if(!is_string($datos[$i])) $datos[$i]="$datos[$i]";
					$condicion=$pipe->remplazarPrimeraCadena('?',$datos[$i],$condicion);
					$i++;
				}
				$condicion="where $condicion";
			}
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
				'limite'=>$pipe->_limite
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$grupo=$pipe->traducirConsultaSQL("group by $grupo");
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$condicion=$pipe->traducirConsultaSQL("having $condicion");
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$ordenar=$pipe->traducirConsultaSQL("order by $ordenar $tipo");
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
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$limite="limit $inicio";
			if($final!='') $limite="limit $inicio,$final";		
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
		public function primero($limite=1,$tipo='objeto'){
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			if($limite==='objeto' or $limite==='arreglo'){
				$tipo=$limite;
				$limite="limit 1";
			}
			else{
				$limite=is_numeric($limite) ? "limit 0,$limite" : "";
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
				'ordenar'=>$pipe->_ordenar,
				'limite'=>$limite
			);
			$pipe=new PIPE($datosTabla);
			return $pipe->obtenerDatosConsulta($tipo);
		}
		public function obtener($tipo='objeto'){
			return $this->obtenerDatosConsulta($tipo);
		}
		//Fin palabras reservadas de una consulta sql.
		//Inicio instrucciones insertar, actualizar, eliminar y vaciar.
		public static function prepararInsercion(){
			$clase=explode("\\",get_called_class());
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
		}
		public function insertar($valores=''){
			$consulta=$this->cnx->query("select * from $this->_tabla");
			$nombreCampos=mysqli_fetch_fields($consulta);
			if($valores==''){
				$atributos="";
				$valores="";
				if($this->registroTiempo==true){
					$this->creado_en=$this->obtenerFechaHoraActual($this->zonaHoraria);
					$this->actualizado_en=$this->obtenerFechaHoraActual($this->zonaHoraria);
				}
				else{
					$this->creado_en="0000-00-00 00:00:00";
					$this->actualizado_en="0000-00-00 00:00:00";
				}
				foreach($nombreCampos as $nombreCampo){					
					$atributo=$nombreCampo->name;
					if($atributo=='');
					$atributos=$atributos.$atributo.",";
					if(is_string($this->$atributo)) $this->$atributo="'".$this->$atributo."'";
					if(isset($this->$atributo)) $valores=$valores.$this->$atributo.",";
				}
				$atributos=substr($atributos,0,-1);
				$valores=substr($valores,0,-1);
				$this->cnx->query("insert into $this->_tabla ($atributos) values ($valores)");
			}
			else{
				$atributos='';
				$datos='';
				foreach($valores as $campo=>$valor){
					$atributos=$atributos.$campo.",";
					$datos=$datos."'$valor',";
				}
				$i=0;
				foreach($nombreCampos as $nombreCampo){	
					if($nombreCampo->name=='creado_en' or $nombreCampo->name=='actualizado_en') $i++;
				}
				$atributos=substr($atributos,0,-1);
				$datos=substr($datos,0,-1);
				if($this->registroTiempo==true and $i==2) $atributos=$atributos.",creado_en,actualizado_en";
				if($this->registroTiempo==true and $i==2) $datos=$datos.",'".$this->obtenerFechaHoraActual($this->zonaHoraria)."','".$this->obtenerFechaHoraActual($this->zonaHoraria)."'";
				$this->cnx->query("insert into $this->_tabla ($atributos) values ($datos)");
			}
			if(mysqli_affected_rows($this->cnx)==-1){
				$this->mostrarErrorMysql();
			}
			else{
				return mysqli_affected_rows($this->cnx);
			}
		}
		public function encontrar($valor='',$llavePrimaria='id'){
			$clase=explode("\\",get_called_class());
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
			$consulta=$pipe->cnx->query("select * from $pipe->_tabla where $llavePrimaria='$valor'");
			$datos=mysqli_fetch_array($consulta);
			$nombreCampos=mysqli_fetch_fields($consulta);
			$pipe->_llavePrimaria37812_=$llavePrimaria;
			$pipe->_valor37812_=$valor;
			for($i=0; $i<count($nombreCampos); $i++){
				//Creamos los atributos de los campos de la base de datos en el objeto $pipe.
				$atributo=$nombreCampos[$i]->name;
				$pipe->$atributo=$datos[$i];
			}
			if(mysqli_affected_rows($pipe->cnx)==-1){
				$pipe->mostrarErrorMysql();
			}
			else{
				return $pipe;
			}
		}
		public function actualizar($valores=''){
			if($valores==''){
				$consulta=$this->cnx->query("select * from $this->_tabla where $this->_llavePrimaria37812_='$this->_valor37812_'");
				$nombreCampos=mysqli_fetch_fields($consulta);
				$i=0;
				foreach($nombreCampos as $nombreCampo){
					if($this->registroTiempo==true and $nombreCampo->name=='actualizado_en') $i=1;
					$atributo=$nombreCampo->name;
					$valores=$valores."$atributo='".$this->$atributo."',";
				}
				$valores=substr($valores,0,-1);
				$this->cnx->query("update $this->_tabla set $valores where $this->_llavePrimaria37812_='$this->_valor37812_'");
				if(mysqli_affected_rows($this->cnx)==1 and $this->registroTiempo==true and $i==1) $this->cnx->query("update $this->_tabla set actualizado_en='".$this->obtenerFechaHoraActual($this->zonaHoraria)."' where $this->_llavePrimaria37812_='$this->_valor37812_'");
			}
			else{
				$consulta=$this->cnx->query("select * from $this->_tabla $this->_condiciones");
				$nombreCampos=mysqli_fetch_fields($consulta);
				$datos='';
				foreach($valores as $campo=>$valor){
					$datos=$datos."$campo='$valor',";
				}
				$i=0;
				foreach($nombreCampos as $nombreCampo){	
					if($this->registroTiempo==true and $nombreCampo->name=='actualizado_en') $i=1;
				}
				$datos=substr($datos,0,-1);
				$this->cnx->query("update $this->_tabla set $datos $this->_condiciones");
				if(mysqli_affected_rows($this->cnx)>0 and $this->registroTiempo==true and $i==1) $this->cnx->query("update $this->_tabla set actualizado_en='".$this->obtenerFechaHoraActual($this->zonaHoraria)."' $this->_condiciones");
			}
			if(mysqli_affected_rows($this->cnx)==-1){
				$this->mostrarErrorMysql();
			}
			else{
				return mysqli_affected_rows($this->cnx);
			}
		}
		public function eliminar(){
			if(empty($this->_condiciones)) $this->cnx->query("delete from $this->_tabla where $this->_llavePrimaria37812_='$this->_valor37812_'");
			if(!empty($this->_condiciones)) $this->cnx->query("delete from $this->_tabla $this->_condiciones");
			if(mysqli_affected_rows($this->cnx)==-1){
				$this->mostrarErrorMysql();
			}
			else{
				return mysqli_affected_rows($this->cnx);
			}
		}
		public function vaciar(){
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE') $pipe=$this;
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				if(get_class_vars($clase[count($clase)-1])['tabla']!=null) $tabla=get_class_vars($clase[count($clase)-1])['tabla'];
				$pipe=PIPE::tabla($tabla);
			}
			$pipe->cnx->query("truncate table $pipe->_tabla");
			if(mysqli_affected_rows($pipe->cnx)==-1){
				$pipe->mostrarErrorMysql();
			}
			else{
				return mysqli_affected_rows($pipe->cnx);
			}
		}
		//Fin instrucciones insertar, actualizar, eliminar y vaciar.
		//Inicio autenticación de usuarios
		public function autenticar($credenciales,$tipo='objeto'){
			$clase=explode("\\",get_called_class());
			if($clase[count($clase)-1]=='PIPE'){
				$pipe=$this;
				$tabla=$this->_tabla;
			}
			if($clase[count($clase)-1]!='PIPE'){
				$tabla=PIPE::convertirModeloTabla($clase[count($clase)-1]);
				$pipe=PIPE::tabla($tabla);
			}
			$condicion='';		
			foreach($credenciales as $campo=>$valor){
				$valor=mysqli_real_escape_string($pipe->cnx,$valor);
				$condicion=$condicion."$campo='$valor' and ";
			}
			$condicion="where ".substr($condicion,0,-5);
			$datosTabla=array(
				'distinto'=>'',
				'campos'=>'*',
				'tabla'=>$tabla,
				'unir'=>'',
				'unirDerecha'=>'',
				'unirIzquierda'=>'',
				'condiciones'=>$condicion,
				'agrupar'=>'',
				'teniendo'=>'',
				'ordenar'=>'',
				'limite'=>''
			);
			$pipe=new PIPE($datosTabla);
			return $pipe->obtenerDatosConsulta($tipo);
		}
		//Fin autenticación de usuarios
		public static function consulta($consulta,$tipo='objeto'){	
			$clase=explode("\\",get_called_class());
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
			$consulta=$pipe->traducirConsultaSQL($consulta);
			if((strpos($consulta,'insert')>-1 and strpos($consulta,'into')>-1 and strpos($consulta,'values')>-1) and (strpos($consulta,'insert')<strpos($consulta,'into') and strpos($consulta,'into')<strpos($consulta,'values'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else if((strpos($consulta,'update')>-1 and strpos($consulta,'set')>-1) and (strpos($consulta,'update')<strpos($consulta,'set'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else if((strpos($consulta,'delete')>-1 and strpos($consulta,'from')>-1) and (strpos($consulta,'delete')<strpos($consulta,'from'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else{
				return $pipe->obtenerDatosConsulta($tipo,$consulta);
			}
		}			
		public static function consultaNativa($consulta,$tipo='objeto'){
			$clase=explode("\\",get_called_class());
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
			if((stripos($consulta,'insert')>-1 and stripos($consulta,'into')>-1 and stripos($consulta,'values')>-1) and (stripos($consulta,'insert')<stripos($consulta,'into') and stripos($consulta,'into')<stripos($consulta,'values'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else if((stripos($consulta,'update')>-1 and stripos($consulta,'set')>-1) and (stripos($consulta,'update')<stripos($consulta,'set'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else if((stripos($consulta,'delete')>-1 and stripos($consulta,'from')>-1) and (stripos($consulta,'delete')<stripos($consulta,'from'))){
				$pipe->cnx->query($consulta);
				if(mysqli_affected_rows($pipe->cnx)==-1){
					$pipe->mostrarErrorMysql();
				}
				else{
					return mysqli_affected_rows($pipe->cnx);
				}
			}
			else{
				return $pipe->obtenerDatosConsulta($tipo,$consulta);
			}
		}
		//Inicio métodos privados.
		private function conexion(){
			return new \mysqli(BD_HOST,BD_USUARIO,BD_CONTRASENA,BD_BASEDATOS);
		}
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
						$remplazar[$i]="_$letra";
						$i++;							
					}
				}
			}
			return strtolower(substr(str_replace($buscar,$remplazar,$modelo),1)."s");
		}
		private function obtenerDatosConsulta($tipo='objeto',$consult=''){
			$registro=null;
			if($tipo=='arreglo') $registro=[];
			if($consult=='') $consult="select $this->_distinto $this->_campos from $this->_tabla $this->_unir $this->_unirDerecha $this->_unirIzquierda $this->_condiciones $this->_agrupar $this->_teniendo $this->_ordenar $this->_limite";
			$consulta=$this->cnx->query($consult);
			@$NF=mysqli_num_rows($consulta);
			@$campos=mysqli_fetch_fields($consulta);
			$datos=[];
			for($i=0; $i<$NF; $i++){
				$datosArreglo=mysqli_fetch_array($consulta);
				if($tipo=='objeto') $registro=new \stdClass();
				for($j=0; $j<count($campos); $j++){
					$atributo=$campos[$j]->name;
					if($tipo=='objeto') $registro->$atributo=$datosArreglo[$j];
					if($tipo=='arreglo') $registro[$atributo]=$datosArreglo[$j];
				}
				$datos[$i]=$registro;
			}
			if(mysqli_affected_rows($this->cnx)==-1){
				$this->mostrarErrorMysql();
			}
			else{
				mysqli_close($this->cnx);
				return $datos;
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
				if(trim($I)=="" and trim($F)==""){
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
					if($I!="" or $F!=""){
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
					if($I!="" or $F!=""){
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
			$consulta=" $consulta ";
			$consulta=str_ireplace('seleccionar',' seleccionar ',$consulta);
			$palabras=explode(' ',$consulta);
			for($i=0; $i<count($palabras); $i++){
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
			for($i=0; $i<count($partesTraducido); $i++){
				if(strpos($consultaTraducida,"'".$partesTraducido[$i])."'">-1) $consultaTraducida=str_replace("'".$partesTraducido[$i]."'",$partesUsuario[$i],$consultaTraducida);
				if(strpos($consultaTraducida,'"'.$partesTraducido[$i]).'"'>-1) $consultaTraducida=str_replace('"'.$partesTraducido[$i].'"',$partesUsuario[$i],$consultaTraducida);
			}
			return $consultaTraducida;
		}
		private function traducirErrorMysql($error){
			$error=$this->remplazarCadenaIndependiente(
			"Column count doesn't match value count at row",
			'El conteo de columnas no coincide con el conteo de valores en la fila',
			$error);
			$error=$this->remplazarCadenaIndependiente(
			"is specified twice, both as a target for 'UPDATE' and as a separate source for data",
			"se especifica dos veces, como objetivo para 'ACTUALIZAR' y como fuente separada para datos",
			$error);
			$error=str_replace('field list','la lista de campos de la tabla '.$this->_tabla,$error);
			$error=str_replace('clause','cláusula',$error);
			$error=$this->remplazarCadenaIndependiente('Unknown column','columna desconocida',$error);
			$error=$this->remplazarCadenaIndependiente('unknown','desconocido',$error);
			$error=$this->remplazarCadenaIndependiente('Column','la columna',$error);
			$error=$this->remplazarCadenaIndependiente('column','la columna',$error);
			$error=$this->remplazarCadenaIndependiente('in','en',$error);
			$error=$this->remplazarCadenaIndependiente('is','es',$error);
			$error=$this->remplazarCadenaIndependiente('Table','la tabla',$error);
			$error=$this->remplazarCadenaIndependiente('table','la tabla',$error);
			$error=$this->remplazarCadenaIndependiente("doesn't exist",'no existe',$error);
			$error=$this->remplazarCadenaIndependiente("does not exist",'no existe',$error);
			$error=$this->remplazarCadenaIndependiente('ambiguous','ambigua',$error);	
			$error=$this->remplazarCadenaIndependiente('at line','en la línea',$error);	
			$error=$this->remplazarCadenaIndependiente('Duplicate entry','entrada duplicada',$error);		
			$error=$this->remplazarCadenaIndependiente('Not unique table/alias:','Tabla/Alias no únicos:',$error);	
			$error=$this->remplazarCadenaIndependiente('for key','para la llave',$error);	
			$error=$this->remplazarCadenaIndependiente('FUNCTION','FUNCIÓN',$error);	
			$error=$this->remplazarCadenaIndependiente('Undeclared variable:','Variable no declarada:',$error);	
			$error=$this->remplazarCadenaIndependiente(
			'You have an error en your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near',
			'tienes un error en tu sintaxis sql; consulte el manual que corresponde a la versión de su servidor MariaDB para conocer la sintaxis correcta para usar cerca de',
			$error);
			$error=$this->remplazarCadenaIndependiente(
			'Cannot delete or update a parent row: a foreign key constraint fails',
			'No se puede actualizar el valor de una llave primaria ni eliminar el registro donde el campo primario este ligado a una llave foránea',
			$error);
			$error=$this->remplazarCadenaIndependiente(
			'Cannot add or update a child row: a foreign key constraint fails',
			'No se puede agregar o actualizar una fila secundaria: error en la llave foránea',
			$error);
			$error=$this->remplazarCadenaIndependiente('Query was empty','La consulta esta vacía',$error);
			return ucfirst(trim($error));
		}
		private function mostrarErrorMysql(){
			echo '
			<div style="background-color:pink; padding:10px; border:1px solid maroon; border-radius:5px; margin-bottom:10px;">
				<b>Error de MySQL | Espa&ntilde;ol</b>
				<hr style="border:1px solid red;">
				#'.mysqli_errno($this->cnx)." - ".$this->traducirErrorMysql(" ".mysqli_error($this->cnx)).'
			</div>
			<div style="background-color:#f1948a; padding:10px; border:1px solid maroon; border-radius:5px;">
				<b>MySQL Error | English</b>
				<hr style="border:1px solid red;">
				#'.mysqli_errno($this->cnx).' - '.mysqli_error($this->cnx).'
			</div>';
			mysqli_close($this->cnx);
		}
		private function obtenerFechaHoraActual($zonaHoraria){
			date_default_timezone_set($zonaHoraria);
			return date('Y-m-d H:i:s');
		}
		//Fin métodos privados.
	}