# Registro de cambios

Todos los cambios notables en este proyecto se documentarán en este archivo.

## [v7.0.0](https://github.com/proesio/pipe/compare/v6.0.0...v7.0.0) - 2025-12-25

- Implementación de soporte para <code>PHP</code> 8.2 o superior.
- Implementación de migraciones.
- Implementación de método <code>obtenerClave</code> para obtener los datos asignando una o varias claves personalizadas.
- Implementación de método <code>extraer</code> para obtener el valor de una clave seleccionada.
- Implementación de método <code>obtenerConexion</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerTabla</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerLlavePrimaria</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerRegistroTiempo</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerCreadoEn</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerActualizadoEn</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerEliminadoEn</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerEliminacionSuave</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerTieneUno</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerTieneMuchos</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerPerteneceAUno</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerPerteneceAMuchos</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerInsertables</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerActualizables</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerVisibles</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerOcultos</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de método <code>obtenerPropiedadesModelo</code> en la clase <code>PIPE\Modelo</code>.
- Implementación de archivo CHANGELOG.md.
- Actualización de espacio de nombre <code>PIPE\Clases</code> por <code>PIPE</code>.
- Actualización de excepción <code>Exception</code> por <code>PIPE\Excepciones\ORM</code> en el método <code>inicializar</code> de la clase <code>PIPE\Configuracion</code>.
- Actualización de palabra reservada <code>boolean</code> por <code>bool</code>.
- Eliminación de método <code>_incluirArchivos</code> de la clase <code>PIPE\Configuracion</code>.
- Solución de error al momento de asignar un valor nulo en el método <code>_obtenerParametrosActualizacion</code> de la clase <code>PIPE\ConstructorConsulta</code>.

## [v6.0.0](https://github.com/proesio/pipe/compare/v5.1.6...v6.0.0) - 2025-07-17

- Implementación de soporte para <code>PHP</code> 8.1 o superior.
- Implementación de eliminación de registros de forma suave.
- Implementación de método <code>restaurar</code> para habilitar los registros eliminados de forma suave.
- Implementación de propiedad <code>BD_DATOS_DSN</code> en el método <code>inicializar</code> de la clase <code>PIPE\Clases\Configuracion</code>.
- Implementación de importación de modelos por medio de la propiedad <code>RUTA_MODELOS</code> de la clase <code>PIPE\Clases\Configuracion</code> desde una carpeta en forma recursiva.
- Envío de la clase <code>Encadenable</code> desde la carpeta <code>PIPE\Rasgos</code> hacia la carpeta <code>PIPE\Clases\Rasgos</code>.
- Formateo de código para la clase <code>PIPE\Clases\Rasgos\Encadenable</code>.
- Actualización de migraciones <code>SQL</code> para el entorno de pruebas.

## [v5.1.6](https://github.com/proesio/pipe/compare/v5.1.4...v5.1.6) - 2024-02-28

- Actualización de función <code>get_class_vars</code> por método <code>ReflectionClass::getProperties</code> en el método <code>obtenerPropiedadesClase</code> de la clase <code>PIPE\Clases\Modelo</code>.
- Actualización de variables con nombre atributo por nombre propiedad.

## [v5.1.4](https://github.com/proesio/pipe/compare/v5.1.1...v5.1.4) - 2024-02-20

- Implementación de atributo <code>AllowDynamicProperties</code> en la clase <code>PIPE\Clases\ConstructorConsulta</code>, <code>Modelos\Documento</code> y <code>Modelos\Telefono</code>.
- Actualización de método deprecado <code>assertObjectHasAttribute</code> y <code>assertObjectNotHasAttribute</code> por <code>assertObjectHasProperty</code> y <code>assertObjectNotHasProperty</code> respectivamente en la nueva versión de PHPUnit. 
- Actualización de propiedad <code>minimum-stability</code> con valor de dev a stable en el archivo <code>composer.json</code>.

## [v5.1.1](https://github.com/proesio/pipe/compare/v5.1.0...v5.1.1) - 2023-07-03

