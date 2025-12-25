<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  7.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Migracion;

use PIPE\Configuracion;
use PIPE\Conectores\MySQL;
use PIPE\Conectores\SQLite;
use PIPE\Conectores\SQLServer;
use PIPE\Conectores\PostgreSQL;

class Atributo
{
    /**
     * Tipo de dato entero muy pequeño.
     *
     * @var string
     */
    public const ENTERO_MUY_PEQUENO = 'tinyint';

    /**
     * Tipo de dato entero pequeño.
     *
     * @var string
     */
    public const ENTERO_PEQUENO = 'smallint';

    /**
     * Tipo de dato entero mediano.
     *
     * @var string
     */
    public const ENTERO_MEDIANO = 'mediumint';

    /**
     * Tipo de dato entero.
     *
     * @var string
     */
    public const ENTERO = 'integer';

    /**
     * Tipo de dato entero grande.
     *
     * @var string
     */
    public const ENTERO_GRANDE = 'bigint';

    /**
     * Tipo de dato serial pequeño.
     *
     * @var string
     */
    public const SERIAL_PEQUENO = 'smallserial';

    /**
     * Tipo de dato serial.
     *
     * @var string
     */
    public const SERIAL = 'serial';

    /**
     * Tipo de dato serial grande.
     *
     * @var string
     */
    public const SERIAL_GRANDE = 'bigserial';

    /**
     * Tipo de dato decimal.
     *
     * @var string
     */
    public const DECIMAL = 'decimal';

    /**
     * Tipo de dato numérico.
     *
     * @var string
     */
    public const NUMERICO = 'numeric';

    /**
     * Tipo de dato flotante.
     *
     * @var string
     */
    public const FLOTANTE = 'float';

    /**
     * Tipo de dato doble.
     *
     * @var string
     */
    public const DOBLE = 'double';

    /**
     * Tipo de dato doble precisión.
     *
     * @var string
     */
    public const DOBLE_PRECISION = 'double precision';

    /**
     * Tipo de dato real.
     *
     * @var string
     */
    public const REAL = 'real';

    /**
     * Tipo de dato monetario.
     *
     * @var string
     */
    public const MONETARIO = 'money';

    /**
     * Tipo de dato monetario pequeño.
     *
     * @var string
     */
    public const MONETARIO_PEQUENO = 'smallmoney';

    /**
     * Tipo de dato caracter.
     *
     * @var string
     */
    public const CARACTER = 'char';

    /**
     * Tipo de dato cadena.
     *
     * @var string
     */
    public const CADENA = 'varchar';

    /**
     * Tipo de dato caracter unicode.
     *
     * @var string
     */
    public const N_CARACTER = 'nchar';

    /**
     * Tipo de dato cadena unicode.
     *
     * @var string
     */
    public const N_CADENA = 'nvarchar';

    /**
     * Tipo de dato texto muy pequeño.
     *
     * @var string
     */
    public const TEXTO_MUY_PEQUENO = 'tinytext';

    /**
     * Tipo de dato texto mediano.
     *
     * @var string
     */
    public const TEXTO_MEDIANO = 'mediumtext';

    /**
     * Tipo de dato texto.
     *
     * @var string
     */
    public const TEXTO = 'text';

    /**
     * Tipo de dato texto largo.
     *
     * @var string
     */
    public const TEXTO_LARGO = 'longtext';

    /**
     * Tipo de dato fecha.
     *
     * @var string
     */
    public const FECHA = 'date';

    /**
     * Tipo de dato fecha y hora.
     *
     * @var string
     */
    public const FECHA_HORA = 'datetime';

    /**
     * Tipo de dato fecha y hora 2.
     *
     * @var string
     */
    public const FECHA_HORA_2 = 'datetime2';

    /**
     * Tipo de dato marca de tiempo.
     *
     * @var string
     */
    public const MARCA_TIEMPO = 'timestamp';

    /**
     * Tipo de dato hora.
     *
     * @var string
     */
    public const HORA = 'time';

    /**
     * Tipo de dato año.
     *
     * @var string
     */
    public const ANIO = 'year';

    /**
     * Tipo de dato booleano.
     *
     * @var string
     */
    public const BOOLEANO = 'boolean';

    /**
     * Tipo de dato dígito binario.
     *
     * @var string
     */
    public const DIGITO_BINARIO = 'bit';

    /**
     * Tipo de dato binario.
     *
     * @var string
     */
    public const BINARIO = 'binary';

    /**
     * Tipo de dato binario variable.
     *
     * @var string
     */
    public const BINARIO_VARIABLE = 'varbinary';

    /**
     * Tipo de dato binario grande.
     *
     * @var string
     */
    public const BINARIO_GRANDE = 'blob';

    /**
     * Tipo de dato binario matriz.
     *
     * @var string
     */
    public const BINARIO_MATRIZ = 'bytea';

    /**
     * Tipo de dato coordenada.
     *
     * @var string
     */
    public const COORDENADA = 'point';

