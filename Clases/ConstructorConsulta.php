<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 27-08-2020
 * Versión: 4.3.2
 * Sitio web: https://pipe.proes.tk
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

use PIPE\Rasgos\Encadenable;

class ConstructorConsulta{
    
    use Encadenable;
    
    /*
     * Palabra reservada distinct.
     *
     * @tipo string
     */
    private $_distinto = '';
    
    /*
     * Campos seleccionados en la consulta SQL.
     *
     * @tipo string
     */
    private $_campos = '*';
    
    /*
     * Nombre de la tabla en la base de datos.
     *
     * @tipo string
     */
    private $_tabla = '';
    
    /*
     * Uniones con la cláusula inner join.
     *
     * @tipo string
     */
    private $_unir = '';
    
    /*
     * Uniones con la cláusula right join.
     *
     * @tipo string
     */
    private $_unirDerecha = '';
    
    /*
     * Uniones con la cláusula left join.
     *
     * @tipo string
     */
    private $_unirIzquierda = '';
    
    /*
     * Condiciones con la cláusula where.
     *
     * @tipo string
     */
    private $_condiciones = '';
    
    /*
     * Agrupaciones con la cláusula group by.
     *
     * @tipo string
     */
    private $_agrupar = '';
    
    /*
     * Condiciones con la cláusula having.
     *
     * @tipo string
     */
    private $_teniendo = '';
    
    /*
     * Ordenamiento de registros con la cláusula order by.
     *
     * @tipo string
     */
    private $_ordenar = '';
    
    /*
     * Limitación de registros con la cláusula limit.
     *
     * @tipo string
     */
    private $_limite = '';
    
    /*
     * Valores de la consulta SQL para ejecutar consultas preparadas.
     *
     * @tipo array
     */
    private $_datos = [];
    
    /*
     * Datos relacionados con el modelo(s) establecido.
     *
     * @tipo array
     */
    private $_datosModeloRelacion = [];
    
    /*
     * Nombre de la clase que extiende del Modelo.
     *
     * @tipo string
     */
    private $clase = '';
    
    /*
     * Llave primaria de la tabla en representación de un modelo.
     *
     * @tipo string
     */
    private $llavePrimaria = 'id';
    
    /*
     * Indica si se almacena el registro del tiempo en los campos especificados.
     *
     * @tipo boolean
     */
    private $registroTiempo = true;
    
    /*
     * Nombre del campo donde se registra el tiempo de la creación del registro.
     *
     * @tipo string
     */
    private $creadoEn = 'creado_en';
    
    /*
     * Nombre del campo donde se registra el tiempo de la actualización del registro.
     *
     * @tipo string
     */
    private $actualizadoEn = 'actualizado_en';
    
    /*
     * Indica que el modelo tiene una relación de Uno a Uno.
     *
     * @tipo array
     */
    private $tieneUno = [];
    
    /*
     * Indica que el modelo tiene una relación de Uno a Muchos.
     *
     * @tipo array
     */
    private $tieneMuchos = [];
    
    /*
     * Indica la relación inversa de las relaciones Uno a Uno y Uno a Muchos.
     *
     * @tipo array
     */
    private $perteneceAUno = [];
    
    /*
     * Indica que el modelo tiene una relación de Muchos a Muchos.
     *
     * @tipo array
     */
    private $perteneceAMuchos = [];
    
    /*
     * Indica los campos que pueden ser insertados.
     *
     * @tipo array
     */
    private $insertables = [];
    
    /*
     * Indica los campos que pueden ser actualizados.
     *
     * @tipo array
     */
    private $actualizables = [];
    
    /*
     * Indica los campos que se mostrarán en la consulta SQL.
     *
     * @tipo array
     */
    private $visibles = [];
    
    /*
     * Indica los campos que no se mostrarán en la consulta SQL.
     *
     * @tipo array
     */
    private $ocultos = [];
    
    /*
     * Indica el retorno de resultados de una consulta SQL como un objeto.
     *
     * @tipo string
     */
    const OBJETO = 'objeto';
    
    /*
     * Indica el retorno de resultados de una consulta SQL como un arreglo.
     *
     * @tipo string
     */
    const ARREGLO = 'arreglo';
    
    /*
     * Indica el retorno de resultados de una consulta SQL como una cadena de json.
     *
     * @tipo string
     */
    const JSON = 'json';
    
    /*
     * Indica el retorno de la consulta SQL generada.
     *
     * @tipo string
     */
    const SQL = 'sql';
    
    /*
     * Crea una nueva instancia de la clase ConstructorConsulta.
     *
     * @parametro array $atributosClase
     * @retorno void
     */
    public function __construct($atributosClase = []){
        $this->_tabla = $atributosClase['tabla'] ?? $this->_tabla;
        $this->clase = $atributosClase['clase'] ?? $this->clase;
        $this->llavePrimaria = $atributosClase['llavePrimaria'] ?? $this->llavePrimaria;
        $this->registroTiempo = $atributosClase['registroTiempo'] ?? $this->registroTiempo;
        $this->creadoEn = $atributosClase['creadoEn'] ?? $this->creadoEn;
        $this->actualizadoEn = $atributosClase['actualizadoEn'] ?? $this->actualizadoEn;
        $this->tieneUno = $atributosClase['tieneUno'] ?? $this->tieneUno;
        $this->tieneMuchos = $atributosClase['tieneMuchos'] ?? $this->tieneMuchos;
        $this->perteneceAUno = $atributosClase['perteneceAUno'] ?? $this->perteneceAUno;
        $this->perteneceAMuchos = $atributosClase['perteneceAMuchos'] ?? $this->perteneceAMuchos;
        $this->insertables = $atributosClase['insertables'] ?? $this->insertables;
        $this->actualizables = $atributosClase['actualizables'] ?? $this->actualizables;
        $this->visibles = $atributosClase['visibles'] ?? $this->visibles;
        $this->ocultos = $atributosClase['ocultos'] ?? $this->ocultos;
        if(!empty($this->_tabla) && !$this->verificarTablaExiste($this->_tabla))
            Error::mostrar(Mensaje::$mensajes['TABLA_NO_EXISTE'].': '.$this->_tabla);
    }
    
    //Inicio métodos públicos.
    //Inicio palabras reservadas representadas en métodos para construir una consulta SQL.
    /*
     * Establece un alias al nombre de la tabla.
     *
     * @parametro string $alias
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function alias($alias){
        $this->_tabla = $this->_tabla.' as '.$alias;
        return $this;
    }
    
    /*
     * Obtiene todos los datos de la tabla seleccionada.
     *
     * @parametro array|string $campos
     * @parametro string $tipo
     * @retorno array|json|string
     */
    public function todo($campos = [], $tipo = self::OBJETO){
        if(is_array($campos) && !empty($campos)){
            return $this->seleccionar($campos)->obtener($tipo);
        }
        else{
            if(
                $campos == self::OBJETO
                || $campos == self::ARREGLO
                || $campos == self::JSON
                || $campos == self::SQL
            ) $tipo = $campos;
            return $this->obtener($tipo);
        }
    }
    
