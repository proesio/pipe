<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 13-09-2018
 * Fecha última modificación: 06-03-2020
 * Versión: 2.8.0
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
return [
	'INSTANCIAR_NO_PERMITIDO'=>'El método <b>instanciar()</b> solo puede ser usado por <b>clases (modelos)</b> que hacen referencia a una tabla en la base de datos.',
	'INSERTAR_OBTENER_ID_NO_SOPORTADO'=>'El método <b>insertarObtenerId()</b> no soporta el controlador <b>oci</b>.',
	'AMBIGUEDAD_DE_CAMPOS'=>'Ambiguedad de campos en la consulta SQL. Verifique la pertenencia de los campos a su respectiva tabla y asigne un alias a cada campo donde el nombre sea igual en otra tabla.',
	'CONTROLADOR_DESCONOCIDO'=>' desconocido.<br><br>Controladores admitidos: mysql, pgsql, sqlite, oci, sqlsrv.',
	'CONSTANTES_REQUERIDAS'=>'Las siguientes constantes deben estar definidas en el archivo de configuración <b>Config/basedatos.php</b><br><br>BD_CONTROLADOR<br>BD_HOST<br>BD_PUERTO<br>BD_USUARIO<br>BD_CONTRASENA<br>BD_BASEDATOS<br>BD_CODIFICACION',
	'CONSULTA_NO_PERMITIDO'=>'El método <b>consulta()</b> solo puede ser usado directamente por el constructor de consultas <b>PIPE</b>.',
	'CONSULTA_NATIVA_NO_PERMITIDO'=>'El método <b>consultaNativa()</b> solo puede ser usado directamente por el constructor de consultas <b>PIPE</b>.',
	'TABLA_NO_DEFINIDA'=>'Debe definir una tabla de la base de datos para usar el método ',
	'MODELO_NO_ENCONTRADO'=>'El siguiente modelo no fue encontrado en <em>PIPE/Modelos/</em>: ',
	'TIPO_DATO_DESCONOCIDO'=>'El siguiente tipo de dato es desconocido: '
];