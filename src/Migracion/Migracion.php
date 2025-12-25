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

use PIPE\PIPE;
use PIPE\Error;
use PDOException;
use PIPE\Mensaje;
use PIPE\Configuracion;
use PIPE\Conectores\MySQL;
use PIPE\Conectores\SQLite;
use PIPE\Migracion\Atributo;
use PIPE\Conectores\SQLServer;
use PIPE\Conectores\PostgreSQL;

class Migracion
{
    /**
     * Nombre de la tabla.
     *
     * @var array
     */
    private $_tabla = [];

    /**
     * Sentencia SQL.
     *
     * @var string
     */
    private $_sentencia = '';

    /**
     * Motor de almacenamiento.
     *
     * @var string|null
     */
    private $_motor = null;

    /**
     * Espacio de tabla.
     *
     * @var string|null
     */
    private $_espacioTabla = null;

    // Inicio métodos públicos.

    /**
     * Establece el nombre de una o varias tablas.
     *
     * @param string $tabla tabla
     * 
     * @return self
     */
    public static function tabla($tabla)
    {
        $self = new self();

        $self->_tabla = is_array($tabla) ? $tabla : [$tabla];

        return $self;
    }

    /**
     * Establece una restricción a un campo.
     * 
     * @param string $nombre nombre
     * 
     * @return self
     */
    public function restriccion($nombre)
    {
        $this->_sentencia .= 'constraint '.$nombre.' ';

        return $this;
    }

    /**
     * Establece la llave primaria en uno o varios campos.
     *
     * @param string|array $campo campo
     * 
     * @return self
     */
    public function llavePrimaria($campo)
    {
        $campo = is_array($campo) ? $campo : [$campo];
        $campo = implode(',', $campo);

        $this->_sentencia .= 'primary key ('.$campo.'), ';

        return $this;
    }

    /**
     * Establece la llave foránea en un campo.
     *
     * @param string $llaveForanea  llaveForanea
     * @param string $tablaPrimaria tablaPrimaria
     * @param string $llavePrimaria llavePrimaria
     * @param string $alActualizar  alActualizar
     * @param string $alEliminar    alEliminar
     * 
     * @return self
     */
    public function llaveForanea(
        $llaveForanea, $tablaPrimaria, $llavePrimaria,
        $alActualizar = Atributo::NO_ACCION,
        $alEliminar = Atributo::NO_ACCION
    ) {
        $alActualizar = (
                $alActualizar ? ' on update '.$alActualizar.' ' : ''
        );

        $alEliminar = (
            $alEliminar ? ' on delete '.$alEliminar.' ' : ''
        );

        $this->_sentencia .= (
            'foreign key ('.$llaveForanea.') references '
            .$tablaPrimaria.'('.$llavePrimaria.') '
            .$alActualizar.' '
            .$alEliminar.', '
        );

        return $this;
    }

    /**
     * Establece el motor de almacenamiento de la tabla.
     *
     * @param string $nombre nombre
     * 
     * @return self
     */
    public function motor($nombre)
    {
        $this->_motor = 'engine = '.$nombre.' ';

        return $this;
    }

    /**
     * Establece el espacio de tabla.
     *
     * @param string $nombre nombre
     * 
     * @return self
     */
    public function espacioTabla($nombre)
    {
        $this->_espacioTabla = 'tablespace '.$nombre.' ';

        return $this;
    }