- Implementación de archivo <code>.gitattributes</code>.

## [v5.1.0](https://github.com/proesio/pipe/compare/v5.0.5...v5.1.0) - 2023-02-08

- Implementación de mutadores de datos en la creación, edición y consulta general por medio del modelo.
- Actualización de método <code>insertar</code>, mejorando algoritmo para la velocidad en la inserción de múltiples registros simultáneamente.
- Actualización de método <code>existe</code>, mejorando algoritmo para la velocidad.
- Actualización de método <code>noExiste</code>, mejorando algoritmo para la velocidad.

## [v5.0.5](https://github.com/proesio/pipe/compare/v5.0.2...v5.0.5) - 2022-02-09

- Implementación de archivo <code>config.prod.php</code> para base de configuración en el directorio de pruebas.
- Actualización de nombre de parámetros en el método <code>limite</code> de la clase <code>ConstructorConsulta</code>.
- Eliminación de instancia redundante del constructor de consultas en el método <code>destruir</code> de la clase <code>Modelo</code>.

## [v5.0.2](https://github.com/proesio/pipe/compare/v5.0.0...v5.0.2) - 2021-11-22

- Solución de error al momento de definir un alias con el método <code>alias</code> de la clase <code>ConstructorConsulta</code>.
- Solución de error al momento de definir una llave primaria en el método <code>encontrar</code> y <code>ultimo</code> de la clase <code>ConstructorConsulta</code>.

## [v5.0.0](https://github.com/proesio/pipe/compare/v4.3.2...v5.0.0) - 2021-11-21

- Implementación de <code>COMANDO_INICIAL</code>, <code>TIPO_RETORNO</code>, y <code>OPCIONES</code> en el método <code>inicializar</code> de la clase <code>Configuracion</code>.
- Implementación de múltiples conexiones de bases de datos en el método <code>inicializar</code> de la clase <code>Configuracion</code>.
- Implementación de definición de conexión predeterminada cuando se ha inicializado la configuración con múltiples conexiones en el método <code>inicializar</code> de la clase <code>Configuracion</code>.
- Implementación de obtención del registro único cuando el arreglo contiene un solo elemento en los métodos <code>primero</code> y <code>ultimo</code> de la clase <code>ConstructorConsulta</code>.
- Implementación de tipo de retorno <code>CLASE</code>.
- Implementación de soporte de método límite para el controlador <code>sqlsrv</code>.
- Implementación de definición de nombre de relación en las propiedades <code>tieneUno</code>, <code>tieneMuchos</code>, <code>perteneceAUno</code> y <code>perteneceAMuchos</code> en el modelo.
- Implementación de método <code>relacionar</code> para cargar los datos relacionados a una instancia de un modelo.
- Implementación de método <code>sentenciaNativa</code>.
- Implementación de excepciones por medio de la clase <code>ORM</code>, <code>SQL</code> y <code>Exception</code>.
- Implementación de mejora de rendimiendo al obtener una consulta SQL.
- Implementación de pruebas con PHPUnit.
- Implementación de estándares de codificación basados en PHP PEAR2.
- Actualización de método <code>relaciones</code> para definición de datos relacionados antes de cargar el resultado de la consulta SQL.
- Eliminación de <code>BD_CODIFICACION</code> en el método <code>inicializar</code> de la clase <code>Configuracion</code>.
- Eliminación de validación <code>AMBIGUEDAD_DE_CAMPOS</code> en el método <code>obtenerDatosConsultaSQL</code> de la clase <code>ConstructorConsulta</code>.
- Eliminación de método <code>convertirValorNumerico</code>, <code>convertirRegistrosTipo</code> y <code>tomar</code> de la clase <code>ConstructorConsulta</code>.
- Eliminación de método <code>decodificarCadenaUTF8</code> del rasgo <code>Encadenable</code>.
- Eliminación de mensaje <code>METODO_LIMITE_NO_SOPORTADO</code>.
- Implementación de parámetro booleano para forzar el vaciado de tabla en el método <code>vaciar</code> de la clase <code>ConstructorConsulta</code>.

