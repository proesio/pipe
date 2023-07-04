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
use DateTime;
use PIPE\Rasgos\Encadenable;
use PIPE\Clases\Conectores\MySQL;
use PIPE\Clases\Conectores\SQLite;
use PIPE\Clases\Conectores\SQLServer;
use PIPE\Clases\Conectores\PostgreSQL;

class ConstructorConsulta
{
    use Encadenable;

    /**
     * Palabra reservada distinct.
     *
     * @var string
     */
    private $_distinto = '';

    /**
     * Campos seleccionados en la consulta SQL.
     *
     * @var string
     */
    private $_campos = '*';

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    private $_tabla = '';

    /**
     * Alias de la tabla en la base de datos.
     *
     * @var string
     */
    private $_alias = '';

    /**
     * Uniones con la cláusula inner join.
     *
     * @var string
     */
    private $_unir = '';

    /**
     * Uniones con la cláusula right join.
     *
     * @var string
     */
    private $_unirDerecha = '';

    /**
     * Uniones con la cláusula left join.
     *
     * @var string
     */
    private $_unirIzquierda = '';

    /**
     * Condiciones con la cláusula where.
     *
     * @var string
     */
    private $_condiciones = '';

    /**
     * Agrupaciones con la cláusula group by.
     *
     * @var string
     */
    private $_agrupar = '';

    /**
     * Condiciones con la cláusula having.
     *
     * @var string
     */
    private $_teniendo = '';

    /**
     * Ordenamiento de registros con la cláusula order by.
     *
     * @var string
     */
    private $_ordenar = '';

    /**
     * Limitación de registros con la cláusula limit.
     *
     * @var string
     */
    private $_limite = '';

    /**
     * Parámetros de la consulta SQL para ejecutar consultas preparadas.
     *
     * @var array
     */
    private $_parametros = [];

    /**
     * Atributos personalizados definidos por el modelo y el constructor de consulta.
     *
     * @var array
     */
    private $_atributos = [];

    /**
     * Datos relacionados con el modelo(s) establecido.
     *
     * @var array
     */
    private $_relaciones = [];

    /**
     * Crea una nueva instancia de la clase ConstructorConsulta.
     *
     * @param array $atributos atributos
     * 
     * @return void
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    public function __construct($atributos = [])
    {
        if (isset($atributos['conexion'])) {
            PIPE::conexion($atributos['conexion']);
        }

        $this->_atributos = [
            'conexion' => $atributos['conexion'] ?? null,
            'tabla' => $atributos['tabla'] ?? '',
            'claseLlamada' => $atributos['claseLlamada'] ?? self::class,
            'clase' => $atributos['clase'] ?? self::class,
            'llavePrimaria' => $atributos['llavePrimaria'] ?? 'id',
            'registroTiempo' => $atributos['registroTiempo'] ?? true,
            'creadoEn' => $atributos['creadoEn'] ?? 'creado_en',
            'actualizadoEn' => $atributos['actualizadoEn'] ?? 'actualizado_en',
            'tieneUno' => $atributos['tieneUno'] ?? [],
            'tieneMuchos' => $atributos['tieneMuchos'] ?? [],
            'perteneceAUno' => $atributos['perteneceAUno'] ?? [],
            'perteneceAMuchos' => $atributos['perteneceAMuchos'] ?? [],
            'insertables' => $atributos['insertables'] ?? [],
            'actualizables' => $atributos['actualizables'] ?? [],
            'visibles' => $atributos['visibles'] ?? [],
            'ocultos' => $atributos['ocultos'] ?? []
        ];

        $this->_tabla = $this->_atributos['tabla'];

        if (isset($atributos['RETORNO_CLASE'])) {
            $this->donde(
                $this->_atributos['llavePrimaria'].' = ?',
                [$this->{$this->_atributos['llavePrimaria']}]
            );

            $this->relaciones(...$atributos['relaciones']);
            $this->relacionar(...$atributos['relaciones']);
        }

        if (!empty($this->_tabla) && !$this->_obtenerCamposTabla()) {
            Error::mostrar(Mensaje::$mensajes['TABLA_NO_EXISTE'].': '.$this->_tabla);
        }
    }

    // Inicio métodos públicos.

    /**
     * Inicio palabras reservadas representadas 
     * en métodos para construir una consulta SQL.
     */

    /**
     * Establece un alias al nombre de la tabla.
     *
     * @param string $alias alias
     * 
     * @return $this
     */
    public function alias($alias)
    {
        $this->_alias = $alias;

        return $this;
    }

    /**
     * Obtiene todos los registros de la tabla seleccionada.
     *
     * @param array|string $campos      campos
     * @param string|null  $tipoRetorno tipoRetorno
     * 
     * @return array|json|string
     */
    public function todo($campos = [], $tipoRetorno = null)
    {
        if (is_array($campos) && !empty($campos)) {
            return $this->seleccionar($campos)->obtener($tipoRetorno);
        } else {
            if ($campos == PIPE::CLASE
                || $campos == PIPE::OBJETO
                || $campos == PIPE::ARREGLO
                || $campos == PIPE::JSON
                || $campos == PIPE::SQL
            ) {
                $tipoRetorno = $campos;
            }

            $tipoRetorno = $tipoRetorno ?? Configuracion::config(
                'TIPO_RETORNO', PIPE::CLASE
            );

            return $this->obtener($tipoRetorno);
        }
    }

    /**
     * Establece los campos que serán seleccionados.
     *
     * @param array|mixed $campos campos
     * 
     * @return $this
     */
    public function seleccionar($campos = ['*'])
    {
        $campos = is_array($campos) ? $campos : func_get_args();
        $campos = implode(',', $campos);

        $this->_campos = $this->_traducirConsultaSQL($campos);

        return $this;
    }

    /**
     * Elimina duplicados del conjunto de resultados.
     *
     * @return $this
     */
    public function distinto()
    {
        $this->_distinto = 'distinct';

        return $this;
    }

