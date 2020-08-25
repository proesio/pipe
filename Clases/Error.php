<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 24-08-2020
 * Versión: 4.2.6
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

class Error{
    
    use Encadenable;
    
    /*
     * Muestra el error de SQL y detiene la ejecución del script.
     *
     * @parametro string $mensaje
     * @parametro boolean $errorSQL
     * @retorno void
     */
    public static function mostrar($mensaje, $errorSQL = false){
        $self = new self();
        if($errorSQL){
            $idioma = Configuracion::obtenerVariable('IDIOMA');
            if($idioma == 'es'){
                $erroresSQL = $self->obtenerErroresSQL();
                $erroresSQL = $self->ordenarErroresPorLongitud($erroresSQL);
                $mensaje = $self->traducirErrorSQL($erroresSQL, $mensaje);
            }
            $error = $self->formatearError('sql', $mensaje);
        }
        else{
            $error = $self->formatearError('orm', $mensaje);
        }
        exit($error);
    }
    
    //Inicio métodos privados.
    /*
     * Ordena los errores SQL tomando la longitud del mensaje como referencia.
     *
     * @parametro array $errores
     * @retorno array
     */
    private function ordenarErroresPorLongitud($errores){
        $erroresPivote = [];
        $i = 0;
        foreach($errores as $error){
            $longitud = strlen($error['error']);
            $longitud = $longitud.'.'.$i;
            $erroresPivote[$longitud] = $error;
            $i++;
        }
        krsort($erroresPivote);
        return $erroresPivote;
    }
    
    /*
     * Traduce errores SQL.
     *
     * @parametro array $errores
     * @parametro string $mensaje
     * @retorno string
     */
    private function traducirErrorSQL($errores, $mensaje){
        foreach($errores as $error){
            $mensaje = $this->remplazarCadenaIndependiente(
                $error['error'],
                $error['traduccion'],
                $mensaje,
                $error['sensible'] ?? true
            );
        }
        return $mensaje;
    }
    
    /*
     * Formatea el error en formato json.
     *
     * @parametro string $tipo
     * @parametro string $mensaje
     * @retorno json
     */
    private function formatearError($tipo, $mensaje){
        $error['error'] = true;
        $error['tipo'] = $tipo;
        $error['mensaje'] = $mensaje;
        $error = json_encode($error);
        return $error;
    }
    
