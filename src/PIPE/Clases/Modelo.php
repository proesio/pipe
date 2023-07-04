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

abstract class Modelo
{
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
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function alias($alias)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->alias(...func_get_args());
    }

    /**
     * Obtiene todos los registros de la tabla seleccionada.
     *
     * @param array|string $campos      campos
     * @param string|null  $tipoRetorno tipoRetorno
     * 
     * @return array|json|string
     */
    public static function todo($campos = [], $tipoRetorno = null)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->todo(...func_get_args());
    }

    /**
     * Establece los campos que serán seleccionados.
     *
     * @param array|mixed $campos campos
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function seleccionar($campos = ['*'])
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->seleccionar(...func_get_args());
    }

    /**
     * Elimina duplicados del conjunto de resultados.
     *
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function distinto()
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->distinto(...func_get_args());
    }

    /**
     * Combina registros de una o más tablas relacionadas.
     *
     * @param string      $tablaUnion    tablaUnion
     * @param string      $llaveForanea  llaveForanea
     * @param string      $union         union
     * @param string|null $llavePrimaria llavePrimaria
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function unir(
        $tablaUnion, $llaveForanea, $union, $llavePrimaria = null
    ) {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->unir(...func_get_args());
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
    public static function unirDerecha(
        $tablaUnion, $llaveForanea, $union, $llavePrimaria = null
    ) {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->unirDerecha(...func_get_args());
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
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function unirIzquierda(
        $tablaUnion, $llaveForanea, $union, $llavePrimaria = null
    ) {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->unirIzquierda(...func_get_args());
    }

    /**
     * Establece una condición con cláusula where en la consulta SQL.
     *
     * @param string $condicion  condicion
     * @param array  $parametros parametros
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function donde($condicion, $parametros = [])
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->donde(...func_get_args());
    }

    /**
     * Agrupa registros que tienen los mismos valores.
     *
     * @param string|array $grupos grupos
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function agruparPor($grupos)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->agruparPor(...func_get_args());
    }

    /**
     * Establece una condición a una función de agregación con la cláusula having.
     *
     * @param string $condicion condicion
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function teniendo($condicion)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->teniendo(...func_get_args());
    }

    /**
     * Ordena el resultado de la consulta SQL.
     *
     * @param string|array $ordenes ordenes
     * @param string       $tipo    tipo
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function ordenarPor($ordenes, $tipo = 'asc')
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->ordenarPor(...func_get_args());
    }

    /**
     * Limita el número de registros retornados en la consulta SQL.
     *
     * @param int      $inicio   inicio
     * @param int|null $cantidad cantidad
     * 
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function limite($inicio, $cantidad = null)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->limite(...func_get_args());
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
    public static function primero($limite = 1, $tipoRetorno = null)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->primero(...func_get_args());
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
    public static function ultimo(
        $llavePrimaria = 'id', $limite = 1, $tipoRetorno = null
    ) {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->ultimo(...func_get_args());
    }

    /**
     * Obtiene la cantidad general o específica de registros retornados.
     *
     * @param string $campo campo
     * 
     * @return int
     */
    public static function contar($campo = '*')
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->contar(...func_get_args());
    }

    /**
     * Obtiene el valor máximo del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public static function maximo($campo)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->maximo(...func_get_args());
    }

    /**
     * Obtiene el valor mímino del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public static function minimo($campo)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->minimo(...func_get_args());
    }

    /**
     * Obtiene el valor promedio del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public static function promedio($campo)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->promedio(...func_get_args());
    }

    /**
     * Obtiene la suma del campo especificado.
     *
     * @param string $campo campo
     * 
     * @return mixed
     */
    public static function suma($campo)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->suma(...func_get_args());
    }

    /**
     * Verifica que la consulta SQL ha retornado un resultado.
     *
     * @return boolean
     */
    public static function existe()
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->existe(...func_get_args());
    }

    /**
     * Verifica que la consulta SQL no ha retornado un resultado.
     *
     * @return boolean
     */
    public static function noExiste()
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->noExiste(...func_get_args());
    }

    /**
     * Incrementa el valor del campo especificado.
     *
     * @param string $campo      campo
     * @param int    $incremento incremento
     * 
     * @return mixed
     */
    public static function incrementar($campo, $incremento = 1)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->incrementar(...func_get_args());
    }

    /**
     * Decrementa el valor del campo especificado.
     *
     * @param string $campo      campo
     * @param int    $decremento decremento
     * 
     * @return mixed
     */
    public static function decrementar($campo, $decremento = 1)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->decrementar(...func_get_args());
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
    public static function encontrar($valor = [], $llavePrimaria = 'id')
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->encontrar(...func_get_args());
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
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        foreach ($this as $clave => $valor) {
            if (!property_exists($pipe, $clave)) {
                $pipe->$clave = $valor;
            }
        }

        return $pipe->insertar(...func_get_args());
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
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        foreach ($this as $clave => $valor) {
            if (!property_exists($pipe, $clave)) {
                $pipe->$clave = $valor;
            }
        }

        return $pipe->insertarObtenerId(...func_get_args());
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param array $registro registro
     * 
     * @return int
     */
    public static function actualizar($registro = [])
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->actualizar(...func_get_args());
    }

    /**
     * Actualiza o inserta un nuevo registro en la base de datos.
     *
     * @param array $atributos atributos
     * @param array $valores   valores
     * 
     * @return int
     */
    public static function actualizarOInsertar($atributos, $valores = [])
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->actualizarOInsertar(...func_get_args());
    }

    /**
     * Elimina un registro en la base de datos.
     *
     * @return int
     */
    public static function eliminar()
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->eliminar(...func_get_args());
    }

    /**
     * Elimina todos los registros en la tabla y reinicia 
     * el contador auto incrementable.
     *
     * @param boolean $forzado forzado
     * 
     * @return boolean
     */
    public static function vaciar($forzado = false)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->vaciar(...func_get_args());
    }

    // Fin instrucciones insertar, actualizar, eliminar y vaciar.

    // Inicio instrucciones crear, editar y destruir.

    /**
     * Crea un nuevo registro en la base de datos y obtiene el objeto creado.
     *
     * @param array $registros registros
     * 
     * @return object|array
     */
    public static function crear($registros)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);
        $registros = $pipe->obtenerRegistrosInsertar($registros);

        $inserciones = [];

        foreach ($registros as $registro) {
            $id = $pipe->insertarObtenerId($registro);
            $inserciones[] = clone $pipe->encontrar($id);
        }

        if ($inserciones && count($inserciones) == 1) {
            $inserciones = $inserciones[0];
        }

        return $inserciones;
    }

    /**
     * Edita un registro en la base de datos y obtiene el objeto editado.
     *
     * @param array|int|string $ids     ids
     * @param array            $valores valores
     * 
     * @return object|array
     */
    public static function editar($ids, $valores)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);
        $ids = is_array($ids) ? $ids : [$ids];

        $actualizaciones = [];

        foreach ($ids as $id) {
            $pipe->donde($atributosClase['llavePrimaria'].' = ?', [$id]);

            if ($pipe->existe()) {
                $pipe->actualizar($valores);
                $actualizaciones[] = clone $pipe->encontrar($id);
            } else {
                $actualizaciones[] = null;
            }
        }

        if ($actualizaciones && count($actualizaciones) == 1) {
            $actualizaciones = $actualizaciones[0];
        }

        return $actualizaciones;
    }

    /**
     * Destruye un registro en la base de datos y obtiene el objeto destruido.
     *
     * @param array|int|string $ids ids
     * 
     * @return object|array
     */
    public static function destruir($ids)
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);
        $ids = is_array($ids) ? $ids : [$ids];

        $eliminaciones = [];

        foreach ($ids as $id) {
            $pipe->donde($atributosClase['llavePrimaria'].' = ?', [$id]);

            if ($pipe->existe()) {
                $eliminaciones[] = clone $pipe->encontrar($id);
                $pipe->eliminar();
            } else {
                $eliminaciones[] = null;
            }
        }

        if ($eliminaciones && count($eliminaciones) == 1) {
            $eliminaciones = $eliminaciones[0];
        }

        return $eliminaciones;
    }

    // Fin instrucciones crear, editar y destruir.

    /**
     * Establece los datos relacionados a un modelo 
     * que se obtendrán junto a los resultados de la consulta SQL.
     *
     * @return \PIPE\Clases\ConstructorConsulta
     */
    public static function relaciones()
    {
        $atributosClase = self::obtenerAtributosClase(get_called_class());
        $pipe = new ConstructorConsulta($atributosClase);

        return $pipe->relaciones(...func_get_args());
    }

    /**
     * Obtiene los atributos de la clase (modelo) instanciada.
     *
     * @param string $claseLlamada claseLlamada
     * 
     * @return array
     */
    public static function obtenerAtributosClase($claseLlamada)
    {
        $atributosClase = get_class_vars($claseLlamada);
        $modelo = self::obtenerClaseLlamada($claseLlamada);
        $tabla = self::convertirModeloTabla($modelo);

        return [
            'conexion' => $atributosClase['conexion'] ?? null,
            'claseLlamada' => $claseLlamada,
            'clase' => $modelo,
            'tabla' => $atributosClase['tabla'] ?? $tabla,
            'llavePrimaria' => $atributosClase['llavePrimaria'] ?? 'id',
            'registroTiempo' => $atributosClase['registroTiempo'] ?? true,
            'creadoEn' => $atributosClase['creadoEn'] ?? 'creado_en',
            'actualizadoEn' => $atributosClase['actualizadoEn'] ?? 'actualizado_en',
            'tieneUno' => $atributosClase['tieneUno'] ?? [],
            'tieneMuchos' => $atributosClase['tieneMuchos'] ?? [],
            'perteneceAUno' => $atributosClase['perteneceAUno'] ?? [],
            'perteneceAMuchos' => $atributosClase['perteneceAMuchos'] ?? [],
            'insertables' => $atributosClase['insertables'] ?? [],
            'actualizables' => $atributosClase['actualizables'] ?? [],
            'visibles' => $atributosClase['visibles'] ?? [],
            'ocultos' => $atributosClase['ocultos'] ?? []
        ];
    }

    /**
     * Obtiene el nombre de la clase instanciada que ha hecho la invocación.
     *
     * @param string $nombreCompleto nombreCompleto
     * 
     * @return string
     */
    public static function obtenerClaseLlamada($nombreCompleto)
    {
        $partesClase = explode('\\', $nombreCompleto);
        return $partesClase[count($partesClase) - 1];
    }

    /**
     * Convierte el nombre del modelo (clase) 
     * en el nombre de la tabla de la base de datos.
     *
     * @param string $modelo modelo
     * 
     * @return string
     */
    public static function convertirModeloTabla($modelo)
    {
        $alfabeto = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];

        $letras = str_split($modelo);

        foreach ($alfabeto as $alfa) {
            foreach ($letras as $letra) {
                if ($letra == $alfa) {
                    $modelo = str_replace($letra, '_'.$letra, $modelo);
                    break;
                }
            }
        }

        return strtolower(substr($modelo, 1).'s');
    }

    // Fin métodos públicos.
}