    /*
     * Establece los campos que serán seleccionados.
     *
     * @parametro array|mixto $campos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function seleccionar($campos = ['*']){
        $campos = is_array($campos) ? $campos : func_get_args();
        $_campos = '';
        foreach($campos as $campo){
            $_campos = $_campos.$campo.',';
        }
        $this->_campos = $this->traducirConsultaSQL(substr($_campos, 0, -1));
        return $this;
    }
    
    /*
     * Elimina duplicados del conjunto de resultados.
     *
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function distinto(){
        $this->_distinto = 'distinct';
        return $this;
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
    public function unir($tablaUnion, $llaveForanea, $union, $llavePrimaria = ''){
        if($llavePrimaria == ''){
            $llavePrimaria = $union;
            $union = '=';
        }		
        $this->_unir = $this->_unir
            .' inner join '
            .$tablaUnion
            .' on '
            .$llaveForanea.' '.$union.' '.$llavePrimaria;
        return $this;
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
    public function unirDerecha($tablaUnion, $llaveForanea, $union, $llavePrimaria = ''){
        if($llavePrimaria == ''){
            $llavePrimaria = $union;
            $union = '=';
        }
        $this->_unirDerecha = $this->_unirDerecha
            .' right join '
            .$tablaUnion
            .' on '
            .$llaveForanea.' '.$union.' '.$llavePrimaria;
        return $this;
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
    public function unirIzquierda($tablaUnion, $llaveForanea, $union, $llavePrimaria = ''){
        if($llavePrimaria == ''){
            $llavePrimaria = $union;
            $union = '=';
        }
        $this->_unirIzquierda = $this->_unirIzquierda
            .' left join '
            .$tablaUnion
            .' on '
            .$llaveForanea.' '.$union.' '.$llavePrimaria;
        return $this;
    }
    
    /*
     * Establece una condición en la consulta SQL.
     *
     * @parametro string $condicion
     * @parametro array $datos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function donde($condicion, $datos = []){
        $this->_condiciones = $this->traducirConsultaSQL('where '.$condicion);
        $this->_datos = $datos;
        return $this;
    }
    
    /*
     * Agrupa registros que tienen los mismos valores.
     *
     * @parametro string|array $grupos
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function agruparPor($grupos){
        $agrupaciones = is_array($grupos) ? implode(', ', $grupos) : $grupos;
        $grupo = $this->traducirConsultaSQL('group by '.$agrupaciones);
        $this->_agrupar = $grupo;
        return $this;
    }
    
    /*
     * Establece una condición a una función de agregación.
     *
     * @parametro string $condicion
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function teniendo($condicion){
        $this->_teniendo = $this->traducirConsultaSQL('having '.$condicion);
        return $this;
    }
    
    /*
     * Ordena el resultado de la consulta SQL.
     *
     * @parametro string|array $ordenes
     * @parametro string $tipo
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function ordenarPor($ordenes, $tipo = 'asc'){
        $ordenaciones = is_array($ordenes) ? implode(', ', $ordenes) : $ordenes;
        $orden = $this->traducirConsultaSQL('order by '.$ordenaciones.' '.$tipo);
        $this->_ordenar = $orden;
        return $this;
    }
    
    /*
     * Limita el número de registros retornados en la consulta SQL.
     *
     * @parametro int $inicio
     * @parametro int|string $cantidad
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    public function limite($inicio, $cantidad = ''){
        if(Configuracion::obtenerVariable('BD_CONTROLADOR') == 'sqlsrv')
            Error::mostrar(Mensaje::$mensajes['METODO_LIMITE_NO_SOPORTADO']);
        $limite = 'limit '.$inicio;
        if($cantidad !== '') $limite = 'limit '.$inicio.', '.$cantidad;
        $this->_limite = $limite;
        return $this;
    }
    
    /*
     * Obtiene una cantidad específca de registros retornados.
     *
     * @parametro int $inicio
     * @parametro int|string $cantidad
     * @parametro string $tipo
     * @retorno array|json
     */
    public function tomar($inicio, $cantidad = '', $tipo = self::OBJETO){
        if($cantidad == self::SQL || $tipo == self::SQL)
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        if($cantidad === ''){
            $cantidad = $inicio;
            $inicio = 0;		
        }
        else if($cantidad == self::OBJETO || $cantidad == self::ARREGLO || $cantidad == self::JSON){
            $tipo = $cantidad;
            $cantidad = $inicio;
            $inicio = 0;
        }
        $contador = 0;
        $datos = [];
        $datosConsulta = $this->obtener();
        foreach($datosConsulta as $clave => $valor){
            if($clave >= $inicio && $contador < $cantidad){
                $datos[] = $tipo == self::ARREGLO ? (array) $valor : $valor;
                $contador++;
            }
        }
        if($tipo == self::JSON) $datos = json_encode($datos);
        return $datos;
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
    public function primero($limite = 1, $tipo = self::OBJETO){
        if($limite == self::SQL || $tipo == self::SQL)
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        if($limite == self::OBJETO || $limite == self::ARREGLO || $limite == self::JSON){
            $tipo = $limite;
            $limite = 1;
        }
        return $this->tomar($limite, $tipo);
    }
    
    /*
     * Obtiene los últimos registros retornados en la consulta SQL.
     *
     * @parametro string|int $llavePrimaria
     * @parametro int|string $limite
     * @parametro string $tipo
     * @retorno array|json
     */
    public function ultimo($llavePrimaria = 'id', $limite = 1, $tipo = self::OBJETO){
        if($llavePrimaria == self::SQL || $limite == self::SQL || $tipo == self::SQL)
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        if($llavePrimaria == self::OBJETO || $llavePrimaria == self::ARREGLO || $llavePrimaria == self::JSON){
            $tipo = $llavePrimaria;
            $llavePrimaria = 'id';
        }
        else if(is_numeric($llavePrimaria)){
            if($limite == self::OBJETO || $limite == self::ARREGLO || $limite == self::JSON) $tipo = $limite;
            $limite = $llavePrimaria;
            $llavePrimaria = 'id';
        }
        else{
            if($limite == self::OBJETO || $limite == self::ARREGLO || $limite == self::JSON){
                $tipo = $limite;
                $limite = 1;
            }
        }
        if($this->llavePrimaria != 'id') $llavePrimaria = $this->llavePrimaria;
        return $this->ordenarPor($llavePrimaria, 'desc')->tomar($limite, $tipo);
    }
    
    /*
     * Obtiene la cantidad general o específica de registros retornados.
     *
     * @parametro string $campo
     * @retorno int
     */
    public function contar($campo = '*'){
        $conteo = intval(
            $this->procesarConsultaSQL(
                'select count('.$campo.') as conteo
                from '.$this->_tabla.' '
                .$this->_condiciones,
                $this->_datos
            )[0]->conteo
        );
        return $conteo;
    }
    
    /*
     * Obtiene el valor máximo del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
    public function maximo($campo){
        $maximo = $this->procesarConsultaSQL(
            'select max('.$campo.') as maximo
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_datos
        )[0]->maximo;
        return $maximo;
    }
    
    /*
     * Obtiene el valor mímino del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
    public function minimo($campo){
        $minimo = $this->procesarConsultaSQL(
            'select min('.$campo.') as minimo
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_datos
        )[0]->minimo;
        return $minimo;
    }
    
    /*
     * Obtiene el valor promedio del campo especificado.
     *
     * @parametro string $campo
     * @retorno mixto
     */
    public function promedio($campo){
        $promedio = $this->procesarConsultaSQL(
            'select avg('.$campo.') as promedio
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_datos
        )[0]->promedio;
        return $promedio;
    }
    
    /*
     * Obtiene la suma del campo especificado.
     *
     * @parametro string $campo
     * @retorno int
     */
    public function suma($campo){
        $suma = $this->procesarConsultaSQL(
            'select sum('.$campo.') as suma
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_datos
        )[0]->suma;
        return $suma;
    }
    
    /*
     * Verifica que la consulta SQL ha retornado un resultado.
     *
     * @retorno boolean
     */
    public function existe(){
        $existe = $this->obtener() ? true : false;
        return $existe;
    }
    
    /*
     * Verifica que la consulta SQL no ha retornado un resultado.
     *
     * @retorno boolean
     */
    public function noExiste(){
        $noExiste = $this->obtener() ? false : true;
        return $noExiste;
    }
    
    /*
     * Incrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $incremento
     * @retorno int
     */
    public function incrementar($campo, $incremento = 1){
        $incremento = $this->procesarConsultaSQL(
            'update '.$this->_tabla
            .' set '.$campo.'='.$campo.'+'.$incremento.' '
            .$this->_condiciones,
            $this->_datos
        );
        return $incremento;
    }
    
    /*
     * Decrementa el valor del campo especificado.
     *
     * @parametro string $campo
     * @parametro int $decremento
     * @retorno int
     */
    public function decrementar($campo, $decremento = 1){
        $decremento = $this->procesarConsultaSQL(
            'update '.$this->_tabla
            .' set '.$campo.'='.$campo.'-'.$decremento.' '
            .$this->_condiciones,
            $this->_datos
        );
        return $decremento;
    }
    
    /*
     * Obtiene una instancia del Constructor de Consultas con los datos asociados a la llave primaria.
     *
     * @parametro array|int|string $valor
     * @parametro string $llavePrimaria
     * @retorno \PIPE\Clases\ConstructorConsulta|array|null
     */
    public function encontrar($valor = [], $llavePrimaria = 'id'){
        if($this->llavePrimaria != 'id') $llavePrimaria = $this->llavePrimaria;
        if(is_array($valor) && !empty($valor)){
            $objetos = [];
            foreach($valor as $id){
                $datos = $this->donde($llavePrimaria.'=?', [$id])->obtener();
                $objeto = $this->obtenerObjetoThis($this, $datos, $llavePrimaria, $id);
                $objeto ? $objetos[] = clone $objeto : $objetos[] = null;
            }
            return $objetos;
        }
        else{
            $datos = $this->donde($llavePrimaria.'=?', [$valor])->obtener();
            $objeto = $this->obtenerObjetoThis($this, $datos, $llavePrimaria, $valor);
            return $objeto;
        }
    }
    //Fin consultas básicas por medio de métodos.
    
    //Inicio instrucciones insertar, actualizar, eliminar y vaciar.
    /*
     * Inserta un nuevo registro en la base de datos.
     *
     * @parametro array $registros
     * @retorno int
     */
    public function insertar($registros = []){
        $pipe = $this->configurarRegistroTiempo($this);
        if(is_array($registros) && !empty($registros)){
            $registros = $this->obtenerRegistrosInsertar($registros);
            $inserciones = 0;
            foreach($registros as $registro){
                $campos = $pipe->obtenerCamposInsercionP($pipe, $registro);
                $parametros = $pipe->obtenerParametrosInsercionP($pipe, $registro);
                $valores = $pipe->obtenerValoresInsercionP($pipe, $registro);
                $inserciones = $inserciones+$pipe->procesarConsultaSQL(
                    'insert into '.$pipe->_tabla
                    .' ('.$campos.') values ('.$parametros.')',
                    $valores
                );
            }
            return $inserciones;
        }
        else{
            $campos = $pipe->obtenerCamposInsercion($pipe);
            $parametros = $pipe->obtenerParametrosInsercion($pipe);
            $valores = $pipe->obtenerValoresInsercion($pipe);
            return $pipe->procesarConsultaSQL(
                'insert into '.$pipe->_tabla
                .' ('.$campos.') values ('.$parametros.')',
                $valores
            );
        }
    }
    
    /*
     * Inserta un nuevo registro en la base de datos y obtiene el último id generado.
     *
     * @parametro array $valores
     * @retorno int
     */
    public function insertarObtenerId($valores){
        $this->insertar($valores);
        return intval(Conexion::$cnx->lastInsertId());
    }
    
    /*
     * Actualiza un registro en la base de datos.
     *
     * @parametro array $valores
     * @retorno int
     */
    public function actualizar($valores = []){
        if(is_array($valores) && !empty($valores)){
            $parametros = $this->obtenerParametrosActualizacionP($this, $valores);
            if($parametros == false) return 0;
        }
        else{
            $parametros = $this->obtenerParametrosActualizacion($this);
        }
        $resultado = $this->procesarConsultaSQL(
            'update '.$this->_tabla
            .' set '.$parametros.' '
            .$this->_condiciones,
            $this->_datos
        );
        if($resultado > 0 && $this->registroTiempo == true && $this->verificarCamposRegistroTiempo($this))
            $this->procesarConsultaSQL(
                'update '.$this->_tabla
                .' set '.$this->actualizadoEn."='".$this->obtenerFechaHoraActual()
                ."' ".$this->_condiciones,
                $this->_datos
            );
        return $resultado;
    }
    
    /*
     * Actualiza o inserta un nuevo registro en la base de datos.
     *
     * @parametro array $valores
     * @parametro array $inserciones
     * @retorno int|boolean
     */
    public function actualizarOInsertar($valores, $inserciones = []){
        $condiciones = substr($this->_condiciones, 7);
        if($this->donde($condiciones, $this->_datos)->existe()){
            if(is_array($valores) && !empty($valores)) return $this->actualizar($valores);
            return false;
        }
        else{
            if(is_array($inserciones) && !empty($inserciones)) return $this->insertar($inserciones);
            return false;
        }
    }
    
    /*
     * Elimina un registro en la base de datos.
     *
     * @retorno int
     */
    public function eliminar(){
        return $this->procesarConsultaSQL('delete from '.$this->_tabla.' '.$this->_condiciones, $this->_datos);
    }
    
    /*
     * Elimina todos los registros en la tabla y reinicia el contador autoincrementable.
     *
     * @parametro string $sentencia
     * @retorno int
     */
    public function vaciar($sentencia = ''){
        if(Configuracion::obtenerVariable('BD_CONTROLADOR') == 'sqlite'){
            $consulta = Conexion::$cnx->exec('delete from '.$this->_tabla);
            $consulta1 = Conexion::$cnx->exec(
                'update sqlite_sequence set seq=0 where name='."'".$this->_tabla."'"
            );
            if($consulta === false || $consulta1 === false)
                Error::mostrar(Conexion::$cnx->errorInfo()[1].' - '.Conexion::$cnx->errorInfo()[2], true);	
            else
                return 1;
        }
        else{
            $sentencia = $this->traducirConsultaSQL($sentencia);
            if(is_string($sentencia) && $sentencia != '') Conexion::$cnx->exec($sentencia);
            $consulta = Conexion::$cnx->exec('truncate table '.$this->_tabla);
            if($consulta === false)
                Error::mostrar(Conexion::$cnx->errorInfo()[1].' - '.Conexion::$cnx->errorInfo()[2], true);
            else
                return 1;
        }
    }
    //Fin instrucciones insertar, actualizar, eliminar y vaciar.
    
    /*
     * Realiza una consulta SQL en español.
     *
     * @parametro string $consulta
     * @parametro array|string $datos
     * @parametro string $tipo
     * @retorno array|json|int
     */
    public function consulta($consulta, $datos = [], $tipo = self::OBJETO){
        return $this->procesarConsultaSQL($consulta, $datos, $tipo, false);
    }
    
    /*
     * Realiza una consulta SQL nativa.
     *
     * @parametro string $consulta
     * @parametro array|string $datos
     * @parametro string $tipo
     * @retorno array|json|int
     */
    public function consultaNativa($consulta, $datos=[], $tipo = self::OBJETO){
        return $this->procesarConsultaSQL($consulta, $datos, $tipo);
    }
    
    /*
     * Realiza una sentencia SQL.
     *
     * @parametro string $sentencia
     * @retorno int
     */
    public function sentencia($sentencia){
        $this->procesarConsultaSQL($sentencia);
        return 1;
    }
    
    /*
     * Obtiene el resultado de una consulta SQL.
     *
     * @parametro string $tipo
     * @retorno array|json|string
     */
    public function obtener($tipo = self::OBJETO){
        if($tipo == self::SQL) return $this->obtenerConsultaSQL(true);
        return $this->obtenerDatosConsultaSQL($tipo);
    }
    
    /*
     * Obtiene los datos relacionados a un modelo.
     *
     * @parametro string $tipo
     * @retorno object|array|json
     */
    public function relaciones($tipo = self::OBJETO){
        if($tipo == self::SQL) Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        switch($tipo){
            case self::OBJETO:
                return json_decode(json_encode($this->_datosModeloRelacion));
            break;
            case self::ARREGLO:
                return json_decode(json_encode($this->_datosModeloRelacion), true);
            break;
            case self::JSON:
                return json_encode($this->_datosModeloRelacion);
            break;
            default:
                Error::mostrar(Mensaje::$mensajes['TIPO_DATO_DESCONOCIDO'].': '.$tipo);
            break;
        }
    }
    
    /*
     * Prepara y obtiene los registros a insertar.
     *
     * @parametro array $registros
     * @retorno array
     */
    public function obtenerRegistrosInsertar($registros){
        foreach($registros as $clave => $valor){
            return is_string($clave) ? [$registros] : $registros;
        }
    }
    //Fin métodos públicos.
    
    //Inicio métodos privados.
    /*
     * Procesa y obtiene los datos de una consulta SQL.
     *
     * @parametro string $tipo
     * @parametro string $consultaUsuario
     * @parametro array|string $datos
     * @retorno array|json
     */
    private function obtenerDatosConsultaSQL($tipo = self::OBJETO, $consultaUsuario = '', $datos = []){
        if($tipo != self::OBJETO && $tipo != self::ARREGLO && $tipo != self::JSON)
            Error::mostrar(Mensaje::$mensajes['TIPO_DATO_DESCONOCIDO'].': '.$tipo);
        if($datos == self::OBJETO || $datos == self::ARREGLO || $datos == self::JSON) $tipo = $datos;
        if(is_array($this->_datos) && !empty($this->_datos)) $datos = $this->_datos;
        if($consultaUsuario == '') $consultaUsuario = $this->obtenerConsultaSQL();
        if(is_array($datos) && !empty($datos)){
            $consulta = Conexion::$cnx->prepare($consultaUsuario);
            $resultado = $consulta->execute($datos);
            if(!$resultado) Error::mostrar($consulta->errorInfo()[1].' - '.$consulta->errorInfo()[2], true);
        }
        else{
            $consulta = Conexion::$cnx->query($consultaUsuario);
            if(!$consulta)
                Error::mostrar(Conexion::$cnx->errorInfo()[1].' - '.Conexion::$cnx->errorInfo()[2], true);
        }
        $registros = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        $campos = $this->obtenerCamposConsultaSQL($registros);
        $conteoRegistros = count($registros);
        if($conteoRegistros != 0 && count($campos) != $consulta->columnCount())
            Error::mostrar(Mensaje::$mensajes['AMBIGUEDAD_DE_CAMPOS']);
        return $this->convertirRegistrosTipo($registros, $tipo);
    }
    
    /*
     * Obtiene la consulta SQL generada.
     *
     * @parametro boolean $traducirParametros
     * @retorno string
     */
    private function obtenerConsultaSQL($traducirParametros = false){
        $sql = 'select '.$this->_distinto
            .' '.$this->_campos
            .' from '.$this->_tabla
            .' '.$this->_unir
            .' '.$this->_unirDerecha
            .' '.$this->_unirIzquierda
            .' '.$this->_condiciones
            .' '.$this->_agrupar
            .' '.$this->_teniendo
            .' '.$this->_ordenar
            .' '.$this->_limite;
        $comandos = explode(' ', $sql);
        return $this->obtenerSQL($comandos, $traducirParametros);
    }
    
    /*
     * Obtiene el SQL a través de un arreglo de comandos.
     *
     * @parametro array $comandos
     * @parametro boolean $traducirParametros
     * @retorno string
     */
    private function obtenerSQL($comandos, $traducirParametros){
        $sql = '';
        foreach($comandos as $comando){
            if(!empty($comando)) $sql = $sql.$comando.' ';
        }
        if($traducirParametros){
            $contador = 0;
            while(strpos($sql, '?') > -1){
                $nuevo = $this->_datos[$contador] ?? '__PARAMETRO37812__';
                $nuevo = is_string($nuevo) && $nuevo != '__PARAMETRO37812__' ? "'".$nuevo."'" : $nuevo;
                $sql = $this->remplazarPrimeraCadena('?', $nuevo, $sql);
                $contador++;
            }
            $sql = str_replace('__PARAMETRO37812__', '?', $sql);
        }
        return trim($sql);
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
     * Convierte los registros según el tipo de dato de retorno.
     *
     * @parametro array $registros
     * @parametro string $tipo
     * @retorno array|json
     */
    private function convertirRegistrosTipo($registros, $tipo){
        $registrosConvertidos = [];
        foreach($registros as $registro){
            $registroPivote = [];
            foreach($registro as $clave => $valor){
                $valor = $this->convertirValorNumerico($valor);
                $valor = $this->decodificarCadenaUTF8($valor);
                $condicion = !empty($this->visibles)
                    ? in_array($clave, $this->visibles)
                    : !in_array($clave, $this->ocultos);
                if($condicion) $registroPivote[$clave] = $valor;
            }
            if(!empty($registroPivote))
                $registrosConvertidos[] = $tipo == self::OBJETO ? (object) $registroPivote : $registroPivote;
        }
        if($tipo == self::JSON) $registrosConvertidos = json_encode($registrosConvertidos);
        return $registrosConvertidos;
    }
    
    /*
     * Obtiene todos los campos de la tabla en la base de datos.
     *
     * @parametro array $excepciones
     * @retorno array
     */
    private function obtenerCamposTabla($excepciones = []){
        if(is_array($excepciones) && !empty($excepciones)){
            if($this->registroTiempo === true && $this->verificarCamposRegistroTiempo($this)){
                array_push($excepciones, $this->creadoEn);
                array_push($excepciones, $this->actualizadoEn);
            }
            return $excepciones;
        }
        switch(Configuracion::obtenerVariable('BD_CONTROLADOR')){
            case 'mysql':
                $consulta = Conexion::$cnx->query('describe '.$this->_tabla);
                $atributo = 'Field';
            break;
            case 'pgsql':
                $consulta = Conexion::$cnx->query(
                    'select 
                        column_name
                    from
                        information_schema.columns
                    where
                        table_name='."'".$this->_tabla."'"
                );
                $atributo = 'column_name';
            break;
            case 'sqlite':
                $consulta = Conexion::$cnx->query('pragma table_info('.$this->_tabla.')');
                $atributo = 'name';
            break;
            case 'sqlsrv':
                $consulta = Conexion::$cnx->query(
                    'select
                        column_name
                    from
                        information_schema.columns
                    where
                        table_name='."'".$this->_tabla."'"
                );
                $atributo = 'column_name';
            break;
        }
        $campos = [];
        foreach($consulta->fetchAll() as $datos){
            $campos[] = $datos[$atributo];
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
    private function procesarConsultaSQL($consulta, $datos = [], $tipo = self::OBJETO, $nativa = true){
        if($nativa == false) $consulta = $this->traducirConsultaSQL($consulta);
        if(
            (strpos($consulta, 'select') >- 1 && strpos($consulta, 'from') >- 1)
            &&
            (strpos($consulta, 'select') < strpos($consulta, 'from'))
        ){
            return $this->obtenerDatosConsultaSQL($tipo, $consulta, $datos);
        }
        else{
            if(is_array($datos) && !empty($datos)){
                $consulta = Conexion::$cnx->prepare($consulta);
                if($consulta->execute($datos)) return $consulta->rowCount();
                if(!$consulta->execute($datos))
                    Error::mostrar($consulta->errorInfo()[1].' - '.$consulta->errorInfo()[2], true);
            }
            else{
                $resultado = $consulta = Conexion::$cnx->exec($consulta);
                if($resultado == true || $resultado === 0) return $resultado;
                if($resultado == false)
                    Error::mostrar(Conexion::$cnx->errorInfo()[1].' - '.Conexion::$cnx->errorInfo()[2], true);
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
     * Traduce una consulta SQL en español a una consulta SQL nativa.
     *
     * @parametro string $consulta
     * @retorno string
     */
    private function traducirConsultaSQL($consulta){
        //Palabras reservadas para la consulta en español.
        $consultaUsuario = $consulta;
        $consulta = ' '.$consulta.' ';
        $consulta = str_ireplace('seleccionar', ' seleccionar ', $consulta);
        $palabras = explode(' ', $consulta);
        $cantPalabras = count($palabras);
        for($i = 0; $i < $cantPalabras; $i++){
            if($this->validarCadenaIndependiente('seleccionar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('seleccionar', ' select ', $palabras[$i]);
            if($this->validarCadenaIndependiente('distinto', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('distinto', ' distinct ', $palabras[$i]);	
            if($this->validarCadenaIndependiente('todo', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('todo', ' * ', $palabras[$i]);
            if($this->validarCadenaIndependiente('alias', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('alias', ' as ', $palabras[$i]);
            if($this->validarCadenaIndependiente('de', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('de', ' from ', $palabras[$i]);
            if($this->validarCadenaIndependiente('unir', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('unir', ' join ', $palabras[$i]);
            if($this->validarCadenaIndependiente('derecha', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('derecha', ' right ', $palabras[$i]);
            if($this->validarCadenaIndependiente('izquierda', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('izquierda', ' left ', $palabras[$i]);
            if($this->validarCadenaIndependiente('en', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('en', ' on ', $palabras[$i]);
            if($this->validarCadenaIndependiente('donde', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('donde', ' where ', $palabras[$i]);
            if($this->validarCadenaIndependiente('agrupar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('agrupar', ' group ', $palabras[$i]);
            if($this->validarCadenaIndependiente('teniendo', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('teniendo', ' having ', $palabras[$i]);
            if($this->validarCadenaIndependiente('ordenar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('ordenar', ' order ', $palabras[$i]);
            if($this->validarCadenaIndependiente('limite', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('limite', ' limit ', $palabras[$i]);
            if($this->validarCadenaIndependiente('por', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('por', ' by ', $palabras[$i]);
            if($this->validarCadenaIndependiente('existe', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('existe', ' exists ', $palabras[$i]);
            if($this->validarCadenaIndependiente('es', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('es', ' is ', $palabras[$i]);				
            if($this->validarCadenaIndependiente('nulo', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('nulo', 'null ', $palabras[$i]);				
            //Operadores lógicos.
            if($this->validarCadenaIndependiente('o', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('o', ' or ', $palabras[$i]);
            if($this->validarCadenaIndependiente('xo', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('xo', ' xor ', $palabras[$i]);
            if($this->validarCadenaIndependiente('y', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('y', ' and ', $palabras[$i]);
            if($this->validarCadenaIndependiente('no', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('no', ' not ', $palabras[$i]);
            if($this->validarCadenaIndependiente('entre', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('entre', ' between ', $palabras[$i]);
            if($this->validarCadenaIndependiente('como', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('como', ' like ', $palabras[$i]);
            //Manejo de datos
            if($this->validarCadenaIndependiente('insertar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('insertar', ' insert ', $palabras[$i]);
            if($this->validarCadenaIndependiente('dentro', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('dentro', ' into ', $palabras[$i]);
            if($this->validarCadenaIndependiente('valores', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('valores', ' values ', $palabras[$i]);
            if($this->validarCadenaIndependiente('actualizar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('actualizar', ' update ', $palabras[$i]);
            if($this->validarCadenaIndependiente('asignar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('asignar', ' set ', $palabras[$i]);
            if($this->validarCadenaIndependiente('eliminar', " $palabras[$i] ", false) && strlen($palabras[$i]) > 0) $palabras[$i] = str_ireplace('eliminar', ' delete ', $palabras[$i]);
        }
        $consulta = implode(' ', $palabras);
        //Funciones
        $consulta = str_ireplace('concatenar', 'concat', $consulta);
        $consulta = str_ireplace('promedio', 'avg', $consulta);
        $consulta = str_ireplace('contar', 'count', $consulta);
        $consulta = str_ireplace('maximo', 'max', $consulta);
        $consulta = str_ireplace('minimo', 'min', $consulta);
        $consulta = str_ireplace('suma', 'sum', $consulta);
        $consultaTraducida = $consulta;
        //Traducir solo lo que esta fuera de comillas.
        $partesUsuario = [];
        $partesTraducido = [];
        //Buscamos todo lo que se encuentre dentro de comillas dobles o simples.
        $i = 0;
        while(strpos($consultaUsuario, "'") > -1 || strpos($consultaUsuario, '"') > -1){
            $consultaUsuario = $this->remplazarPrimeraCadena("'", "?$i", $consultaUsuario);
            $consultaUsuario = $this->remplazarPrimeraCadena('"', "?$i", $consultaUsuario);
            $i++;
        }
        $k = 0;
        //Guardamos en un arreglo lo que el usuario ingreso dentro de comillas.
        for($j = 0; $j < $i; $j++){
            $in = $j;
            $fn = $j+1;
            if($j%2 == 0){
                $partesUsuario[$k] = "'".substr($consultaUsuario, strpos($consultaUsuario, "?$in")+2, (strpos($consultaUsuario, "?$fn")-strpos($consultaUsuario, "?$in")-2))."'";
                $k++;
            }		
        }
        //Buscamos todo lo que se encuentre dentro de comillas dobles o simples en la consulta traducida.
        $i = 0;
        while(strpos($consulta, "'") > -1 || strpos($consulta, '"') > -1){
            $consulta = $this->remplazarPrimeraCadena("'", "?$i", $consulta);
            $consulta = $this->remplazarPrimeraCadena('"', "?$i", $consulta);
            $i++;
        }
        $k = 0;
        //Guardamos en un arreglo lo que se encuentre dentro de comillas en la consulta traducida.
        for($j = 0; $j < $i; $j++){
            $in = $j;
            $fn = $j+1;
            if($j%2 == 0){
                $partesTraducido[$k] = substr($consulta, strpos($consulta, "?$in")+2, (strpos($consulta, "?$fn")-strpos($consulta, "?$in")-2));
                $k++;
            }		
        }
        //Remplazamos lo que esta dentro de comillas traducido por lo que ingreso el usuario entre comillas.
        $cantPartesTraducido = count($partesTraducido);
        for($i = 0; $i < $cantPartesTraducido; $i++){
            if(strpos($consultaTraducida, "'".$partesTraducido[$i])."'" > -1) $consultaTraducida = str_replace("'".$partesTraducido[$i]."'", $partesUsuario[$i], $consultaTraducida);
            if(strpos($consultaTraducida,'"'.$partesTraducido[$i]).'"' > -1) $consultaTraducida = str_replace('"'.$partesTraducido[$i].'"', $partesUsuario[$i], $consultaTraducida);
        }
        return $consultaTraducida;
    }
    
    /*
     * Obtiene la fecha y la hora actual según la zona horaria.
     *
     * @retorno string
     */
    private function obtenerFechaHoraActual(){
        $zonaHoraria = Configuracion::obtenerVariable('ZONA_HORARIA');
        $zonaHoraria = $zonaHoraria ? $zonaHoraria : 'UTC';
        $dateTime = new \DateTime($zonaHoraria);
        $tiempo = $dateTime->format('Y-m-d H:i:s');
        return $tiempo;
    }
    
    /*
     * Configura y obtiene el objeto del contexto this.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $contextoThis
     * @parametro array $datos
     * @parametro string $llavePrimaria
     * @parametro int|string $id
     * @retorno \PIPE\Clases\ConstructorConsulta|null
     */
    private function obtenerObjetoThis(self $contextoThis, $datos, $llavePrimaria, $id){
        if(empty($datos)) return null;
        foreach($datos[0] as $campo => $valor){
            //Creamos los atributos de los campos de la base de datos en el objeto $contextoThis.
            $contextoThis->$campo = $valor;
        }
        $contextoThis->asignarDatosModeloRelacion($contextoThis);
        return $contextoThis;
    }
    
    /*
     * Asigna los datos relacionados a un modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
    private function asignarDatosModeloRelacion(self $pipe){
        if(!empty($pipe->tieneUno)){
            if(is_string($pipe->tieneUno)) $pipe->tieneUno = [$pipe->tieneUno => null];
            $pipe->asignarRelacionTieneUno($pipe);
        }
        if(!empty($pipe->tieneMuchos)){
            if(is_string($pipe->tieneMuchos)) $pipe->tieneMuchos = [$pipe->tieneMuchos => null];
            $pipe->asignarRelacionTieneMuchos($pipe);
        }
        if(!empty($pipe->perteneceAUno)){
            if(is_string($pipe->perteneceAUno)) $pipe->perteneceAUno = [$pipe->perteneceAUno => null];
            $pipe->asignarRelacionPerteneceAUno($pipe);
        }
        if(!empty($pipe->perteneceAMuchos)){
            if(is_string($pipe->perteneceAMuchos)) $pipe->perteneceAMuchos = [$pipe->perteneceAMuchos => null];
            $pipe->asignarRelacionPerteneceAMuchos($pipe);
        }
    }
    
    /*
     * Asigna los datos de la relación tieneUno en el modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
    private function asignarRelacionTieneUno(self $pipe){
        foreach($pipe->tieneUno as $clase => $valores){
            if(!class_exists($clase))
                Error::mostrar(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].': '.$clase);
            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $tablaUnion = $atributosClaseUnion['tabla'];
            $campoForaneo = substr(Modelo::convertirModeloTabla($pipe->clase), 0, -1).'_id';
            $llaveForanea = $valores['llaveForanea'] ?? $campoForaneo;
            if(isset($valores['llavePrincipal'])){
                $llavePrincipal = $valores['llavePrincipal'];
                $valorllavePrincipal = (new self(['tabla' => $pipe->_tabla]))
                    ->seleccionar($llavePrincipal)
                    ->donde(substr($this->_condiciones, 7), $pipe->_datos)
                    ->obtener()[0]->$llavePrincipal;
            }
            else{
                $valorllavePrincipal = $pipe->_datos[0];
            }
            $datos = (new self(['tabla' => $tablaUnion]))
                ->donde($llaveForanea.'=?', [$valorllavePrincipal])->tomar(1);
            $datos = !empty($datos) ? $datos[0] : null;
            $pipe->_datosModeloRelacion[$tablaUnion] = $datos;
        }
    }
    
    /*
     * Asigna los datos de la relación tieneMuchos en el modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
    private function asignarRelacionTieneMuchos(self $pipe){
        foreach($pipe->tieneMuchos as $clase => $valores){
            if(!class_exists($clase))
                Error::mostrar(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].': '.$clase);
            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $tablaUnion = $atributosClaseUnion['tabla'];
            $campoForaneo = substr(Modelo::convertirModeloTabla($pipe->clase), 0, -1).'_id';
            $llaveForanea = $valores['llaveForanea'] ?? $campoForaneo;
            if(isset($valores['llavePrincipal'])){
                $llavePrincipal = $valores['llavePrincipal'];
                $valorllavePrincipal = (new self(['tabla' => $pipe->_tabla]))
                    ->seleccionar($llavePrincipal)
                    ->donde(substr($this->_condiciones, 7), $pipe->_datos)
                    ->obtener()[0]->$llavePrincipal;
            }
            else{
                $valorllavePrincipal = $pipe->_datos[0];
            }
            $datos = (new self(['tabla' => $tablaUnion]))
                ->donde($llaveForanea.'=?', [$valorllavePrincipal])->obtener();
            $pipe->_datosModeloRelacion[$tablaUnion] = $datos;
        }
    }
    
    /*
     * Asigna los datos de la relación perteneceAUno en el modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
    private function asignarRelacionPerteneceAUno(self $pipe){
        foreach($pipe->perteneceAUno as $clase => $valores){
            if(!class_exists($clase))
                Error::mostrar(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].': '.$clase);
            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $tablaUnion = $atributosClaseUnion['tabla'];
            $llavePrimariaUnion = $atributosClaseUnion['llavePrimaria'];
            $clase = Modelo::obtenerClaseLlamada($clase);
            $campoForaneo = substr(Modelo::convertirModeloTabla($clase), 0, -1).'_id';
            $llaveForanea = $valores['llaveForanea'] ?? $campoForaneo;
            $valorForanea = (new self(['tabla' => $pipe->_tabla]))
                ->seleccionar($llaveForanea)
                ->donde(substr($this->_condiciones, 7), $pipe->_datos)
                ->obtener()[0]->$llaveForanea;
            if(isset($valores['llavePrincipal'])){
                $llavePrincipal = $valores['llavePrincipal'];
                $valorllavePrincipal = (new self(['tabla' => $tablaUnion]))
                    ->seleccionar($llavePrincipal)
                    ->donde($llavePrimariaUnion.'=?', [$valorForanea])
                    ->obtener()[0]->$llavePrincipal;
            }
            else{
                $valorllavePrincipal = $valorForanea;
            }
            $datos = (new self(['tabla' => $tablaUnion]))
                ->donde($llavePrimariaUnion.'=?', [$valorllavePrincipal]);
            $datos = $datos->existe() ? $datos->obtener()[0] : null;
            $pipe->_datosModeloRelacion[$tablaUnion] = $datos;
        }
    }
    
    /*
     * Asigna los datos de la relación perteneceAMuchos en el modelo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno void
     */
    private function asignarRelacionPerteneceAMuchos(self $pipe){
        foreach($pipe->perteneceAMuchos as $clase => $valores){
            if(!class_exists($clase))
                Error::mostrar(Mensaje::$mensajes['MODELO_NO_ENCONTRADO'].': '.$clase);
            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $tablaUnion = $atributosClaseUnion['tabla'];
            $llavePrimariaUnion = $atributosClaseUnion['llavePrimaria'];
            $clase = Modelo::obtenerClaseLlamada($clase);
            $foraneaLocal = substr(Modelo::convertirModeloTabla($pipe->clase), 0, -1);
            $foraneaUnion = substr(Modelo::convertirModeloTabla($clase), 0, -1);
            $modelos = [$foraneaLocal, $foraneaUnion];
            sort($modelos);
            $tablaUnionRelacion = $valores['tablaUnion'] ?? strtolower($modelos[0].'_'.$modelos[1]);
            $llaveForaneaLocal = $valores['llaveForaneaLocal'] ?? $foraneaLocal.'_id';
            $llaveForaneaUnion = $valores['llaveForaneaUnion'] ?? $foraneaUnion.'_id';
            $relacion = (new self(['tabla' => $tablaUnion]))
                ->unir(
                    $tablaUnionRelacion,
                    $tablaUnion.'.'.$llavePrimariaUnion,
                    $tablaUnionRelacion.'.'.$llaveForaneaUnion
                );
            $datos = $relacion->seleccionar($tablaUnion.'.*')
                ->donde($tablaUnionRelacion.'.'.$llaveForaneaLocal.'=?', $pipe->_datos)
                ->obtener();
            foreach($datos as $dato){
                $datosTablaUnionRelacion = $relacion->seleccionar($tablaUnionRelacion.'.*')
                ->donde(
                    $tablaUnionRelacion.'.'
                    .$llaveForaneaLocal.'=? y '.$tablaUnionRelacion.'.'.$llaveForaneaUnion.'=?',
                    [$pipe->_datos[0], $dato->$llavePrimariaUnion]
                )->obtener()[0];
                $dato->$tablaUnionRelacion = $datosTablaUnionRelacion;
            }
            $pipe->_datosModeloRelacion[$tablaUnion] = $datos;
        }
    }
    
    /*
     * Configura las variables del registro del tiempo.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno \PIPE\Clases\ConstructorConsulta
     */
    private function configurarRegistroTiempo(self $pipe){
        $tiempo = $pipe->registroTiempo == true ? $pipe->obtenerFechaHoraActual() : null;
        $pipe->{$pipe->creadoEn} = $tiempo;
        $pipe->{$pipe->actualizadoEn} = $tiempo;
        return $pipe;
    }
    
    /*
     * Obtiene los campos personalizados de insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @parametro array $registro
     * @retorno string
     */
    private function obtenerCamposInsercionP(self $pipe, $registro){
        $campos = '';
        if(!empty($pipe->insertables)) $registro = $pipe->generarArregloAsociativo($registro, $pipe->insertables);
        foreach($registro as $campo => $valor){
            $campos = $campos.$campo.',';
        }
        if($pipe->registroTiempo === true && $pipe->verificarCamposRegistroTiempo($pipe))
            $campos = $campos.$pipe->creadoEn.', '.$pipe->actualizadoEn;
        else
            $campos = substr($campos, 0, -1);
        return $campos;
    }
    
    /*
     * Obtiene los parámetros personalizados de insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @parametro array $registro
     * @retorno string
     */
    private function obtenerParametrosInsercionP(self $pipe, $registro){
        $parametros = '';
        if(!empty($pipe->insertables)) $registro = $pipe->generarArregloAsociativo($registro, $pipe->insertables);
        foreach($registro as $campo => $valor){
            if($pipe->llavePrimaria == $campo && $registro[$campo] === 'default')
                $parametros = $parametros.$registro[$campo].',';
            else
                $parametros = $parametros.'?,';
        }
        if($pipe->registroTiempo === true && $pipe->verificarCamposRegistroTiempo($pipe))
            $parametros = $parametros.'?,?';
        else
            $parametros = substr($parametros, 0, -1);
        return $parametros;
    }
    
    /*
     * Obtiene los valores personalizados de insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @parametro array $registro
     * @retorno array
     */
    private function obtenerValoresInsercionP(self $pipe, $registro){
        $valores = [];
        if(!empty($pipe->insertables)) $registro = $pipe->generarArregloAsociativo($registro, $pipe->insertables);
        foreach($registro as $campo => $valor){
            if(!($pipe->llavePrimaria == $campo) || !($registro[$campo] === 'default'))
                $valores[] = $registro[$campo];
        }
        if($pipe->registroTiempo === true && $pipe->verificarCamposRegistroTiempo($pipe)){
            array_push($valores, $pipe->{$pipe->creadoEn});
            array_push($valores, $pipe->{$pipe->actualizadoEn});
        }
        return $valores;
    }
    
    /*
     * Obtiene los campos insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno string
     */
    private function obtenerCamposInsercion(self $pipe){
        $campos = '';
        $camposTabla = $pipe->obtenerCamposTabla($pipe->insertables);
        foreach($camposTabla as $campo){
            if(!property_exists($pipe, $campo))
                Error::mostrar(Mensaje::$mensajes['PROPIEDAD_NO_DEFINIDA'].': '.$campo);
            $campos = $campos.$campo.',';
        }
        $campos = substr($campos, 0, -1);
        return $campos;
    }
    
    /*
     * Obtiene los parámetros insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno string
     */
    private function obtenerParametrosInsercion(self $pipe){
        $parametros = '';
        $camposTabla = $pipe->obtenerCamposTabla($pipe->insertables);
        foreach($camposTabla as $campo){
            if($pipe->llavePrimaria == $campo && $pipe->$campo === 'default')
                $parametros = $parametros.$pipe->$campo.',';
            else
                $parametros = $parametros.'?,';
        }
        $parametros = substr($parametros, 0, -1);
        return $parametros;
    }
    
    /*
     * Obtiene los valores insersión.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno array
     */
    private function obtenerValoresInsercion(self $pipe){
        $valores = [];
        $camposTabla = $pipe->obtenerCamposTabla($pipe->insertables);
        foreach($camposTabla as $campo){
            if(!($pipe->llavePrimaria == $campo) || !($pipe->$campo === 'default'))
                $valores[] = $pipe->$campo;
        }
        return $valores;
    }
    
    /*
     * Obtiene los parámetros personalizados de actualización.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @parametro array $valores
     * @retorno string|boolean
     */
    private function obtenerParametrosActualizacionP(self $pipe, $valores){
        $parametros = '';
        if(!empty($pipe->actualizables)) $valores = $pipe->generarArregloAsociativo($valores, $pipe->actualizables);
        foreach($valores as $campo=>$valor){
            if(is_string($valor)) $valor = "'".$valor."'";
            if(!isset($valor)) $valor = 'null';
            $parametros = $parametros.$campo.'='.$valor.',';
        }
        $parametros = substr($parametros,0,-1);
        return $parametros;
    }
    
    /*
     * Obtiene los parámetros de actualización.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno string
     */
    private function obtenerParametrosActualizacion(self $pipe){
        $parametros = '';
        $camposTabla = $pipe->obtenerCamposTabla($pipe->actualizables);
        foreach($camposTabla as $campo){
            if(property_exists($pipe, $campo))
            $parametros = is_null($pipe->$campo)
                ? $parametros.$campo.'=null,'
                : $parametros.$campo."='".$pipe->$campo."',";
        }
        $parametros = substr($parametros, 0, -1);
        return $parametros;
    }
    
    /*
     * Genera un arreglo asociativo respecto a las excepciones encontradas.
     *
     * @parametro array $registro
     * @parametro array $excepciones
     * @retorno array
     */
    private function generarArregloAsociativo($registro, $excepciones){
        $arregloAsociativo = [];
        foreach($registro as $campo => $valor){
            foreach($excepciones as $valorPivote){
                if($campo == $valorPivote) $arregloAsociativo[$valorPivote] = $valor;
            }
        }
        return $arregloAsociativo;
    }
    
    /*
     * Verifica si los campos del registro del tiempo están definidos en la tabla de la base de datos.
     *
     * @parametro \PIPE\Clases\ConstructorConsulta $pipe
     * @retorno boolean
     */
    private function verificarCamposRegistroTiempo(self $pipe){
        $contador = 0;
        $camposTabla = $pipe->obtenerCamposTabla();
        foreach($camposTabla as $campo){
            if($campo == $pipe->creadoEn || $campo == $pipe->actualizadoEn) $contador++;
        }
        $existen = $contador == 2 ? true : false;
        return $existen;
    }
    
    /*
     * Verifica que la tabla especificada exista en la base de datos.
     *
     * @parametro string $tabla
     * @retorno boolean
     */
    private function verificarTablaExiste($tabla){
        $pdo = Conexion::$cnx;
        $consulta = $pdo->query('select * from '.$tabla);
        $existe = $consulta ? true : false;
        return $existe;
    }
    //Fin métodos privados.
}