## [v4.3.2](https://github.com/proesio/pipe/compare/v4.2.6...v4.3.2) - 2020-08-27

- Implementación de múltiples inserciones por medio de una matriz de arreglos en el método <code>insertar()</code> y <code>crear()</code>.
- Validación de la existencia de la tabla especificada en la base de datos.
- Solución de error al momento de convertir los datos a formato <code>JSON</code> cuando la consulta obtiene caracteres mal formados.

## [v4.2.6](https://github.com/proesio/pipe/compare/v4.2.3...v4.2.6) - 2020-08-24

- Actualización de <code>require</code> a <code>require_once</code> en el archivo <code>pipe.php</code> y las clases <code>Archivo</code> y <code>Configuracion</code> para permitir múltiples instancias del ORM PIPE.
- Actualización de métodos <code>agruparPor()</code>, <code>ordenarPor()</code>, <code>actualizar()</code>, <code>configurarRegistroTiempo()</code> y <code>validarCadenaIndependiente()</code> en la clase <code>ConstructorConsulta</code> y el rasgo (trait) <code>Encadenable</code> para mejora del rendimiento.
- Implementación de indentación de tabulado a 4 espacios en el código fuente.

## [v4.2.3](https://github.com/proesio/pipe/compare/v4.2.0...v4.2.3) - 2020-07-05

- Implementación de rasgo (trait) <code>Encadenable</code> para reutilizar los métodos de encadenación.
- Implementación de clase <code>Error</code> para manejar errores del ORM y SQL.
- Traducción de errores SQL.

## [v4.2.0](https://github.com/proesio/pipe/compare/v4.1.2...v4.2.0) - 2020-05-13

- Implementación del método <code>obtenerPDO()</code> en la clase <code>PIPE</code>.

## [v4.1.2](https://github.com/proesio/pipe/compare/v4.0.0...v4.1.2) - 2020-05-05

- Implementación de propiedadad <code>$visibles</code> en la clase <code>ConstructorConsulta</code> para definir los campos que se mostrarán en la consulta SQL.
- Eliminación de propiedades <code>_llavePrimaria37812_</code> y <code>_valor37812_</code> que se generaban en el método <code>encontrar()</code>.
- Solución de error al momento de obtener parámetros de actualización no definidos en el método <code>obtenerParametrosActualizacion()</code> de la clase <code>ConstructorConsulta</code>.

## [v4.0.0](https://github.com/proesio/pipe/compare/v3.1.3...v4.0.0) - 2020-04-28

- Implementación del método <code>sentencia()</code> en la clase <code>PIPE.</code>
- Implementación del método <code>tomar()</code> en la clase <code>ConstructorConsulta</code> como alternativa del método <code>limite()</code> para el controlador <code>sqlsrv</code>.
- Implementación de propiedades <code>$insertables</code>, <code>$actualizables</code> y <code>$ocultos</code> en la clase <code>ConstructorConsulta</code> para la gestión en la manipulación de los datos.
- Implementación de constante <code>SQL</code> en la clase <code>ConstructorConsulta</code> y <code>PIPE</code> para obtener la consulta generada.
- Eliminación del método <code>instanciar()</code> debido a que se actualizó la forma de insertar, actualizar y eliminar.
- Eliminación de soporte para oracle debido a que <code>PDO</code> no es compatible con algunas funciones respecto a los otros gestores de bases de datos.
- Refactorización para optimización general.
- Traducción de errores SQL.

## [v3.1.3](https://github.com/proesio/pipe/compare/v3.0.0...v3.1.3) - 2020-03-29

- Implementación de propiedades <code>$creadoEn</code> y <code>$actualizadoEn</code> en la clase <code>ConstructorConsulta</code> para definir los campos del registro del tiempo.
- Refactorización de la forma de retornar el nuevo objeto <code>PIPE</code> en los métodos para construir una consulta SQL.
- Solución de error al concatenar <code>right join</code> y <code>left join</code> en los métodos <code>unirDerecha()</code> y <code>unirIzquierda()</code> de la clase <code>ConstructorConsulta</code>.
- Solución de error al definir la tabla en el método <code>autenticar()</code> de la clase <code>ConstructorConsulta</code>.