    /*
     * Obtiene los posibles errores SQL y su traducción.
     *
     * @retorno array
     */
    private function obtenerErroresSQL(){
        return [
            [
                'error' => 'You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near',
                'traduccion' => 'Tienes un error en tu sintaxis sql; consulte el manual que corresponde a la versión de su servidor MariaDB para conocer la sintaxis correcta para usar cerca de'
            ],
            [
                'error' => 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near',
                'traduccion' => 'Tienes un error en tu sintaxis sql; consulte el manual que corresponde a la versión de su servidor MySQL para conocer la sintaxis correcta para usar cerca de'
            ],
            [
                'error' => 'No function matches the given name and argument types. You might need to add explicit type casts.',
                'traduccion' => 'Ninguna función coincide con los tipos de nombre y argumento dados. Es posible que necesite agregar conversiones de tipo explícito.'
            ],
            [
                'error' => 'No operator matches the given name and argument types. You might need to add explicit type casts.',
                'traduccion' => 'Ningún operador coincide con los tipos de nombre y argumento dados. Es posible que necesite agregar conversiones de tipo explícito.'
            ],
            [
                'error'=>"is specified twice, both as a target for 'UPDATE' and as a separate source for data",
                'traduccion'=>"se especifica dos veces, como objetivo para 'ACTUALIZAR' y como fuente separada para datos"
            ],
            [
                'error' => 'Cannot delete or update a parent row: a foreign key constraint fails',
                'traduccion' => 'No se puede actualizar el valor de una llave primaria ni eliminar el registro donde el campo primario este ligado a una llave foránea'
            ],
            [
                'error' => 'Cannot add or update a child row: a foreign key constraint fails',
                'traduccion' => 'No se puede agregar o actualizar una fila secundaria: error en la llave foránea'
            ],
            [
                'error' => 'invalid user.table.column, table.column, or column specification',
                'traduccion' => 'user.table.column, table.column o especificación de columna no válida'
            ],
            [
                'error' => 'unique/primary keys in table referenced by enabled foreign keys',
                'traduccion' => 'llaves únicas / primarias en la tabla referenciada por llaves foráneas habilitadas'
            ],
            [
                'error' => 'Cannot truncate a table referenced in a foreign key constraint',
                'traduccion' => 'No se puede vaciar una tabla a la que se hace referencia en una restricción de llave foránea'
            ],
            [
                'error' => 'cannot truncate a table referenced in a foreign key constraint',
                'traduccion' => 'no se puede vaciar una tabla a la que se hace referencia en una llave foránea'
            ],
            [
                'error' => 'a non-numeric character was found where a numeric was expected',
                'traduccion' => 'se encontró un carácter no numérico donde se esperaba un número'
            ],
            [
                'error' => 'the numeric value does not match the length of the format item',
                'traduccion' => 'el valor numérico no coincide con la longitud del elemento de formato'
            ],
            [
                'error' => 'ERROR:  operator does not exist: character varying',
                'traduccion' => 'ERROR: el operador no existe: carácter variable'
            ],
            [
                'error' => 'argument of WHERE must be type boolean, not type',
                'traduccion' => 'argumento de WHERE debe ser de tipo booleano, no de tipo'
            ],
            [
                'error' => 'could not connect to server: Connection refused',
                'traduccion' => 'no se pudo conectar al servidor: conexión rechazada'
            ],
            [
                'error' => 'duplicate key value violates unique constraint',
                'traduccion' => 'el valor de la llave duplicada viola la restricción única'
            ],
            [
                'error'=>"Column count doesn't match value count at row",
                'traduccion' => 'El conteo de columnas no coincide con el conteo de valores en la fila'
            ],
            [
                'error' => 'ERROR:  unrecognized configuration parameter',
                'traduccion' => 'ERROR: parámetro de configuración no reconocido'
            ],
            [
                'error' => 'input value not long enough for date format',
                'traduccion' => 'el valor de entrada no es lo suficientemente largo para el formato de fecha'
            ],
            [
                'error' => 'Perhaps you meant to reference the column',
                'traduccion' => 'Tal vez deseaste hacer referencia a la columna'
            ],
            [
                'error' => 'has more target columns than expressions',
                'traduccion' => 'tiene más columnas de destino que expresiones'
            ],
            [
                'error' => 'has more expressions than target columns',
                'traduccion' => 'tiene más expresiones que columnas de destino'
            ],
            [
                'error' => 'invalid input syntax for type timestamp:',
                'traduccion' => 'sintaxis de entrada no válida para el registro de tiempo de tipo:'
            ],
            [
                'error' => 'invalid username/password; logon denied',
                'traduccion' => 'usuario/contraseña invalida; inicio de sesión denegado'
            ],
            [
                'error' => 'FROM keyword not found where expected',
                'traduccion' => 'palabra clave FROM no se encuentra donde se esperaba'
            ],
            [
                'error' => 'bad parameter or other API misuse',
                'traduccion' => 'mal parámetro u otro uso incorrecto de la API'
            ],
            [
                'error' => 'Truncated incorrect DOUBLE value:',
                'traduccion' => 'Truncado incorrecto de valor doble:'
            ],
            [
                'error' => 'missing FROM-cláusula entry for',
                'traduccion' => 'falta la entrada de FROM-cláusula para'
            ],
            [
                'error' => 'violates foreign key constraint',
                'traduccion' => 'viola la restricción de llave foránea'
            ],
            [
                'error' => 'field incorrect or syntax error',
                'traduccion' => 'campo incorrecto o error de sintaxis'
            ],
            [
                'error' => 'is still referenced from table',
                'traduccion' => 'todavía está referenciado en la tabla'
            ],
            [
                'error' => 'SQL command not properly ended',
                'traduccion' => 'El comando SQL no ha finalizado correctamente'
            ],
            [
                'error' => 'could not translate host name',
                'traduccion' => 'no se pudo traducir el nombre del host'
            ],
            [
                'error' => 'violated - child record found',
                'traduccion' => 'violado - registro hijo encontrado'
            ],
            [
                'error' => 'syntax error at end of input',
                'traduccion' => 'tienes un error en tu sintaxis sql al final de la entrada'
            ],
            [
                'error' => 'day of month must be between',
                'traduccion' => 'el día del mes debe estar entre'
            ],
            [
                'error'=>"doesn't have a default value",
                'traduccion' => 'no tiene un valor predeterminado'
            ],
            [
                'error' => 'column ambiguously defined',
                'traduccion' => 'columna ambiguamente definida'
            ],
            [
                'error' => 'update or delete on table',
                'traduccion' => 'actualizar o eliminar en la tabla'
            ],
            [
                'error' => 'UNIQUE constraint failed:',
                'traduccion' => 'La restricción ÚNICA ha fallado:'
            ],
            [
                'error' => 'clause is required before',
                'traduccion' => 'cláusula es requerido antes de'
            ],
            [
                'error' => 'at the same time, or use',
                'traduccion' => 'al mismo tiempo, o usar'
            ],
            [
                'error' => 'syntax error at or near',
                'traduccion' => 'tienes un error en tu sintaxis sql cerca de'
            ],
            [
                'error' => 'Not unique table/alias:',
                'traduccion' => 'Tabla/Alias no únicos:'
            ],
            [
                'error' => 'minutes must be between',
                'traduccion' => 'los minutos deben estar entre'
            ],
            [
                'error' => 'seconds must be between',
                'traduccion' => 'los segundos deben estar entre'
            ],
            [
                'error' => 'the database system is starting up',
                'traduccion' => 'el sistema de base de datos se está iniciando'
            ],
            [
                'error' => 'cannot insert NULL into',
                'traduccion' => 'no se puede insertar NULO en'
            ],
            [
                'error' => 'Access denied for user',
                'traduccion' => 'Acceso denegado para el usuario'
            ],
            [
                'error' => 'ambiguous column name:',
                'traduccion' => 'nombre de columna ambiguo:'
            ],
            [
                'error' => 'could not find driver',
                'traduccion' => 'No se pudo encontrar el controlador'
            ],
            [
                'error' => 'invalid SQL statement',
                'traduccion' => 'sentencia SQL inválida'
            ],
            [
                'error' => 'and last day of month',
                'traduccion' => 'y el último día del mes'
            ],
            [
                'error' => 'hour must be between',
                'traduccion' => 'la hora debe estar entre'
            ],
            [
                'error' => 'has no column named',
                'traduccion' => 'no tiene una columna llamada'
            ],
            [
                'error' => 'no such function:',
                'traduccion' => 'no existe dicha función:'
            ],
            [
                'error' => 'not a valid month',
                'traduccion' => 'no es un mes válido'
            ],
            [
                'error' => 'Query was empty',
                'traduccion' => 'La consulta esta vacía'
            ],
            [
                'error' => 'no such column:',
                'traduccion' => 'no existe dicha columna:'
            ],
            [
                'error' => 'does not exist',
                'traduccion' => 'no existe'
            ],
            [
                'error' => 'no such table:',
                'traduccion' => 'no existe dicha tabla:'
            ],
            [
                'error' => 'Undeclared variable:',
                'traduccion' => 'Variable no declarada:'
            ],
            [
                'error' => 'Unknown database',
                'traduccion' => 'Base de datos desconocida'
            ],
            [
                'error' => 'integrity constraint',
                'traduccion' => 'restricción de integridad'
            ],
            [
                'error' => 'unrecognized token:',
                'traduccion' => 'símbolo no reconocido:'
            ],
            [
                'error' => 'missing expression',
                'traduccion' => 'expresión perdida'
            ],
            [
                'error' => 'invalid identifier',
                'traduccion' => 'identificador no válido'
            ],
            [
                'error' => 'column reference',
                'traduccion' => 'la columna de referencia'
            ],
            [
                'error' => 'incomplete input',
                'traduccion' => 'entrada incompleta'
            ],
            [
                'error' => 'Duplicate entry',
                'traduccion' => 'entrada duplicada'
            ],
            [
                'error' => 'already exists.',
                'traduccion' => 'ya existe.'
            ],
            [
                'error' => 'Unknown column',
                'traduccion' => 'columna desconocida'
            ],
            [
                'error'=>"doesn't exist",
                'traduccion' => 'no existe'
            ],
            [
                'error' => 'syntax error',
                'traduccion' => 'error de sintaxis'
            ],
            [
                'error' => 'field list',
                'traduccion' => 'la lista de campos de la tabla'
            ],
            [
                'error' => 'for key',
                'traduccion' => 'para la llave'
            ],
            [
                'error' => 'at line',
                'traduccion' => 'en la línea'
            ],
            [
                'error' => 'cannot be null',
                'traduccion' => 'no puede ser nulo'
            ],
            [
                'error' => 'references',
                'traduccion' => 'referencias'
            ],
            [
                'error' => 'ambiguous',
                'traduccion' => 'ambigua'
            ],
            [
                'error' => 'database',
                'traduccion' => 'base de datos'
            ],
            [
                'error' => 'relation',
                'traduccion' => 'relación'
            ],
            [
                'error' => 'Truncate',
                'traduccion' => 'vaciar'
            ],
            [
                'error' => 'FUNCTION',
                'traduccion' => 'FUNCIÓN',
                'sensible'=>false
            ],
            [
                'error' => 'address:',
                'traduccion' => 'dirección:'
            ],
            [
                'error' => 'sequence',
                'traduccion' => 'secuencia'
            ],
            [
                'error' => 'DETAIL:',
                'traduccion' => 'DETALLE:'
            ],
            [
                'error' => 'unknown',
                'traduccion' => 'desconocido',
                'sensible'=>false
            ],
            [
                'error' => 'columns',
                'traduccion' => 'columnas',
                'sensible'=>false
            ],
            [
                'error' => 'clause',
                'traduccion' => 'cláusula'
            ],
            [
                'error' => 'column',
                'traduccion' => 'la columna',
                'sensible'=>false
            ],
            [
                'error' => 'values',
                'traduccion' => 'valores'
            ],
            [
                'error' => 'HINT:',
                'traduccion' => 'PISTA:'
            ],
            [
                'error' => 'field',
                'traduccion' => 'campo',
                'sensible'=>false
            ],
            [
                'error' => 'value',
                'traduccion' => 'valor'
            ],
            [
                'error' => 'table',
                'traduccion' => 'la tabla',
                'sensible'=>false
            ],
            [
                'error' => 'LINE',
                'traduccion' => 'LÍNEA'
            ],
            [
                'error' => 'role',
                'traduccion' => 'rol'
            ],
            [
                'error' => 'view',
                'traduccion' => 'vista'
            ],
            [
                'error' => 'near',
                'traduccion' => 'cerca de'
            ],
            [
                'error' => 'key',
                'traduccion' => 'llave',
                'sensible'=>false
            ],
            [
                'error' => 'for',
                'traduccion' => 'para',
                'sensible'=>false
            ],
            [
                'error' => 'and',
                'traduccion' => 'y'
            ],
            [
                'error' => 'is',
                'traduccion' => 'es'
            ],
            [
                'error' => 'in',
                'traduccion' => 'en'
            ],
            [
                'error' => 'of',
                'traduccion' => 'de'
            ],
            [
                'error' => 'to',
                'traduccion' => 'a'
            ],
            [
                'error' => 'on',
                'traduccion' => 'en'
            ],
            [
                'error' => 'or',
                'traduccion' => 'o'
            ],
            [
                'error' => 'a',
                'traduccion' => 'un'
            ]
        ];
    }
    //Fin métodos privados.
}