    /**
     * Establece el nombre del campo y sus atributos de manera personalizada.
     *
     * @param string $sentencia sentencia
     * 
     * @return self
     */
    public function personalizado($sentencia)
    {
        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Inicio de métodos para representar tipos de dato.

    // Inicio tipos de dato entero.

    /**
     * Establece el nombre del campo de tipo entero muy pequeño.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function enteroMuyPequeno($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENTERO_MUY_PEQUENO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo entero pequeño.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function enteroPequeno($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENTERO_PEQUENO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo entero mediano.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function enteroMediano($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENTERO_MEDIANO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo entero.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function entero($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENTERO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo entero grande.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function enteroGrande($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENTERO_GRANDE, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo serial pequeño.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function serialPequeno($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::SERIAL_PEQUENO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo serial.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function serial($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::SERIAL, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo serial grande.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function serialGrande($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::SERIAL_GRANDE, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato entero.

    // Inicio tipos de dato con decimal.

    /**
     * Establece el nombre del campo de tipo decimal.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function decimal(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::DECIMAL, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo numérico.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function numerico(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::NUMERICO, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo flotante.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function flotante(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::FLOTANTE, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo doble.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function doble(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::DOBLE, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo doble precisión.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function doblePrecision(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::DOBLE_PRECISION, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo real.
     *
     * @param string                        $nombre    nombre
     * @param int|null                      $precision precision
     * @param int|null                      $escala    escala
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * 
     * @return self
     */
    public function real(
        $nombre, $precision = 20, $escala = 2, $atributo = null
    ) {
        $longitud = [];

        if ($precision) {
            $longitud[] = $precision;
        }

        if ($escala) {
            $longitud[] = $escala;
        }

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::REAL, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo monetario.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function monetario(
        $nombre, $atributo = null
    ) {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::MONETARIO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo monetario pequeño.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function monetarioPequeno(
        $nombre, $atributo = null
    ) {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::MONETARIO_PEQUENO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato con decimal.

    // Inicio tipos de dato cadena de texto.

    /**
     * Establece el nombre del campo de tipo carácter.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function caracter($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::CARACTER, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo cadena.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function cadena($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::CADENA, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo carácter unicode.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function nCaracter($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::N_CARACTER, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo cadena unicode.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function nCadena($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::N_CADENA, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo texto muy pequeño.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function textoMuyPequeno($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::TEXTO_MUY_PEQUENO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo texto mediano.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function textoMediano($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::TEXTO_MEDIANO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo texto.
     *
     * @param string                        $nombre   nombre
     * @param int|null                      $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function texto($nombre, $longitud = null, $atributo = null)
    {
        $longitud = $longitud ? [$longitud] : null;

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::TEXTO, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo texto largo.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function textoLargo($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::TEXTO_LARGO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato cadena de texto.

    // Inicio tipos de dato de marca de tiempo.

    /**
     * Establece el nombre del campo de tipo fecha.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function fecha($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::FECHA, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo fecha y hora.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function fechaHora($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::FECHA_HORA, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo fecha y hora 2.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function fechaHora2($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::FECHA_HORA_2, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo marca de tiempo.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function marcaTiempo($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::MARCA_TIEMPO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo hora.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function hora($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::HORA, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo año.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function anio($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ANIO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato de marca de tiempo.

    // Inicio tipos de dato booleano.

    /**
     * Establece el nombre del campo de tipo booleano.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function booleano($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::BOOLEANO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo dígito binario.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function digitoBinario($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::DIGITO_BINARIO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato booleano.

    // Inicio tipos de dato binario.

    /**
     * Establece el nombre del campo de tipo binario.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function binario($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::BINARIO, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo binario variable.
     *
     * @param string                        $nombre   nombre
     * @param int                           $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function binarioVariable($nombre, $longitud = 255, $atributo = null)
    {
        $longitud = [$longitud];

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::BINARIO_VARIABLE, $longitud, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo objeto binario grande.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function binarioGrande($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::BINARIO_GRANDE, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo objeto binario matriz.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function binarioMatriz($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::BINARIO_MATRIZ, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato binario.

    // Inicio tipos de dato geométricos.

    /**
     * Establece el nombre del campo de tipo coordenada.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function coordenada($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::COORDENADA, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo coordenada de cadena de líneas.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function coordenadaLinea($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::COORDENADA_LINEA, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo polígono.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function poligono($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::POLIGONO, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato geométricos.

    // Inicio tipos de dato generales.

    /**
     * Establece el nombre del campo de tipo enumerado.
     *
     * @param string                        $nombre   nombre
     * @param array                         $valores  valores
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function enumerado($nombre, $valores, $atributo = null)
    {
        $valores = array_map(
            function ($elemento) {
                if (is_string($elemento)) {
                    return "'".$elemento."'";
                } elseif (is_bool($elemento)) {
                    return $elemento === true ? 'true' : 'false';
                } elseif (is_null($elemento)) {
                    return 'null';
                }

                return $elemento;
            }, $valores
        );

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::ENUMERADO, $valores, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo conjunto.
     *
     * @param string                        $nombre   nombre
     * @param array                         $valores  valores
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function conjunto($nombre, $valores, $atributo = null)
    {
        $valores = array_map(
            function ($elemento) {
                if (is_string($elemento)) {
                    return "'".$elemento."'";
                } elseif (is_bool($elemento)) {
                    return $elemento === true ? 'true' : 'false';
                } elseif (is_null($elemento)) {
                    return 'null';
                }

                return $elemento;
            }, $valores
        );

        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::CONJUNTO, $valores, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo JSON.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function json($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::JSON, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    /**
     * Establece el nombre del campo de tipo JSON binario.
     *
     * @param string                        $nombre   nombre
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return self
     */
    public function jsonb($nombre, $atributo = null)
    {
        $sentencia = $this->_procesarSentencia(
            $nombre, Atributo::JSONB, null, $atributo
        );

        $this->_sentencia .= trim($sentencia).', ';

        return $this;
    }

    // Fin tipos de dato generales.

    // Fin de métodos para representar tipos de dato.

    // Inicio de métodos para representar las cláusulas crear y borrar.

    /**
     * Crea una tabla en la base de datos.
     *
     * @param bool $siNoExiste siNoExiste
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearTabla($siNoExiste = false)
    {
        try {
            $siNoExiste = $siNoExiste ? ' if not exists ' : '';

            $pdo = PIPE::obtenerPDO();

            $sentencia = substr(trim($this->_sentencia), 0, -1);

            foreach ($this->_tabla as $valor) {    
                $sql = 'create table '.$siNoExiste.$valor.' ('.$sentencia.') ';

                if (isset($this->_motor)) {
                    $sql .= $this->_motor;
                }

                if (isset($this->_espacioTabla)) {
                    $sql .= $this->_espacioTabla;
                }

                $pdo->exec($sql);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra una tabla en la base de datos.
     *
     * @param bool $siExiste siExiste
     * @param bool $cascada  cascada
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarTabla($siExiste = false, $cascada = false)
    {
        try {
            $siExiste = $siExiste ? ' if exists ' : '';

            $cascada = $cascada ? ' '.(Atributo::CASCADA) : '';

            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {
                $pdo->exec(
                    'drop table '.$siExiste.' '.$valor.$cascada
                );
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Crea un índice para uno o varios campos de la tabla.
     *
     * @param string|array $campo  campo
     * @param string|null  $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearIndice($campo, $nombre = null)
    {
        try {
            $campo = is_array($campo) ? $campo : [$campo];
            $campo = implode(',', $campo);

            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {

                $nombre = (
                    $nombre ?? 'indice_'.str_replace(',', '_', $campo)
                );

                $pdo->exec(
                    'create index '.$nombre.' on '.$valor.'('.$campo.')'
                );
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Crea un índice único para uno o varios campos de la tabla.
     *
     * @param string|array $campo  campo
     * @param string|null  $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearIndiceUnico($campo, $nombre = null)
    {
        try {
            $campo = is_array($campo) ? $campo : [$campo];
            $campo = implode(',', $campo);

            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {

                $nombre = (
                    $nombre ?? 'indice_unico_'.str_replace(',', '_', $campo)
                );

                $pdo->exec(
                    'create unique index '.$nombre.' on '.$valor.'('.$campo.')'
                );
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra un índice.
     *
     * @param string $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarIndice($nombre)
    {
        try {
            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {
                switch (Configuracion::config('BD_CONTROLADOR')) {
                case 'mysql':
                    $sql = MySQL::obtenerSentenciaBorrarIndice($nombre, $valor);
                    break;

                case 'pgsql':
                    $sql = PostgreSQL::obtenerSentenciaBorrarIndice($nombre);
                    break;

                case 'sqlite':
                    $sql = SQLite::obtenerSentenciaBorrarIndice($nombre);
                    break;

                case 'sqlsrv':
                    $sql = SQLServer::obtenerSentenciaBorrarIndice($nombre, $valor);
                    break;
                }

                $pdo->exec($sql);
            }    
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra una restricción.
     *
     * @param string $nombre   nombre
     * @param bool   $siExiste siExiste
     * @param bool   $cascada  cascada
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarRestriccion($nombre, $siExiste = false, $cascada = false)
    {
        try {
            $pdo = PIPE::obtenerPDO();

            $siExiste = $siExiste ? ' if exists ' : '';

            $cascada = $cascada ? ' '.(Atributo::CASCADA) : '';

            foreach ($this->_tabla as $valor) {
                $pdo->exec(
                    'alter table '.$valor.' drop constraint '
                    .$siExiste.$nombre.$cascada
                );
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Crea una llave primaria.
     * 
     * @param string|array $campo  campo
     * @param string|null  $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearLlavePrimaria($campo, $nombre = null)
    {
        try {
            $campo = is_array($campo) ? $campo : [$campo];
            $campo = implode(',', $campo);

            $pdo = PIPE::obtenerPDO();

            $nombre = $nombre ? ' constraint '.$nombre.' ' : ' ';

            foreach ($this->_tabla as $valor) {
                $pdo->exec(
                    'alter table '.$valor.' add'.$nombre.'primary key ('.$campo.')'
                );
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra una llave primaria.
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarLlavePrimaria()
    {
        try {
            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {
                $pdo->exec('alter table '.$valor.' drop primary key');
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Crea una llave foránea.
     * 
     * @param string $llaveForanea  llaveForanea
     * @param string $tablaPrimaria tablaPrimaria
     * @param string $llavePrimaria llavePrimaria
     * @param string $nombre        nombre
     * @param string $alActualizar  alActualizar
     * @param string $alEliminar    alEliminar
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearLlaveForanea(
        $llaveForanea, $tablaPrimaria, $llavePrimaria,
        $nombre, $alActualizar = Atributo::NO_ACCION,
        $alEliminar = Atributo::NO_ACCION
    ) {
        try {
            $pdo = PIPE::obtenerPDO();

            $alActualizar = (
                $alActualizar ? ' on update '.$alActualizar.' ' : ''
            );

            $alEliminar = (
                $alEliminar ? ' on delete '.$alEliminar.' ' : ''
            );

            foreach ($this->_tabla as $valor) {
                $sql = 'alter table '.$valor.' add '
                    .'constraint '.$nombre.' '
                    .'foreign key ('.$llaveForanea.') references '
                    .$tablaPrimaria.' ('.$llavePrimaria.') '
                    .$alActualizar.' '
                    .$alEliminar;

                $pdo->exec($sql);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra una llave foránea.
     * 
     * @param string $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarLlaveForanea($nombre)
    {
        try {
            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {
                $pdo->exec('alter table '.$valor.' drop foreign key '.$nombre);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Crea un campo en una tabla.
     * 
     * @param string                        $nombre    nombre
     * @param string                        $tipo      tipo
     * @param \PIPE\Migracion\Atributo|null $atributo  atributo
     * @param array|string|int|float        $longitud  longitud
     * @param string|bool|null              $despuesDe despuesDe
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function crearCampo(
        $nombre, $tipo, $atributo = null, $longitud = 255, $despuesDe = null
    ) {
        try {
            $pdo = PIPE::obtenerPDO();

            $columna = Configuracion::config('BD_CONTROLADOR') != 'sqlsrv'
                ? ' column ' : ' ';

            if ($longitud) {
                if (!is_array($longitud)) {
                    $longitud = [$longitud];
                }

                $longitud = array_map(
                    function ($elemento) {
                        if (is_string($elemento)) {
                            return "'".$elemento."'";
                        } elseif (is_bool($elemento)) {
                            return $elemento === true ? 'true' : 'false';
                        } elseif (is_null($elemento)) {
                            return 'null';
                        }

                        return $elemento;
                    }, $longitud
                );

                $longitud = (
                    is_array($longitud) ? '('.implode(',', $longitud).')' : ''
                );
            } else {
                $longitud = '';
            }

            $atributos = $atributo ? $atributo->obtenerSentencia() : '';

            if ($despuesDe === true) {
                $despuesDe = 'first';
            } elseif (is_string($despuesDe)) {
                $despuesDe = 'after '.$despuesDe;
            } else {
                $despuesDe = '';
            }

            foreach ($this->_tabla as $valor) {
                $sql = (
                    'alter table '.$valor.' add'.$columna
                    .$nombre.' '.$tipo.$longitud.' '.$atributos.' '.$despuesDe
                );

                $pdo->exec($sql);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Cambia un campo de una tabla.
     * 
     * @param string                        $nombreActual nombreActual
     * @param string                        $nombreNuevo  nombreNuevo
     * @param string                        $tipo         tipo
     * @param \PIPE\Migracion\Atributo|null $atributo     atributo
     * @param array|string|int|float|null   $longitud     longitud
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function cambiarCampo(
        $nombreActual, $nombreNuevo, $tipo, $atributo = null, $longitud = null
    ) {
        try {
            $pdo = PIPE::obtenerPDO();

            if ($longitud) {
                if (!is_array($longitud)) {
                    $longitud = [$longitud];
                }

                $longitud = array_map(
                    function ($elemento) {
                        if (is_string($elemento)) {
                            return "'".$elemento."'";
                        } elseif (is_bool($elemento)) {
                            return $elemento === true ? 'true' : 'false';
                        } elseif (is_null($elemento)) {
                            return 'null';
                        }

                        return $elemento;
                    }, $longitud
                );

                $longitud = (
                    is_array($longitud) ? '('.implode(',', $longitud).')' : ''
                );
            } else {
                $longitud = '';
            }

            $tipo = $tipo.$longitud;

            $atributos = $atributo ? $atributo->obtenerSentencia() : '';

            foreach ($this->_tabla as $valor) {
                switch (Configuracion::config('BD_CONTROLADOR')) {
                case 'mysql':
                    $sql = MySQL::obtenerSentenciaCambiarCampo(
                        $valor, $nombreActual, $nombreNuevo, $tipo, $atributos
                    );
                    break;

                case 'pgsql':
                    $sql = PostgreSQL::obtenerSentenciaCambiarCampo(
                        $valor, $nombreActual, $nombreNuevo, $tipo, $atributos
                    );
                    break;

                case 'sqlite':
                    $sql = SQLite::obtenerSentenciaCambiarCampo(
                        $valor, $nombreActual, $nombreNuevo, $tipo, $atributos
                    );
                    break;

                case 'sqlsrv':
                    $sql = SQLServer::obtenerSentenciaCambiarCampo(
                        $valor, $nombreActual, $nombreNuevo, $tipo, $atributos
                    );
                    break;
                }

                $pdo->exec($sql);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    /**
     * Borra un campo de una tabla.
     * 
     * @param string $nombre nombre
     * 
     * @return void
     * 
     * @throws \PIPE\Excepciones\SQL
     */
    public function borrarCampo($nombre)
    {
        try {
            $pdo = PIPE::obtenerPDO();

            foreach ($this->_tabla as $valor) {
                $pdo->exec('alter table '.$valor.' drop column '.$nombre);
            }
        } catch (PDOException $e) {
            Error::mostrar($e->getMessage(), true);
        }
    }

    // Fin de métodos para representar las cláusulas crear y borrar.

    // Fin métodos públicos.

    // Inicio métodos privados.

    /**
     * Procesa la sentencia SQL.
     *
     * @param string                        $nombre   nombre
     * @param string                        $tipo     tipo
     * @param array|null                    $longitud longitud
     * @param \PIPE\Migracion\Atributo|null $atributo atributo
     * 
     * @return string
     * 
     * @throws \PIPE\Excepciones\ORM
     */
    private function _procesarSentencia(
        $nombre, $tipo, $longitud = null, $atributo = null
    ) {
        if ($atributo && !($atributo instanceof Atributo)) {
            Error::mostrar(Mensaje::$mensajes['INSTANCIA_ATRIBUTO_NO_DEFINIDA']);
        }

        $longitud = (
            $longitud && is_array($longitud) ? '('.implode(',', $longitud).')' : ''
        );

        $sentencia = $nombre.' '.$tipo.$longitud.' ';

        if ($atributo) {
            $sentencia .= $atributo->obtenerSentencia().' ';
        }

        return $sentencia;
    }

    // Fin métodos privados.
}