## [v3.0.0](https://github.com/proesio/pipe/compare/8275beb7cfbfc557186d943305728e491cffc548...v3.0.0) - 2020-03-23

- Implementación de configuración global en el método estático <code>inicializar()</code> de la clase <code>Configuracion</code>.
- Implementación de ubicación de modelos en directorio personalizado por medio de la constante <code>RUTA_MODELOS</code>.
- Implementación de zona horaria global por medio de la constante <code>ZONA_HORARIA</code> quitando la configuración en el modelo.
- Implementación de métodos <code>crear()</code>, <code>editar()</code> y <code>destruir()</code> en la clase <code>Modelo</code>.
- Solución de error cuando la relación con el modelo no tiene datos en el método <code>asignarDatosModeloRelacion()</code> de la clase <code>ConstructorConsulta</code>.
- Implementación de mensaje <code>RUTA_MODELOS_NO_ENCONTRADA</code>.
- Optimización de métodos <code>remplazarPrimeraCadena()</code>, <code>remplazarCadenaIndependiente()</code> y <code>obtenerCamposConsultaSQL()</code>.
- Implementación de archivo README.md.
- Implementación de archivo composer.json para permitir la descarga por medio de composer.

## [v2.8.0](https://github.com/proesio/pipe/compare/670e368e7b4d1ebaf89a8af3dcc98bb65a97cac6...8275beb7cfbfc557186d943305728e491cffc548) - 2020-03-16

- Implementación de constante BD_CODIFICACION para permitir definir el juego de caracteres.

## [v2.7.15](https://github.com/proesio/pipe/compare/51ea8b24d084f344b52c92edaf8d99326e0032a0...670e368e7b4d1ebaf89a8af3dcc98bb65a97cac6) - 2019-09-12

- Implementacion del metodo maximo().
- Implementacion del metodo minimo().
- Implementacion del metodo promedio().
- Implementacion del metodo suma().
- Implementacion del conteo por campo en el metodo contar().
- Implementacion del metodo existe().
- Implementacion del metodo noExiste().
- Implementacion de ingreso de varios registros en el metodo insertar().
- Implementacion del metodo insertarObtenerId().
- Implementacion del metodo actualizarOinsertar().
- Implementacion del metodo incrementar().
- Implementacion del metodo decrementar().
- Implementacion de validacion de autenticado soportando condiciones con or.
- Implementacion de envio de varias llaves primarias por medio de arreglo en el metodo encontrar().
- Implementacion de los idiomas español e ingles en los mensajes.
- Implementacion relaciones Uno a Uno, Uno a Muchos, Pertenece a Uno y Pertenece a Muchos en los modelos.
- Implementacion de varias agrupaciones por medio de array en el metodo agruparPor().
- Implementacion de varias ordenaciones por medio de array en el metodo ordenarPor().
- Implementacion de consulta preparada en los metodos insertar(), encontrar(), actualizar() y eliminar().
- Traduccion de errores SQL.
- Modificacion del retorno de datos tipo JSON.
- Retorno de null en lugar de texto informativo en caso de que el valor de la llave primaria no existenta en el metodo encontrar().
- Asignacion de tipo de dato esperado en los parametros de los metodos.
- Verificacion de las asignaciones a variables nulas.
- Implementacion del metodo privado obtenerClaseLlamada() para optimizar la obtencion del nombre de la clase instanciadora.
- Implementacion del metodo privado obtenerMetodoLlamado() para la validacion de definicion de la tabla en el constructor de consultas PIPE.
- Muestra de errores en español o ingles dependiendo el idioma seleccionado.
- Validacion de los metodos consulta() y consultaNativa() permitiendo su uso solo en el constructor de consultas PIPE.
- Implementacion del metodo privado obtenerAtributosClase() para obtimizar la obtencion de los atribudos de la clase (Modelo).
- Validacion de tipo de dato de retorno válido en el metodo obtenerDatosConsultaSQL().
- Implementacion del metodo convertirValorNumerico() para convertir el tipo de dato string a int o float en el metodo obtenerDatosConsultaSQL() y encontrar().
- Documentacion de atributos y metodos.
- Traduccion de la funcion avg alias promedio, max alias maximo, min alias minimo y sum alias suma para el metodo consulta().