    /**
     * Tipo de dato coordenada de cadena de líneas.
     *
     * @var string
     */
    public const COORDENADA_LINEA = 'linestring';

    /**
     * Tipo de dato polígono.
     *
     * @var string
     */
    public const POLIGONO = 'polygon';

    /**
     * Tipo de dato enumerado.
     *
     * @var string
     */
    public const ENUMERADO = 'enum';
    
    /**
     * Tipo de dato conjunto.
     *
     * @var string
     */
    public const CONJUNTO = 'set';

    /**
     * Tipo de dato JSON.
     *
     * @var string
     */
    public const JSON = 'json';

    /**
     * Tipo de dato JSON binario.
     *
     * @var string
     */
    public const JSONB = 'jsonb';

    /**
     * Establece la eliminación de las filas relacionadas en la tabla
     * hija cuando se elimina un registro en la tabla madre.
     *
     * @var string
     */
    public const CASCADA = 'cascade';

    /**
     * Establece el valor de la columna referenciada a NULL
     * cuando se elimina el registro en la tabla madre.
     *
     * @var string
     */
    public const NULO = 'set null';

    /**
     * Establece el valor predeterminado en la columna
     * referenciada cuando se elimina la fila en la tabla madre.
     *
     * @var string
     */
    public const PREDETERMINADO = 'set default';

    /**
     * Impide la eliminación de la fila en la
     * tabla madre si existen registros relacionados.
     *
     * @var string
     */
    public const NO_ACCION = 'no action';

    /**
     * Impide la eliminación de la fila en la
     * tabla madre si existen registros relacionados
     * aplicando la restricción.
     *
     * @var string
     */
    public const RESTRICCION = 'restrict';

    /**
     * Sentencia SQL.
     *
     * @var string
     */
    private $_sentencia = '';

    /**
     * Obtiene la sentencia SQL generada.
     * 
     * @return self
     */
    public function obtenerSentencia()
    {
        return $this->_sentencia;
    }

    /**
     * Establece la llave primaria.
     * 
     * @return self
     */
    public function llavePrimaria()
    {
        $this->_sentencia .= 'primary key ';

        return $this;
    }

    /**
     * Establece que el campo puede ser nulo.
     * 
     * @return self
     */
    public function nulo()
    {
        $this->_sentencia .= 'null ';

        return $this;
    }

    /**
     * Establece que el campo no puede ser nulo.
     * 
     * @return self
     */
    public function noNulo()
    {
        $this->_sentencia .= 'not null ';

        return $this;
    }

    /**
     * Establece que el campo tenga valores irrepetibles.
     * 
     * @return self
     */
    public function unico()
    {
        $this->_sentencia .= 'unique ';

        return $this;
    }

    /**
     * Establece el valor predeterminado del campo.
     * 
     * @param string|int|float|bool $valor valor
     * 
     * @return self
     */
    public function predeterminado($valor)
    {
        if (is_string($valor)) {
            $valor = "'".$valor."'";
        } elseif (is_bool($valor)) {
            $valor = $valor === true ? 'true' : 'false';
        } elseif (is_null($valor)) {
            $valor = 'null';
        }

        $this->_sentencia .= 'default '.$valor.' ';

        return $this;
    }

    /**
     * Establece que el campo solo puede guardar números positivos.
     * 
     * @return self
     */
    public function sinSigno()
    {
        $this->_sentencia .= 'unsigned ';

        return $this;
    }

    /**
     * Establece que el campo tenga un valor de identidad.
     * 
     * @param int $inicio     inicio
     * @param int $incremento incremento
     * 
     * @return self
     */
    public function identidad($inicio = 1, $incremento = 1)
    {
        $this->_sentencia .= 'identity('.$inicio.','.$incremento.') ';

        return $this;
    }

    /**
     * Establece que el campo tenga un valor autoincrementable.
     * 
     * @return self
     */
    public function autoincrementable()
    {
        switch (Configuracion::config('BD_CONTROLADOR')) {
        case 'mysql':
            $this->_sentencia .= MySQL::obtenerAtributoAutoincrementable().' ';
            break;

        case 'pgsql':
            $this->_sentencia .= PostgreSQL::obtenerAtributoAutoincrementable().' ';
            break;

        case 'sqlite':
            $this->_sentencia .= SQLite::obtenerAtributoAutoincrementable().' ';
            break;

        case 'sqlsrv':
            $this->_sentencia .= SQLServer::obtenerAtributoAutoincrementable().' ';
            break;
        }

        return $this;
    }

    /**
     * Establece una condición que debe cumplirse al guardar el dato en el campo.
     * 
     * @param string $condicion condicion
     * 
     * @return self
     */
    public function chequeo($condicion)
    {
        $this->_sentencia .= 'check ('.$condicion.') ';

        return $this;
    }

    /**
     * Establece la intercalación que se aplicará en el campo.
     * 
     * @param string $nombre nombre
     * 
     * @return self
     */
    public function cotejamiento($nombre)
    {
        $this->_sentencia .= 'collate '.$nombre.' ';

        return $this;
    }
}