    /**
     * Combina registros de una o más tablas relacionadas.
     *
     * @param string      $tablaUnion    tablaUnion
     * @param string      $llaveForanea  llaveForanea
     * @param string      $union         union
     * @param string|null $llavePrimaria llavePrimaria
     * 
     * @return $this
     */
    public function unir($tablaUnion, $llaveForanea, $union, $llavePrimaria = null)
    {
        if (!$llavePrimaria) {
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

    /**
     * Combina registros de una o más tablas relacionadas 
     * obteniendo todos los registros de la tabla de la derecha.
     *
     * @param string $tablaUnion    tablaUnion
     * @param string $llaveForanea  llaveForanea
     * @param string $union         union
     * @param string $llavePrimaria llavePrimaria
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    public function unirDerecha(
        $tablaUnion, $llaveForanea, $union, $llavePrimaria = null
    ) {
        if (Configuracion::config('BD_CONTROLADOR') == 'sqlite') {
            Error::mostrar(
                Mensaje::$mensajes['METODO_NO_SOPORTADO'].': '.__METHOD__
            );
        }

        if (!$llavePrimaria) {
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

    /**
     * Combina registros de una o más tablas relacionadas 
     * obteniendo todos los registros de la tabla de la izquierda.
     *
     * @param string      $tablaUnion    tablaUnion
     * @param string      $llaveForanea  llaveForanea
     * @param string      $union         union
     * @param string|null $llavePrimaria llavePrimaria
     * 
     * @return $this
     */
    public function unirIzquierda(
        $tablaUnion, $llaveForanea, $union, $llavePrimaria = null
    ) {
        if (!$llavePrimaria) {
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

    /**
     * Establece una condición con cláusula where en la consulta SQL.
     *
     * @param string $condicion  condicion
     * @param array  $parametros parametros
     * 
     * @return $this
     */
    public function donde($condicion, $parametros = [])
    {
        $this->_condiciones = $this->_traducirConsultaSQL('where '.$condicion);
        $this->_parametros = $parametros;

        return $this;
    }

    /**
     * Agrupa registros que tienen los mismos valores.
     *
     * @param string|array $grupos grupos
     * 
     * @return $this
     */
    public function agruparPor($grupos)
    {
        $agrupaciones = is_array($grupos) ? implode(', ', $grupos) : $grupos;
        $grupo = $this->_traducirConsultaSQL('group by '.$agrupaciones);

        $this->_agrupar = $grupo;

        return $this;
    }

    /**
     * Establece una condición a una función de agregación con la cláusula having.
     *
     * @param string $condicion condicion
     * 
     * @return $this
     */
    public function teniendo($condicion)
    {
        $this->_teniendo = $this->_traducirConsultaSQL('having '.$condicion);

        return $this;
    }

    /**
     * Ordena el resultado de la consulta SQL.
     *
     * @param string|array $ordenes ordenes
     * @param string       $tipo    tipo
     * 
     * @return $this
     */
    public function ordenarPor($ordenes, $tipo = 'asc')
    {
        $ordenaciones = is_array($ordenes) ? implode(', ', $ordenes) : $ordenes;
        $orden = $this->_traducirConsultaSQL('order by '.$ordenaciones.' '.$tipo);

        $this->_ordenar = $orden;

        return $this;
    }

    /**
     * Limita el número de registros retornados en la consulta SQL.
     *
     * @param int      $cantidad cantidad
     * @param int|null $inicio   inicio
     * 
     * @return $this
     */
    public function limite($cantidad, $inicio = null)
    {
        switch (Configuracion::config('BD_CONTROLADOR')) {
        case 'mysql':
            $this->_limite = MySQL::obtenerCadenaLimite($cantidad, $inicio);
            break;

        case 'pgsql':
            $this->_limite = PostgreSQL::obtenerCadenaLimite($cantidad, $inicio);
            break;

        case 'sqlite':
            $this->_limite = SQLite::obtenerCadenaLimite($cantidad, $inicio);
            break;

        case 'sqlsrv':
            $this->_limite = SQLServer::obtenerCadenaLimite(
                $this->_ordenar, 
                $this->_tabla.'.'.$this->_atributos['llavePrimaria'], 
                $cantidad, $inicio
            );
            break;
        }

        return $this;
    }

    /**
     * Fin palabras reservadas representadas 
     * en métodos para construir una consulta SQL.
     */

    // Inicio consultas básicas por medio de métodos.

    /**
     * Obtiene los primeros registros retornados en la consulta SQL.
     *
     * @param int|string  $limite      limite
     * @param string|null $tipoRetorno tipoRetorno
     * 
     * @return object|array|json|null
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    public function primero($limite = 1, $tipoRetorno = null)
    {
        $tipoRetorno = $tipoRetorno ?? Configuracion::config(
            'TIPO_RETORNO', PIPE::CLASE
        );

        if ($limite == PIPE::CLASE 
            || $limite == PIPE::OBJETO 
            || $limite == PIPE::ARREGLO 
            || $limite == PIPE::JSON 
            || $limite == PIPE::SQL
        ) {
            $tipoRetorno = $limite;
            $limite = 1;
        }

        if ($tipoRetorno == PIPE::SQL) {
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        }

        $registros = $this->limite($limite)->obtener($tipoRetorno);

        return $this->_obtenerRegistroArreglo($registros, $tipoRetorno);
    }

    /**
     * Obtiene los últimos registros retornados en la consulta SQL.
     *
     * @param string|int  $llavePrimaria llavePrimaria
     * @param int|string  $limite        limite
     * @param string|null $tipoRetorno   tipoRetorno
     * 
     * @return object|array|json|null
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    public function ultimo($llavePrimaria = 'id', $limite = 1, $tipoRetorno = null)
    {
        $tipoRetorno = $tipoRetorno ?? Configuracion::config(
            'TIPO_RETORNO', PIPE::CLASE
        );

        if ($llavePrimaria == PIPE::CLASE
            || $llavePrimaria == PIPE::OBJETO 
            || $llavePrimaria == PIPE::ARREGLO 
            || $llavePrimaria == PIPE::JSON
            || $llavePrimaria == PIPE::SQL
        ) {
            $tipoRetorno = $llavePrimaria;
            $llavePrimaria = $this->_atributos['llavePrimaria'];
        } elseif (is_numeric($llavePrimaria)) {
            if ($limite == PIPE::CLASE
                || $limite == PIPE::OBJETO 
                || $limite == PIPE::ARREGLO 
                || $limite == PIPE::JSON
                || $limite == PIPE::SQL
            ) {
                $tipoRetorno = $limite;
            }

            $limite = $llavePrimaria;
            $llavePrimaria = $this->_atributos['llavePrimaria'];
        } elseif ($limite == PIPE::CLASE 
            || $limite == PIPE::OBJETO 
            || $limite == PIPE::ARREGLO 
            || $limite == PIPE::JSON
            || $limite == PIPE::SQL
        ) {
            $tipoRetorno = $limite;
            $limite = 1;
        }

        if ($llavePrimaria != 'id') {
            $this->_atributos['llavePrimaria'] = $llavePrimaria;
        }

        if ($this->_atributos['llavePrimaria'] != 'id') {
            $llavePrimaria = $this->_atributos['llavePrimaria'];
        }

        if ($tipoRetorno == PIPE::SQL) {
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        }

        $registros = $this->ordenarPor($llavePrimaria, 'desc')
            ->limite($limite)->obtener($tipoRetorno);

        return $this->_obtenerRegistroArreglo($registros, $tipoRetorno);
    }

    /**
     * Obtiene la cantidad general o específica de registros retornados.
     *
     * @param string $campo campo
     * 
     * @return int
     */
    public function contar($campo = '*')
    {
        return intval(
            $this->_procesarConsultaSQL(
                'select count('.$campo.') as conteo
                from '.$this->_tabla.' '
                .$this->_condiciones,
                $this->_parametros,
                PIPE::OBJETO
            )[0]->conteo
        );
    }

    /**
     * Obtiene el valor máximo del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public function maximo($campo)
    {
        return $this->_procesarConsultaSQL(
            'select max('.$campo.') as maximo
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_parametros,
            PIPE::OBJETO
        )[0]->maximo;
    }

    /**
     * Obtiene el valor mímino del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public function minimo($campo)
    {
        return $this->_procesarConsultaSQL(
            'select min('.$campo.') as minimo
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_parametros,
            PIPE::OBJETO
        )[0]->minimo;
    }

    /**
     * Obtiene el valor promedio del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public function promedio($campo)
    {
        return $this->_procesarConsultaSQL(
            'select avg('.$campo.') as promedio
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_parametros,
            PIPE::OBJETO
        )[0]->promedio;
    }

    /**
     * Obtiene la suma del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public function suma($campo)
    {
        return $this->_procesarConsultaSQL(
            'select sum('.$campo.') as suma
            from '.$this->_tabla.' '
            .$this->_condiciones,
            $this->_parametros,
            PIPE::OBJETO
        )[0]->suma;
    }

    /**
     * Verifica que la consulta SQL ha retornado un resultado.
     *
     * @return boolean
     */
    public function existe()
    {
        return $this->primero(PIPE::OBJETO) ? true : false;
    }

    /**
     * Verifica que la consulta SQL no ha retornado un resultado.
     *
     * @return boolean
     */
    public function noExiste()
    {
        return $this->primero(PIPE::OBJETO) ? false : true;
    }

    /**
     * Incrementa el valor del campo especificado.
     *
     * @param string $campo      campo
     * @param int    $incremento incremento
     * 
     * @return mixed
     */
    public function incrementar($campo, $incremento = 1)
    {
        return $this->_procesarConsultaSQL(
            'update '.$this->_tabla
            .' set '.$campo.'='.$campo.'+'.$incremento.' '
            .$this->_condiciones,
            $this->_parametros
        );
    }

    /**
     * Decrementa el valor del campo especificado.
     *
     * @param string $campo      campo
     * @param int    $decremento decremento
     * 
     * @return mixed
     */
    public function decrementar($campo, $decremento = 1)
    {
        return $this->_procesarConsultaSQL(
            'update '.$this->_tabla
            .' set '.$campo.'='.$campo.'-'.$decremento.' '
            .$this->_condiciones,
            $this->_parametros
        );
    }

    /**
     * Obtiene una instancia del Constructor de Consultas 
     * con los datos asociados a la llave primaria.
     *
     * @param array|int|string $valor         valor
     * @param string           $llavePrimaria llavePrimaria
     * 
     * @return $this|array|null
     */
    public function encontrar($valor, $llavePrimaria = 'id')
    {
        if ($llavePrimaria != 'id') {
            $this->_atributos['llavePrimaria'] = $llavePrimaria;
        }

        if ($this->_atributos['llavePrimaria'] != 'id') {
            $llavePrimaria = $this->_atributos['llavePrimaria'];
        }

        if (is_array($valor) && !empty($valor)) {
            $registros = [];

            foreach ($valor as $id) {
                $registros[] = $this->donde($llavePrimaria.' = ?', [$id])->primero();
            }

            return $registros;
        } else {
            return $this->donde($llavePrimaria.' = ?', [$valor])->primero();
        }
    }

    // Fin consultas básicas por medio de métodos.

    // Inicio instrucciones insertar, actualizar, eliminar y vaciar.

    /**
     * Inserta un nuevo registro en la base de datos.
     *
     * @param array $registros registros
     * 
     * @return int
     */
    public function insertar($registros = [])
    {
        if (is_array($registros) && !empty($registros)) {
            $registros = $this->obtenerRegistrosInsertar($registros);

            $campos = '';
            $parametros = '';
            $valores = [];

            if ($this->_atributos['claseLlamada'] != self::class) {
                $registros = $this->_mutarRegistros('asignar', $registros);
            }

            foreach ($registros as $registro) {
                $campos = (
                    '('.$this->_obtenerCamposInsercionP($registro).')'
                );

                $parametros .= (
                    '('.$this->_obtenerParametrosInsercionP($registro).'),'
                );

                $valores = array_merge(
                    $valores, $this->_obtenerValoresInsercionP($registro)
                );
            }

            $parametros = trim($parametros, ',');

            return $this->_procesarConsultaSQL(
                'insert into '.$this->_tabla
                .$campos.' values '.$parametros,
                $valores
            );
        } else {
            $this->_configurarRegistroTiempo();

            $campos = $this->_obtenerCamposInsercion();
            $parametros = $this->_obtenerParametrosInsercion();
            $valores = $this->_obtenerValoresInsercion();

            return $this->_procesarConsultaSQL(
                'insert into '.$this->_tabla
                .' ('.$campos.') values ('.$parametros.')',
                $valores
            );
        }
    }

    /**
     * Inserta un nuevo registro en la base de datos y obtiene el último id generado.
     *
     * @param array $registros registros
     * 
     * @return int
     */
    public function insertarObtenerId($registros = [])
    {
        $this->insertar($registros);

        return intval(Conexion::$conexion->lastInsertId());
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param array $registro registro
     * 
     * @return int
     */
    public function actualizar($registro = [])
    {
        if (is_array($registro) && !empty($registro)) {
            $parametros = $this->_obtenerParametrosActualizacionP($registro);
        } else {
            $parametros = $this->_obtenerParametrosActualizacion();
        }

        if ($parametros) {
            $resultado = $this->_procesarConsultaSQL(
                'update '.$this->_tabla
                .' set '.$parametros.' '
                .$this->_condiciones,
                $this->_parametros
            );

            if ($resultado > 0 && $this->_verificarCamposRegistroTiempo()) {
                $this->_procesarConsultaSQL(
                    'update '.$this->_tabla
                    .' set '.$this->_atributos['actualizadoEn']
                    ." = '".$this->_obtenerFechaHoraActual()
                    ."' ".$this->_condiciones,
                    $this->_parametros
                );
            }

            return $resultado;
        }

        return 0;
    }

    /**
     * Actualiza o inserta un nuevo registro en la base de datos.
     *
     * @param array $atributos atributos
     * @param array $valores   valores
     * 
     * @return int
     */
    public function actualizarOInsertar($atributos, $valores = [])
    {
        $condiciones = '';
        $parametros = [];

        foreach ($atributos as $campo => $valor) {
            $condiciones .= $campo.' = ? y ';
            $parametros[] = $valor;
        }

        $condiciones = substr($condiciones, 0, -2);

        $this->donde($condiciones, $parametros);

        if ($this->existe()) {
            if ($this->_verificarCamposRegistroTiempo()) {
                $actualizadoEn = $this->_atributos['actualizadoEn'];
                $valores[$actualizadoEn] = $this->_obtenerFechaHoraActual();
            }

            return $this->actualizar($valores);
        } else {
            $registro = array_merge($atributos, $valores);

            return $this->insertar($registro);
        }
    }

    /**
     * Elimina un registro en la base de datos.
     *
     * @return int
     */
    public function eliminar()
    {
        return $this->_procesarConsultaSQL(
            'delete from '.$this->_tabla.' '.$this->_condiciones, $this->_parametros
        );
    }

    /**
     * Elimina todos los registros en la tabla y reinicia 
     * el contador auto incrementable.
     *
     * @param boolean $forzado forzado
     * 
     * @return boolean
     */
    public function vaciar($forzado = false)
    {
        switch (Configuracion::config('BD_CONTROLADOR')) {
        case 'mysql':
            $sentencias = MySQL::obtenerSentenciasTruncar(
                $this->_tabla, $forzado
            );
            break;
        case 'pgsql':
            $sentencias = PostgreSQL::obtenerSentenciasTruncar(
                $this->_tabla, $forzado
            );
            break;
        case 'sqlite':
            $sentencias = SQLite::obtenerSentenciasTruncar(
                $this->_tabla, $forzado
            );
            break;
        case 'sqlsrv':
            $sentencias = SQLServer::obtenerSentenciasTruncar(
                $this->_tabla, $forzado
            );
            break;
        }

        foreach ($sentencias as $sentencia) {
            $this->_procesarConsultaSQL($sentencia);
        }

        return true;
    }

    // Fin instrucciones insertar, actualizar, eliminar y vaciar.

    /**
     * Realiza una consulta SQL en español.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|json|int
     */
    public function consulta($consulta, $parametros = [], $tipoRetorno = null)
    {
        $tipoRetorno = $tipoRetorno 
            ?? Configuracion::config('TIPO_RETORNO', PIPE::CLASE);

        return $this->_procesarConsultaSQL(
            $consulta, $parametros, $tipoRetorno, false
        );
    }

    /**
     * Realiza una consulta SQL nativa.
     *
     * @param string       $consulta    consulta
     * @param array|string $parametros  parametros
     * @param string       $tipoRetorno tipoRetorno
     * 
     * @return array|json|int
     */
    public function consultaNativa(
        $consulta, $parametros = [], $tipoRetorno = null
    ) {
        $tipoRetorno = $tipoRetorno 
            ?? Configuracion::config('TIPO_RETORNO', PIPE::CLASE);

        return $this->_procesarConsultaSQL(
            $consulta, $parametros, $tipoRetorno
        );
    }

    /**
     * Realiza una sentencia SQL en español.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|booleano
     */
    public function sentencia($sentencia)
    {
        return $this->_procesarConsultaSQL($sentencia, [], null, false);
    }

    /**
     * Realiza una sentencia SQL nativa.
     *
     * @param string $sentencia sentencia
     * 
     * @return int|booleano
     */
    public function sentenciaNativa($sentencia)
    {
        return $this->_procesarConsultaSQL($sentencia);
    }

    /**
     * Obtiene el resultado de una consulta SQL.
     *
     * @param string|null $tipoRetorno tipoRetorno
     * 
     * @return array|json|string
     */
    public function obtener($tipoRetorno = null)
    {
        $tipoRetorno = $tipoRetorno ?? Configuracion::config(
            'TIPO_RETORNO', PIPE::CLASE
        );

        if ($tipoRetorno == PIPE::SQL) {
            return $this->_obtenerConsultaSQL($tipoRetorno, true);
        }

        return $this->_obtenerDatosConsultaSQL($tipoRetorno);
    }

    /**
     * Establece los datos relacionados a un modelo 
     * que se obtendrán junto a los resultados de la consulta SQL.
     *
     * @return $this
     */
    public function relaciones()
    {
        $this->_relaciones = func_get_args();

        return $this;
    }

    /**
     * Establece los datos relacionados a la instancia de un modelo.
     *
     * @return $this
     */
    public function relacionar()
    {
        $parametros = func_get_args();

        foreach ($parametros as $parametro) {
            $this->{$parametro} = $this->_obtenerRelacion(
                $this, $parametro, PIPE::CLASE
            );
        }

        return $this;
    }

    /**
     * Prepara y obtiene los registros a insertar.
     *
     * @param array $registros registros
     * 
     * @return array
     */
    public function obtenerRegistrosInsertar($registros)
    {
        foreach ($registros as $clave => $valor) {
            return is_string($clave) ? [$registros] : $registros;
        }
    }

    // Fin métodos públicos.

    // Inicio métodos privados.

    /**
     * Procesa y obtiene los datos de una consulta SQL.
     *
     * @param string       $tipoRetorno     tipoRetorno
     * @param string       $consultaUsuario consultaUsuario
     * @param array|string $parametros      parametros
     * 
     * @return array|json
     * 
     * @throws \PIPE\Clases\Excepciones\ORM|\PIPE\Clases\Excepciones\SQL
     */
    private function _obtenerDatosConsultaSQL(
        $tipoRetorno, 
        $consultaUsuario = '', 
        $parametros = []
    ) {
        if ($tipoRetorno != PIPE::CLASE 
            && $tipoRetorno != PIPE::OBJETO 
            && $tipoRetorno != PIPE::ARREGLO 
            && $tipoRetorno != PIPE::JSON
        ) {
            Error::mostrar(
                Mensaje::$mensajes['TIPO_DATO_DESCONOCIDO'].': '.$tipoRetorno
            );
        }

        if ($parametros == PIPE::OBJETO 
            || $parametros == PIPE::ARREGLO 
            || $parametros == PIPE::JSON
        ) {
            $tipoRetorno = $parametros;
        }

        if (is_array($this->_parametros) && !empty($this->_parametros)) {
            $parametros = $this->_parametros;
        }

        if ($consultaUsuario == '') {
            $consultaUsuario = $this->_obtenerConsultaSQL($tipoRetorno);
        }

        if (is_array($parametros) && !empty($parametros)) {
            $consulta = Conexion::$conexion->prepare($consultaUsuario);
            $resultado = $consulta->execute($parametros);

            if (!$resultado) {
                Error::mostrar(
                    $consulta->errorInfo()[1].' - '.$consulta->errorInfo()[2], true
                );
            }
        } else {
            $consulta = Conexion::$conexion->query($consultaUsuario);

            if (!$consulta) {
                Error::mostrar(
                    Conexion::$conexion->errorInfo()[1]
                    .' - '.Conexion::$conexion->errorInfo()[2], 
                    true
                );
            }
        }

        if ($tipoRetorno == PIPE::CLASE) {
            if (!$this->_agrupar) {
                $this->_atributos['RETORNO_CLASE'] = true;
                $this->_atributos['relaciones'] = $this->_relaciones;
            }

            $parametros = [
                PDO::FETCH_CLASS, 
                self::class, 
                ['atributos' => $this->_atributos]
            ];
        } elseif ($tipoRetorno == PIPE::OBJETO) {
            $parametros = [PDO::FETCH_OBJ];
        } else {
            $parametros = [PDO::FETCH_ASSOC];
        }

        $registros = $consulta->fetchAll(...$parametros);

        return $this->_convertirRegistros($registros, $tipoRetorno);
    }

    /**
     * Convierte los registros al tipo de retorno especificado.
     *
     * @param array  $registros   registros
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array|json
     */
    private function _convertirRegistros($registros, $tipoRetorno)
    {
        if ($tipoRetorno != PIPE::CLASE && $this->_relaciones) {
            $pipe = new self($this->_atributos);

            foreach ($registros as $clave => $registro) {
                foreach ($this->_relaciones as $relacion) {
                    $valorLlavePrimaria = $tipoRetorno == PIPE::OBJETO
                        ? $registro->{$this->_atributos['llavePrimaria']}
                        : $registro[$this->_atributos['llavePrimaria']];

                    $pipe = $pipe->encontrar($valorLlavePrimaria);

                    $registroRelacion = $this->_obtenerRelacion(
                        $pipe, $relacion, 
                        $tipoRetorno == PIPE::JSON ? PIPE::ARREGLO : $tipoRetorno
                    );

                    $tipoRetorno == PIPE::OBJETO 
                        ? $registro->{$relacion} = $registroRelacion
                        : $registro[$relacion] = $registroRelacion;
                }

                $registros[$clave] = $registro;
            }
        }

        if ($this->_atributos['claseLlamada'] != self::class) {
            $registros = $this->_mutarRegistros('obtener', $registros);
        }

        if ($tipoRetorno == PIPE::JSON) {
            $registros = json_encode($registros);
        }

        return $registros;
    }

    /**
     * Realiza una asignación u obtención personalizada
     * de los valores de los atributos.
     *
     * @param string $accion   accion
     * @param string $clase    clase
     * @param array  $registro registro
     * 
     * @return array
     */
    private function _mutarAtributos($accion, $clase, $registro)
    {
        $instancia = new $clase();
        $esArreglo = is_array($registro) ? true : false;

        foreach ($registro as $clave => $valor) {
            $metodo = strpos($clave, '_') === false
                ? 'mutar'.$clave.$accion
                : 'mutar'.(str_replace('_', '', $clave)).$accion;

            if (method_exists($clase, $metodo)) {
                $valorMutado = $instancia->{$metodo}($valor);

                if ($esArreglo) {
                    $registro[$clave] = $valorMutado;
                } else {
                    $registro->{$clave} = $valorMutado;
                }
            }
        }

        return $registro;
    }

    /**
     * Realiza una asignación u obtención personalizada
     * de los valores de los registros.
     *
     * @param string $accion    accion
     * @param array  $registros registros
     * 
     * @return array
     */
    private function _mutarRegistros($accion, $registros)
    {
        foreach ($registros as $clave => $registro) {
            $registros[$clave] = $this->_mutarAtributos(
                $accion, $this->_atributos['claseLlamada'], $registro
            );
        }

        return $registros;
    }

    /**
     * Obtiene la consulta SQL generada.
     *
     * @param string  $tipoRetorno        tipoRetorno
     * @param boolean $traducirParametros traducirParametros
     * 
     * @return string
     */
    private function _obtenerConsultaSQL($tipoRetorno, $traducirParametros = false)
    {
        $camposPivot = trim($this->_campos);

        if ($camposPivot == '*') {
            $camposPivot = implode(',', $this->_obtenerCamposTabla());
        }

        $camposPivot = explode(',', $camposPivot);
        $campos = [];

        foreach ($camposPivot as $campo) {
            $campo = trim($campo);

            $condicion = !empty($this->_atributos['visibles'])
                ? in_array($campo, $this->_atributos['visibles'])
                : !in_array($campo, $this->_atributos['ocultos']);

            if ($condicion) {
                $campos[] = $campo;
            }
        }

        if (($tipoRetorno == PIPE::CLASE
            && !in_array($this->_atributos['llavePrimaria'], $campos)
            && !$this->_agrupar)
            || $this->_relaciones
        ) {
            $tabla = $this->_alias ? $this->_alias : $this->_tabla;

            $campos[] = $tabla.'.'.$this->_atributos['llavePrimaria'];
        }

        $campos = implode(',', $campos);

        $alias = $this->_alias ? 'as '.$this->_alias : '';

        $sql = 'select '.$this->_distinto
            .' '.$campos
            .' from '.$this->_tabla
            .' '.$alias
            .' '.$this->_unir
            .' '.$this->_unirDerecha
            .' '.$this->_unirIzquierda
            .' '.$this->_condiciones
            .' '.$this->_agrupar
            .' '.$this->_teniendo
            .' '.$this->_ordenar
            .' '.$this->_limite;

        $comandos = explode(' ', $sql);

        return $this->_obtenerSQL($comandos, $traducirParametros);
    }

    /**
     * Obtiene el SQL a través de un arreglo de comandos.
     *
     * @param array   $comandos           comandos
     * @param boolean $traducirParametros traducirParametros
     * 
     * @return string
     */
    private function _obtenerSQL($comandos, $traducirParametros)
    {
        $sql = '';

        foreach ($comandos as $comando) {
            if ($comando == '0' || !empty($comando)) {
                $sql = $sql.$comando.' ';
            }
        }

        if ($traducirParametros) {
            $contador = 0;

            while (strpos($sql, '?') > -1) {
                $nuevo = $this->_parametros[$contador] ?? '__PARAMETRO37812__';
                $nuevo = is_string($nuevo) && $nuevo != '__PARAMETRO37812__' 
                    ? "'".$nuevo."'" : $nuevo;

                $sql = $this->remplazarPrimeraCadena('?', $nuevo, $sql);
                $contador++;
            }

            $sql = str_replace('__PARAMETRO37812__', '?', $sql);
        }

        return trim($sql);
    }

    /**
     * Obtiene todos los campos de la tabla en la base de datos.
     *
     * @param array $camposHabilitados camposHabilitados
     * 
     * @return array
     */
    private function _obtenerCamposTabla($camposHabilitados = [])
    {
        if (is_array($camposHabilitados) && !empty($camposHabilitados)) {
            if ($this->_verificarCamposRegistroTiempo()) {
                array_push($camposHabilitados, $this->_atributos['creadoEn']);
                array_push($camposHabilitados, $this->_atributos['actualizadoEn']);
            }

            return $camposHabilitados;
        }

        $controlador = Configuracion::config('BD_CONTROLADOR');

        if ($controlador == 'mysql') {
            $campoEsquema = 'table_schema';
        } else {
            $campoEsquema = 'table_catalog';
        }

        $consultaColumna = (
            'select 
                column_name
            from
                information_schema.columns
            where
                '.$campoEsquema.' = '."'".Configuracion::config('BD_BASEDATOS')."'".'
                and table_name = '."'".$this->_tabla."'"
        );

        $columna = 0;

        if ($controlador == 'sqlite') {
            $columna = 1;
            $consultaColumna = 'pragma table_info('.$this->_tabla.')';
        }

        $consulta = Conexion::$conexion->query($consultaColumna);

        return $consulta->fetchAll(PDO::FETCH_COLUMN, $columna);
    }

    /**
     * Procesa una consulta SQL.
     *
     * @param string  $consulta    consulta
     * @param array   $parametros  parametros
     * @param string  $tipoRetorno tipoRetorno
     * @param boolean $nativa      nativa
     * 
     * @return array|int|json
     * 
     * @throws \PIPE\Clases\Excepciones\ORM|\PIPE\Clases\Excepciones\SQL
     */
    private function _procesarConsultaSQL(
        $consulta, $parametros = [], $tipoRetorno = null, $nativa = true
    ) {
        $tipoRetorno = $tipoRetorno ?? Configuracion::config(
            'TIPO_RETORNO', PIPE::CLASE
        );

        if ($tipoRetorno == PIPE::SQL || $parametros == PIPE::SQL) {
            Error::mostrar(Mensaje::$mensajes['RETORNO_SQL_NO_SOPORTADO']);
        }

        if ($nativa == false) {
            $consulta = $this->_traducirConsultaSQL($consulta);
        }

        if ((strpos($consulta, 'select') >- 1 && strpos($consulta, 'from') >- 1)
            && (strpos($consulta, 'select') < strpos($consulta, 'from'))
        ) {
            return $this->_obtenerDatosConsultaSQL(
                $tipoRetorno, $consulta, $parametros
            );
        } else {
            if (is_array($parametros) && !empty($parametros)) {
                $consulta = Conexion::$conexion->prepare($consulta);

                if ($consulta->execute($parametros)) {
                    return $consulta->rowCount();
                }

                Error::mostrar(
                    $consulta->errorInfo()[1].' - '.$consulta->errorInfo()[2], true
                );
            } else {
                $resultado = Conexion::$conexion->exec($consulta);

                if ($resultado === false) {
                    Error::mostrar(
                        Conexion::$conexion->errorInfo()[1]
                        .' - '.Conexion::$conexion->errorInfo()[2], 
                        true
                    );
                }

                return $resultado;
            }
        }
    }

    /**
     * Traduce una consulta SQL en español a una consulta SQL nativa.
     *
     * @param string $consulta consulta
     * 
     * @return string
     */
    private function _traducirConsultaSQL($consulta)
    {
        // Palabras reservadas para la consulta en español.

        $consultaUsuario = $consulta;
        $consulta = ' '.$consulta.' ';
        $consulta = str_ireplace('seleccionar', ' seleccionar ', $consulta);
        $palabras = explode(' ', $consulta);
        $cantPalabras = count($palabras);

        $clausulas = [
            'select' => 'seleccionar', 'distinct' => 'distinto', '*' => 'todo',
            'as' => 'alias', 'from' => 'de', 'join' => 'unir', 'right' => 'derecha',
            'left' => 'izquierda', 'on' => 'en', 'where' => 'donde', 
            'group' => 'agrupar', 'having' => 'teniendo', 'order' => 'ordenar',
            'limit' => 'limite', 'by' => 'por', 'exists' => 'existe', 'is' => 'es',
            'null' => 'nulo', 'or' => 'o', 'xor' => 'xo', 'and' => 'y',
            'not' => 'no', 'between' => 'entre', 'like' => 'como',
            'insert' => 'insertar', 'into' => 'dentro', 'values' => 'valores',
            'update' => 'actualizar', 'set' => 'asignar', 'delete' => 'eliminar'
        ];

        for ($i = 0; $i < $cantPalabras; $i++) {
            foreach ($clausulas as $clave => $valor) {
                $condicion = $this->validarCadenaIndependiente(
                    $valor, ' '.$palabras[$i].' ', false
                ) && strlen($palabras[$i]) > 0;

                if ($condicion) {
                    $palabras[$i] = str_ireplace(
                        $valor, ' '.$clave.' ', $palabras[$i]
                    );
                }
            }
        }

        $consulta = implode(' ', $palabras);

        // Funciones

        $consulta = str_ireplace('concatenar', 'concat', $consulta);
        $consulta = str_ireplace('promedio', 'avg', $consulta);
        $consulta = str_ireplace('contar', 'count', $consulta);
        $consulta = str_ireplace('maximo', 'max', $consulta);
        $consulta = str_ireplace('minimo', 'min', $consulta);
        $consulta = str_ireplace('suma', 'sum', $consulta);
        $consultaTraducida = $consulta;

        // Traducir solo lo que esta fuera de comillas.

        $partesUsuario = [];
        $partesTraducido = [];

        // Buscamos todo lo que se encuentre dentro de comillas dobles o simples.

        $i = 0;

        while (strpos($consultaUsuario, "'") > -1 
            || strpos($consultaUsuario, '"') > -1
        ) {
            $consultaUsuario = $this->remplazarPrimeraCadena(
                "'", "?$i", $consultaUsuario
            );

            $consultaUsuario = $this->remplazarPrimeraCadena(
                '"', "?$i", $consultaUsuario
            );

            $i++;
        }

        // Guardamos en un arreglo lo que el usuario ingreso dentro de comillas.

        $k = 0;

        for ($j = 0; $j < $i; $j++) {
            $in = $j;
            $fn = $j+1;

            if ($j % 2 == 0) {
                $partesUsuario[$k] = "'".substr(
                    $consultaUsuario, 
                    strpos($consultaUsuario, "?$in") + 2, 
                    (
                        strpos($consultaUsuario, "?$fn") 
                        - strpos($consultaUsuario, "?$in") - 2
                    )
                )."'";

                $k++;
            }
        }

        /**
         * Buscamos todo lo que se encuentre dentro 
         * de comillas dobles o simples en la consulta traducida.
         */

        $i = 0;

        while (strpos($consulta, "'") > -1 || strpos($consulta, '"') > -1) {
            $consulta = $this->remplazarPrimeraCadena("'", "?$i", $consulta);
            $consulta = $this->remplazarPrimeraCadena('"', "?$i", $consulta);
            $i++;
        }

        /**
         * Guardamos en un arreglo lo que se encuentre 
         * dentro de comillas en la consulta traducida.
         */

        $k = 0;

        for ($j = 0; $j < $i; $j++) {
            $in = $j;
            $fn = $j+1;

            if ($j % 2 == 0) {
                $partesTraducido[$k] = substr(
                    $consulta, 
                    strpos($consulta, "?$in") + 2, 
                    (strpos($consulta, "?$fn") - strpos($consulta, "?$in") - 2)
                );

                $k++;
            }
        }

        /**
         * Remplazamos lo que esta dentro de comillas 
         * traducido por lo que ingreso el usuario entre comillas.
         */

        $cantPartesTraducido = count($partesTraducido);

        for ($i = 0; $i < $cantPartesTraducido; $i++) {
            if (strpos($consultaTraducida, "'".$partesTraducido[$i])."'" > -1) {
                $consultaTraducida = str_replace(
                    "'".$partesTraducido[$i]."'", 
                    $partesUsuario[$i], $consultaTraducida
                );
            }

            if (strpos($consultaTraducida, '"'.$partesTraducido[$i]).'"' > -1) {
                $consultaTraducida = str_replace(
                    '"'.$partesTraducido[$i].'"', 
                    $partesUsuario[$i], $consultaTraducida
                );
            }
        }

        return $consultaTraducida;
    }

    /**
     * Obtiene fecha y hora actual según la zona horaria.
     *
     * @return string
     */
    private function _obtenerFechaHoraActual()
    {
        $zonaHoraria = Configuracion::config('ZONA_HORARIA', 'UTC');
        $dateTime = new DateTime($zonaHoraria);

        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * Asigna los datos relacionados a un modelo.
     *
     * @param self   $pipe        pipe
     * @param string $nombre      nombre
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array|null
     */
    private function _obtenerRelacion(self $pipe, $nombre, $tipoRetorno = null)
    {
        $relaciones = [];

        if (!empty($pipe->_atributos['tieneUno'])) {
            if (is_string($pipe->_atributos['tieneUno'])) {
                $pipe->_atributos['tieneUno'] = [
                    $pipe->_atributos['tieneUno'] => null
                ];
            }

            $relacion = $pipe->_obtenerRelacionTieneUno(
                $pipe, $nombre, $tipoRetorno
            );

            $relaciones[$relacion['nombre']] = $relacion['registro'];
        }

        if (!empty($pipe->_atributos['tieneMuchos'])) {
            if (is_string($pipe->_atributos['tieneMuchos'])) {
                $pipe->_atributos['tieneMuchos'] = [
                    $pipe->_atributos['tieneMuchos'] => null
                ];
            }
            $r = null;

            $relacion = $pipe->_obtenerRelacionTieneMuchos(
                $pipe, $nombre, $tipoRetorno
            );

            $relaciones[$relacion['nombre']] = $relacion['registros'];
        }

        if (!empty($pipe->_atributos['perteneceAUno'])) {
            if (is_string($pipe->_atributos['perteneceAUno'])) {
                $pipe->_atributos['perteneceAUno'] = [
                    $pipe->_atributos['perteneceAUno'] => null
                ];
            }

            $relacion = $pipe->_obtenerRelacionPerteneceAUno(
                $pipe, $nombre, $tipoRetorno
            );

            $relaciones[$relacion['nombre']] = $relacion['registro'];
        }

        if (!empty($pipe->_atributos['perteneceAMuchos'])) {
            if (is_string($pipe->_atributos['perteneceAMuchos'])) {
                $pipe->_atributos['perteneceAMuchos'] = [
                    $pipe->_atributos['perteneceAMuchos'] => null
                ];
            }

            $relacion = $pipe->_obtenerRelacionPerteneceAMuchos(
                $pipe, $nombre, $tipoRetorno
            );

            $relaciones[$relacion['nombre']] = $relacion['registros'];
        }

        return $relaciones[$nombre] ?? null;
    }

    /**
     * Asigna los datos de la relación tieneUno en el modelo.
     *
     * @param self   $pipe        pipe
     * @param string $nombre      nombre
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    private function _obtenerRelacionTieneUno(self $pipe, $nombre, $tipoRetorno)
    {
        $atributos = $pipe->_atributos;

        foreach ($atributos['tieneUno'] as $clase => $valores) {
            if (!class_exists($clase)) {
                Error::mostrar(
                    Mensaje::$mensajes['CLASE_NO_ENCONTRADA'].': '.$clase
                );
            }

            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $nombreRelacion = $valores['nombre'] ?? $atributosClaseUnion['tabla'];

            if ($nombre == $nombreRelacion) {
                $llavePrincipal = (
                    $valores['llavePrincipal'] ?? $atributos['llavePrimaria']
                );

                $llaveForanea = substr(
                    Modelo::convertirModeloTabla($atributos['clase']), 0, -1
                );
                $llaveForanea = $valores['llaveForanea'] ?? $llaveForanea.'_id';

                $condiciones = substr($pipe->_condiciones, 7);

                $pipe = PIPE::tabla($pipe->_tabla)
                    ->seleccionar($llavePrincipal)
                    ->donde($condiciones, $pipe->_parametros)
                    ->primero(PIPE::OBJETO);

                $valorllavePrincipal = $pipe->{$llavePrincipal};

                $registro = new self($atributosClaseUnion);
                $registro->donde($llaveForanea.' = ?', [$valorllavePrincipal]);
                $registro = $registro->primero($tipoRetorno);

                return [
                    'nombre' => $nombreRelacion,
                    'registro' => $registro
                ];
            }
        }

        return [
            'nombre' => null,
            'registro' => null
        ];
    }

    /**
     * Asigna los datos de la relación tieneMuchos en el modelo.
     *
     * @param self   $pipe        pipe
     * @param string $nombre      nombre
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    private function _obtenerRelacionTieneMuchos(self $pipe, $nombre, $tipoRetorno)
    {
        $atributos = $pipe->_atributos;

        foreach ($atributos['tieneMuchos'] as $clase => $valores) {
            if (!class_exists($clase)) {
                Error::mostrar(
                    Mensaje::$mensajes['CLASE_NO_ENCONTRADA'].': '.$clase
                );
            }

            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $nombreRelacion = $valores['nombre'] ?? $atributosClaseUnion['tabla'];

            if ($nombre == $nombreRelacion) {
                $llavePrincipal = (
                    $valores['llavePrincipal'] ?? $atributos['llavePrimaria']
                );

                $llaveForanea = substr(
                    Modelo::convertirModeloTabla($atributos['clase']), 0, -1
                );
                $llaveForanea = $valores['llaveForanea'] ?? $llaveForanea.'_id';

                $condiciones = substr($pipe->_condiciones, 7);

                $pipe = PIPE::tabla($pipe->_tabla)
                    ->seleccionar($llavePrincipal)
                    ->donde($condiciones, $pipe->_parametros)
                    ->primero(PIPE::OBJETO);

                $valorllavePrincipal = $pipe->{$llavePrincipal};

                $registros = new self($atributosClaseUnion);
                $registros->donde($llaveForanea.' = ?', [$valorllavePrincipal]);
                $registros = $registros->obtener($tipoRetorno);

                return [
                    'nombre' => $nombreRelacion,
                    'registros' => $registros
                ];
            }
        }

        return [
            'nombre' => null,
            'registros' => null
        ];
    }

    /**
     * Asigna los datos de la relación perteneceAUno en el modelo.
     *
     * @param self   $pipe        pipe
     * @param string $nombre      nombre
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    private function _obtenerRelacionPerteneceAUno(self $pipe, $nombre, $tipoRetorno)
    {
        $atributos = $pipe->_atributos;

        foreach ($atributos['perteneceAUno'] as $clase => $valores) {
            if (!class_exists($clase)) {
                Error::mostrar(
                    Mensaje::$mensajes['CLASE_NO_ENCONTRADA'].': '.$clase
                );
            }

            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);
            $nombreRelacion = $valores['nombre'] ?? $atributosClaseUnion['tabla'];

            if ($nombre == $nombreRelacion) {
                $llavePrincipal = (
                    $valores['llavePrincipal'] 
                        ?? $atributosClaseUnion['llavePrimaria']
                );

                $llaveForanea = substr(
                    Modelo::convertirModeloTabla(
                        $atributosClaseUnion['clase']
                    ), 0, -1
                );
                $llaveForanea = $valores['llaveForanea'] ?? $llaveForanea.'_id';

                $condiciones = substr($pipe->_condiciones, 7);

                $pipe = PIPE::tabla($pipe->_tabla)
                    ->seleccionar($llaveForanea)
                    ->donde($condiciones, $pipe->_parametros)
                    ->primero(PIPE::OBJETO);

                $valorllavePrincipal = $pipe->{$llaveForanea};

                $registro = new self($atributosClaseUnion);
                $registro->donde($llavePrincipal.' = ?', [$valorllavePrincipal]);
                $registro = $registro->primero($tipoRetorno);

                return [
                    'nombre' => $nombreRelacion,
                    'registro' => $registro
                ];
            }
        }

        return [
            'nombre' => null,
            'registro' => null
        ];
    }

    /**
     * Asigna los datos de la relación perteneceAMuchos en el modelo.
     *
     * @param self   $pipe        pipe
     * @param string $nombre      nombre
     * @param string $tipoRetorno tipoRetorno
     * 
     * @return array
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    private function _obtenerRelacionPerteneceAMuchos(
        self $pipe, $nombre, $tipoRetorno
    ) {
        $atributos = $pipe->_atributos;

        foreach ($atributos['perteneceAMuchos'] as $clase => $valores) {
            if (!class_exists($clase)) {
                Error::mostrar(
                    Mensaje::$mensajes['CLASE_NO_ENCONTRADA'].': '.$clase
                );
            }

            $atributosClaseUnion = Modelo::obtenerAtributosClase($clase);

            $modeloLocal = substr(
                Modelo::convertirModeloTabla($atributos['clase']), 0, -1
            );

            $modeloUnion = substr(
                Modelo::convertirModeloTabla(
                    Modelo::obtenerClaseLlamada($clase)
                ), 0, -1
            );

            $modelos = [$modeloLocal, $modeloUnion];
            sort($modelos);

            $tablaUnion = $valores['tablaUnion'] ?? implode('_', $modelos);
            $nombreRelacion = $valores['nombre'] ?? $tablaUnion;

            if ($nombre == $nombreRelacion) {
                $llaveForaneaLocal = (
                    $valores['llaveForaneaLocal'] ?? $modeloLocal.'_id'
                );

                $llaveForaneaUnion = (
                    $valores['llaveForaneaUnion'] ?? $modeloUnion.'_id'
                );

                $condiciones = substr($pipe->_condiciones, 7);

                $registros = new self($atributosClaseUnion);
                $registros->unir(
                    $tablaUnion,
                    $atributosClaseUnion['tabla'].'.'
                    .$atributosClaseUnion['llavePrimaria'],
                    $tablaUnion.'.'.$llaveForaneaUnion
                );
                $registros->donde(
                    $tablaUnion.'.'.$llaveForaneaLocal.' = ?', $pipe->_parametros
                );
                $registros = $registros->obtener($tipoRetorno);

                return [
                    'nombre' => $nombreRelacion,
                    'registros' => $registros
                ];
            }
        }

        return [
            'nombre' => null,
            'registros' => null
        ];
    }

    /**
     * Configura las variables del registro del tiempo.
     *
     * @return void
     */
    private function _configurarRegistroTiempo()
    {
        $tiempo = $this->_atributos['registroTiempo'] === true 
            ? $this->_obtenerFechaHoraActual() : null;

        $this->{$this->_atributos['creadoEn']} = $tiempo;
        $this->{$this->_atributos['actualizadoEn']} = $tiempo;
    }

    /**
     * Obtiene los campos personalizados de insersión.
     *
     * @param array $registro registro
     * 
     * @return string
     */
    private function _obtenerCamposInsercionP($registro)
    {
        $registroFiltrado = $this->_filtrarRegistros(
            $registro, $this->_atributos['insertables']
        );

        $campos = array_keys($registroFiltrado);
        $camposTabla = $this->_obtenerCamposTabla($campos);

        return implode(',', $camposTabla);
    }

    /**
     * Obtiene los parámetros personalizados de insersión.
     *
     * @param array $registro registro
     * 
     * @return string
     */
    private function _obtenerParametrosInsercionP($registro)
    {
        $registroFiltrado = $this->_filtrarRegistros(
            $registro, $this->_atributos['insertables']
        );

        $parametros = '';
        $campos = array_keys($registroFiltrado);
        $camposTabla = $this->_obtenerCamposTabla($campos);

        foreach ($camposTabla as $campo) {
            if ($this->_atributos['llavePrimaria'] == $campo 
                && $registroFiltrado[$campo] === 'default'
            ) {
                $parametros .= $registroFiltrado[$campo].',';
            } else {
                $parametros .= '?,';
            }
        }

        return substr($parametros, 0, -1);
    }

    /**
     * Obtiene los valores personalizados de insersión.
     *
     * @param array $registro registro
     * 
     * @return array
     */
    private function _obtenerValoresInsercionP($registro)
    {
        $registroFiltrado = $this->_filtrarRegistros(
            $registro, $this->_atributos['insertables']
        );

        $valores = [];
        $campos = array_keys($registroFiltrado);
        $camposTabla = $this->_obtenerCamposTabla($campos);

        foreach ($camposTabla as $campo) {
            if (!($this->_atributos['llavePrimaria'] == $campo) 
                || !($registroFiltrado[$campo] === 'default')
            ) {
                if ($this->_atributos['creadoEn'] == $campo
                    || $this->_atributos['actualizadoEn'] == $campo
                ) {
                    $valores[] = $this->_obtenerFechaHoraActual();
                } else {
                    $valores[] = $registroFiltrado[$campo];
                }
            }
        }

        return $valores;
    }

    /**
     * Obtiene los campos de insersión.
     *
     * @return string
     * 
     * @throws \PIPE\Clases\Excepciones\ORM
     */
    private function _obtenerCamposInsercion()
    {
        $camposTabla = $this->_obtenerCamposTabla($this->_atributos['insertables']);

        foreach ($camposTabla as $campo) {
            if (!property_exists($this, $campo)) {
                Error::mostrar(
                    Mensaje::$mensajes['PROPIEDAD_NO_DEFINIDA'].': '.$campo
                );
            }
        }

        return implode(',', $camposTabla);
    }

    /**
     * Obtiene los parámetros de insersión.
     *
     * @return string
     */
    private function _obtenerParametrosInsercion()
    {
        $parametros = '';
        $camposTabla = $this->_obtenerCamposTabla($this->_atributos['insertables']);

        foreach ($camposTabla as $campo) {
            if ($this->_atributos['llavePrimaria'] == $campo 
                && $this->{$campo} === 'default'
            ) {
                $parametros .= $this->{$campo}.',';
            } else {
                $parametros .= '?,';
            }
        }

        return substr($parametros, 0, -1);
    }

    /**
     * Obtiene los valores de insersión.
     *
     * @return array
     */
    private function _obtenerValoresInsercion()
    {
        $valores = [];
        $camposTabla = $this->_obtenerCamposTabla($this->_atributos['insertables']);

        foreach ($camposTabla as $campo) {
            if (!($this->_atributos['llavePrimaria'] == $campo) 
                || !($this->{$campo} === 'default')
            ) {
                $valores[$campo] = $this->{$campo};
            }
        }

        if ($this->_atributos['claseLlamada'] != self::class && $valores) {
            $valores = $this->_mutarRegistros('asignar', [$valores]);
            $valores = array_values($valores[0]);
        } else {
            $valores = array_values($valores);
        }

        return $valores;
    }

    /**
     * Obtiene los parámetros personalizados de actualización.
     *
     * @param array $registro registro
     * 
     * @return string
     */
    private function _obtenerParametrosActualizacionP($registro)
    {
        $registroFiltrado = $this->_filtrarRegistros(
            $registro, $this->_atributos['actualizables']
        );

        if ($this->_atributos['claseLlamada'] != self::class && $registroFiltrado) {
            $registroFiltrado = $this->_mutarRegistros(
                'asignar', [$registroFiltrado]
            );

            $registroFiltrado = $registroFiltrado[0];
        }

        $parametros = '';

        foreach ($registroFiltrado as $campo => $valor) {
            if (is_string($valor)) {
                $valor = "'".$valor."'";
            } elseif (is_null($valor)) {
                $valor = 'null';
            }
            $parametros .= $campo.' = '.$valor.',';
        }

        return substr($parametros, 0, -1);
    }

    /**
     * Obtiene los parámetros de actualización.
     *
     * @return string
     */
    private function _obtenerParametrosActualizacion()
    {
        if (Configuracion::config('BD_CONTROLADOR') == 'sqlsrv') {
            unset($this->{$this->_atributos['llavePrimaria']});
        }

        $camposTabla = $this->_obtenerCamposTabla(
            $this->_atributos['actualizables']
        );

        if ($this->_atributos['claseLlamada'] != self::class) {
            $valores = $this->primero(PIPE::OBJETO);
        } else {
            $consultaSQL = $this->seleccionar(...$camposTabla)->obtener(PIPE::SQL);

            $consulta = Conexion::$conexion->query($consultaSQL);

            $valores = $consulta->fetchAll(PDO::FETCH_OBJ);
            $valores = $valores ? $valores[0] : [];
        }

        $valoresPivote = [];

        foreach ($valores as $clave => $valor) {
            if (property_exists($this, $clave)
                && $this->{$clave} != $valor
            ) {
                $valoresPivote[$clave] = $this->{$clave};
            }
        }

        if ($this->_atributos['claseLlamada'] != self::class && $valoresPivote) {
            $valoresPivote = $this->_mutarRegistros('asignar', [$valoresPivote]);
            $valoresPivote = $valoresPivote[0];
        }

        $parametros = '';

        foreach ($valoresPivote as $clave => $valor) {
            if (is_numeric($valor) || is_string($valor)) {
                $parametros = is_null($valor)
                    ? $parametros.$clave.' = null,'
                    : $parametros.$clave." = '".$valor."',";
            }
        }

        return substr($parametros, 0, -1);
    }

    /**
     * Filtra los registros según los campos habilitados.
     *
     * @param array $registros         registros
     * @param array $camposHabilitados camposHabilitados
     * 
     * @return array
     */
    private function _filtrarRegistros($registros, $camposHabilitados)
    {
        if ($camposHabilitados) {
            $registrosFiltrados = [];

            foreach ($registros as $campo => $valor) {
                foreach ($camposHabilitados as $campoPivote) {
                    if ($campo == $campoPivote) {
                        $registrosFiltrados[$campoPivote] = $valor;
                    }
                }
            }

            return $registrosFiltrados;
        }

        return $registros;
    }

    /**
     * Verifica si los campos del registro del tiempo 
     * están definidos en la tabla de la base de datos.
     *
     * @return boolean
     */
    private function _verificarCamposRegistroTiempo()
    {
        $camposTabla = $this->_obtenerCamposTabla();

        if ($this->_atributos['registroTiempo'] === true 
            && in_array($this->_atributos['creadoEn'], $camposTabla) 
            && in_array($this->_atributos['actualizadoEn'], $camposTabla)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Obtiene el registro de un arreglo el cual contiene un solo elemento.
     *
     * @param array|json $registros   registros
     * @param string     $tipoRetorno tipoRetorno
     * 
     * @return object|array|json|null
     */
    private function _obtenerRegistroArreglo($registros, $tipoRetorno)
    {
        $registrosPivote = $tipoRetorno == PIPE::JSON
            ? json_decode($registros)
            : $registros;

        $conteoRegistros = count($registrosPivote);

        if ($conteoRegistros == 1) {
            $registros = $tipoRetorno == PIPE::JSON
                ? json_encode($registrosPivote[0])
                : $registrosPivote[0];
        } elseif ($conteoRegistros == 0) {
            $registros = null;
        }

        return $registros;
    }

    // Fin métodos privados.
}