## [v1.1.0](https://github.com/proesio/pipe/compare/680e8d391dfdd4a8bcb094ee545129f9f3abcfad...51ea8b24d084f344b52c92edaf8d99326e0032a0) - 2019-05-16

- Implementacion del soporte para bases de datos sqlsrv.
- Modificacion del proceso de registro del tiempo en los metodos insertar() y actualizar().
- Implementacion de mensaje al no existir registro con un valor de llave primaria dato en el metodo encontrar().
- Traduccion de errores SQL.
- Solucion de error al llamar el metodo indefinido mostrarErrorSQL() desde el metodo conexion() en la clase Conexion.
- Solucion de error en el metodo alias().

## [v1.0.1](https://github.com/proesio/pipe/compare/e080b98c02b9d662931aec82e71ae121d73834a6...680e8d391dfdd4a8bcb094ee545129f9f3abcfad) - 2019-04-28

- Modificacion del metodo para obtener la conexion de la base de datos implementando la clase Conexion.php.
- Modificacion del metodo obtenerCamposConsultaSQL() implementando la funcion de php array_keys().
- Asignacion de variables al conteo de los elementos utilizados para las iteraciones en los bucles for.
- Remplazo de comillas dobles por comillas simples.
- Remplazo del alias die() por el metodo exit().

## [v1.0.0](https://github.com/proesio/pipe/compare/a1cc2d99b03d7c41e4629a4bed1501e403bfc287...e080b98c02b9d662931aec82e71ae121d73834a6) - 2019-04-14

- Version estable con soporte para mysql, pgsql, sqlite, oci.
- Migracion al metodo de conexion PDO para permitir la conexion a diferentes bases de datos.
- Modificacion del metodo todo() permitiendo enviar por parametros en un arreglo los campos que se desea listar.
- Implementacion del metodo contar().
- Implementacion del metodo ultimo().
- Implementacion de tipo de retorno de datos json en el metodo obtenerDatosConsultaSQL().
- Optimizacion del metodo primero().
- Modificacion del metodo conexion() incluyendo try catch, anexando la configuracion del controlador, host, puerto, usuario, contrasena y basedatos e implementando mensajes en - caso de error.
- Modificacion del metodo insertar() implementando null, default y nextval (Caso Oracle) en la llave primaria con autoincrement.
- Modificacion del metodo vaciar() implementacion de  para la restriccion de la llave foranea y la inclusion del truncate para sqlite.
- Implementacion del metodo obtenerCamposConsultaSQL() en remplazo del metodo PDO getColumnMeta() para obtener los campos listados en la consulta SQL del usuario.
- Implementacion del metodo obtenerCamposTabla() en remplazo del metodo PDO getColumnMeta() debido a que este ultimo no esta disponible para todas las BD.
- Modificacion de los metodos insertar() y actualizar(), implementando las variables  y  en mayuscula para oracle, obtencion de los campos por medio del metodo obtenerCamposTabla().
- Implementacion de condicional en el metodo obtenerDatosConsultaSQL() comparando count() con columnCount() para verificar la ambiguedad de los campos en la consulta SQL.
- Modificacion del metodo eliminar() incluyendo la eliminacion sin condicional.
- Modificacion de nombre del metodo prepararInsercion() a instanciar() debido a que es utilizado por los metodos insertar(), actualizar() y eliminar().
- Modificacion del metodo registroTiempo() incluyendo el formato de fecha para timestamp en oracle.
- Traduccion de errores SQL para sqlite y oracle.

## [beta](https://github.com/proesio/pipe/commit/a1cc2d99b03d7c41e4629a4bed1501e403bfc287) - 2019-04-14

- Version estable con soporte para mysql.