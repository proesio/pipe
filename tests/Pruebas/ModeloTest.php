<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  5.1.6
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use PDO;
use Modelos\Role;
use Modelos\Tema;
use Modelos\Telefono;
use PIPE\Clases\PIPE;
use Modelos\Documento;
use PIPE\Clases\Configuracion;
use PHPUnit\Framework\TestCase;
use PIPE\Clases\Excepciones\ORM;
use PIPE\Clases\ConstructorConsulta;

class ModeloTest extends TestCase
{
    public $conexiones = [
        'mysql', 'pgsql', 'sqlite', 'sqlsrv'
    ];

    public $conexion = '';

    public $configGlobal = [];

    public function setUp(): void
    {
        global $configGlobal;

        $this->configGlobal = $configGlobal;
    }

    public function testDeDefinicionDeConexion()
    {
        vaciarTablas('mysql');
        vaciarTablas('pgsql');

        Configuracion::inicializar($this->configGlobal, 'mysql');

        $propiedades = [
            'tabla' => 'telefonos',
            'clase' => 'Telefono'
        ];

        $pipe = new ConstructorConsulta($propiedades);
        $pipe->insertar(['numero' => 123456789]);
        $telefono = $pipe->primero(PIPE::OBJETO);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('mysql', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
        $this->assertEquals(123456789, $telefono->numero);

        $propiedades['conexion'] = 'pgsql';
        $pipe = new ConstructorConsulta($propiedades);
        $pipe->insertar(['numero' => 987654321]);
        $telefono = $pipe->primero(PIPE::OBJETO);

        $pdo = PIPE::obtenerPDO();

        $this->assertEquals('pgsql', $pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
        $this->assertEquals(987654321, $telefono->numero);
    }

    public function testDeDefinicionDeTablaMysql()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        $this->expectException(ORM::class);

        $propiedades = [
            'tabla' => 'tabla_inexistente',
            'clase' => 'Telefono'
        ];

        $pipe = new ConstructorConsulta($propiedades);
    }

    public function testDeDefinicionDeTablaPgsql()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        $this->expectException(ORM::class);

        $propiedades = [
            'tabla' => 'tabla_inexistente',
            'clase' => 'Telefono'
        ];

        $pipe = new ConstructorConsulta($propiedades);
    }

    public function testDeDefinicionDeTablaSqlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        $this->expectException(ORM::class);

        $propiedades = [
            'tabla' => 'tabla_inexistente',
            'clase' => 'Telefono'
        ];

        $pipe = new ConstructorConsulta($propiedades);
    }

    public function testDeDefinicionDeTablaSqlsrv()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        $this->expectException(ORM::class);

        $propiedades = [
            'tabla' => 'tabla_inexistente',
            'clase' => 'Telefono'
        ];

        $pipe = new ConstructorConsulta($propiedades);
    }

    public function testDeDefinicionDeLlavePrimaria()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeLlavePrimaria();
        }
    }

    public function testDeDefinicionDeRegistroTiempo()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRegistroTiempo();
        }
    }

    public function testDeDefinicionDeCreadoEnYActualizadoEn()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeCreadoEnYActualizadoEn();
        }
    }

    public function testDeDefinicionDeRelacionTieneUno()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelacionTieneUno();
        }
    }

    public function testDeDefinicionDeRelacionTieneMuchos()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelacionTieneMuchos();
        }
    }

    public function testDeDefinicionDeRelacionPerteneceAUno()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelacionPerteneceAUno();
        }
    }

    public function testDeDefinicionDeRelacionPerteneceAMuchos()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeRelacionPerteneceAMuchos();
        }
    }

    public function testDeDefinicionDeInsertables()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeInsertables();
        }
    }

    public function testDeDefinicionDeActualizables()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeActualizables();
        }
    }

    public function testDeDefinicionDeVisibles()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeVisibles();
        }
    }

    public function testDeDefinicionDeOcultos()
    {
        foreach ($this->conexiones as $conexion) {
            $this->conexion = $conexion;
            $this->baseTestDeDefinicionDeOcultos();
        }
    }

    private function baseTestDeDefinicionDeLlavePrimaria()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');

        $propiedades = [
            'tabla' => 'telefonos',
            'clase' => 'Telefono',
            'llavePrimaria' => 'id'
        ];

        $pipe = new ConstructorConsulta($propiedades);
        $telefono = $pipe->encontrar(1);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertObjectHasProperty('id', $telefono);
        $this->assertObjectHasProperty('numero', $telefono);
        $this->assertObjectHasProperty('creado_en', $telefono);
        $this->assertObjectHasProperty('actualizado_en', $telefono);
    }

    private function baseTestDeDefinicionDeRegistroTiempo()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        $propiedades = [
            'tabla' => 'telefonos',
            'clase' => 'Telefono',
            'registroTiempo' => false
        ];

        $pipe = new ConstructorConsulta($propiedades);
        $id = $pipe->insertarObtenerId(['numero' => 987654321]);
        $telefono = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertObjectHasProperty('creado_en', $telefono);
        $this->assertObjectHasProperty('actualizado_en', $telefono);
        $this->assertNull($telefono->creado_en);
        $this->assertNull($telefono->actualizado_en);
    }

    private function baseTestDeDefinicionDeCreadoEnYActualizadoEn()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        $propiedades = [
            'tabla' => 'telefonos',
            'clase' => 'Telefono',
            'creadoEn' => 'created_at',
            'actualizadoEn' => 'updated_at'
        ];

        $pipe = new ConstructorConsulta($propiedades);
        $id = $pipe->insertarObtenerId(['numero' => 123456789]);
        $telefono = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $telefono);
        $this->assertObjectHasProperty('creado_en', $telefono);
        $this->assertObjectHasProperty('actualizado_en', $telefono);
        $this->assertNull($telefono->creado_en);
        $this->assertNull($telefono->actualizado_en);
    }

    private function baseTestDeDefinicionDeRelacionTieneUno()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'documentos');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario'
        ];

        // Prueba de relación básica.

        $propiedades['tieneUno'] = Documento::class;
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('documentos');

        $this->assertObjectHasProperty('documentos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->documentos);

        // Prueba de relación definiendo nombre.

        $propiedades['tieneUno'] = [Documento::class => ['nombre' => 'documento_relacion']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('documento_relacion');

        $this->assertObjectHasProperty('documento_relacion', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->documento_relacion);

        // Prueba de relación definiendo llave principal.

        $propiedades['tieneUno'] = [Documento::class => ['llavePrincipal' => 'id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('documentos');

        $this->assertObjectHasProperty('documentos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->documentos);

        // Prueba de relación definiendo llave foránea.

        $propiedades['tieneUno'] = [Documento::class => ['llaveForanea' => 'usuario_id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('documentos');

        $this->assertObjectHasProperty('documentos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->documentos);
    }

    private function baseTestDeDefinicionDeRelacionTieneMuchos()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'temas');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario'
        ];

        // Prueba de relación básica.

        $propiedades['tieneMuchos'] = Tema::class;
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('temas');

        $this->assertObjectHasProperty('temas', $usuario);
        $this->assertIsArray($usuario->temas);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->temas[0]);

        // Prueba de relación definiendo nombre.

        $propiedades['tieneMuchos'] = [Tema::class => ['nombre' => 'temas_relacion']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('temas_relacion');

        $this->assertObjectHasProperty('temas_relacion', $usuario);
        $this->assertIsArray($usuario->temas_relacion);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->temas_relacion[0]);

        // Prueba de relación definiendo llave principal.

        $propiedades['tieneMuchos'] = [Tema::class => ['llavePrincipal' => 'id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('temas');

        $this->assertObjectHasProperty('temas', $usuario);
        $this->assertIsArray($usuario->temas);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->temas[0]);

        // Prueba de relación definiendo llave foránea.

        $propiedades['tieneMuchos'] = [Tema::class => ['llaveForanea' => 'usuario_id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('temas');

        $this->assertObjectHasProperty('temas', $usuario);
        $this->assertIsArray($usuario->temas);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->temas[0]);
    }

    private function baseTestDeDefinicionDeRelacionPerteneceAUno()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario'
        ];

        // Prueba de relación básica.

        $propiedades['perteneceAUno'] = Telefono::class;
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('telefonos');

        $this->assertObjectHasProperty('telefonos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->telefonos);

        // Prueba de relación definiendo nombre.

        $propiedades['perteneceAUno'] = [Telefono::class => ['nombre' => 'telefono_relacion']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('telefono_relacion');

        $this->assertObjectHasProperty('telefono_relacion', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->telefono_relacion);

        // Prueba de relación definiendo llave principal.

        $propiedades['perteneceAUno'] = [Telefono::class => ['llavePrincipal' => 'id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('telefonos');

        $this->assertObjectHasProperty('telefonos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->telefonos);

        // Prueba de relación definiendo llave foránea.

        $propiedades['perteneceAUno'] = [Telefono::class => ['llaveForanea' => 'telefono_id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('telefonos');

        $this->assertObjectHasProperty('telefonos', $usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->telefonos);
    }

    private function baseTestDeDefinicionDeRelacionPerteneceAMuchos()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');
        generarRegistros($this->conexion, 'usuarios');
        generarRegistros($this->conexion, 'roles');
        generarRegistros($this->conexion, 'role_usuario');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario'
        ];

        // Prueba de relación básica.

        $propiedades['perteneceAMuchos'] = Role::class;
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('role_usuario');

        $this->assertObjectHasProperty('role_usuario', $usuario);
        $this->assertIsArray($usuario->role_usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->role_usuario[0]);

        // Prueba de relación definiendo nombre.

        $propiedades['perteneceAMuchos'] = [Role::class => ['nombre' => 'rol_relacion']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('rol_relacion');

        $this->assertObjectHasProperty('rol_relacion', $usuario);
        $this->assertIsArray($usuario->rol_relacion);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->rol_relacion[0]);

        // Prueba de relación definiendo tabla unión.

        $propiedades['perteneceAMuchos'] = [Role::class => ['tablaUnion' => 'role_usuario']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('role_usuario');

        $this->assertObjectHasProperty('role_usuario', $usuario);
        $this->assertIsArray($usuario->role_usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->role_usuario[0]);

        // Prueba de relación definiendo llave foránea local.

        $propiedades['perteneceAMuchos'] = [Role::class => ['llaveForaneaLocal' => 'usuario_id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('role_usuario');

        $this->assertObjectHasProperty('role_usuario', $usuario);
        $this->assertIsArray($usuario->role_usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->role_usuario[0]);

        // Prueba de relación definiendo llave foránea unión.

        $propiedades['perteneceAMuchos'] = [Role::class => ['llaveForaneaUnion' => 'role_id']];
        $pipe = new ConstructorConsulta($propiedades);
        $usuario = $pipe->primero()->relacionar('role_usuario');

        $this->assertObjectHasProperty('role_usuario', $usuario);
        $this->assertIsArray($usuario->role_usuario);
        $this->assertInstanceOf(ConstructorConsulta::class, $usuario->role_usuario[0]);
    }

    private function baseTestDeDefinicionDeInsertables()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario',
            'insertables' => ['telefono_id', 'nombres']
        ];

        $pipe = new ConstructorConsulta($propiedades);

        $id = $pipe->insertarObtenerId(
            ['telefono_id' => 1, 'nombres' => 'Juan', 'apellidos' => 'Valencia']
        );

        $usuario = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $usuario);
        $this->assertObjectHasProperty('apellidos', $usuario);
        $this->assertNull($usuario->apellidos);
    }

    private function baseTestDeDefinicionDeActualizables()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario',
            'actualizables' => ['telefono_id', 'nombres']
        ];

        $pipe = new ConstructorConsulta($propiedades);

        $id = $pipe->insertarObtenerId(
            ['telefono_id' => 1, 'nombres' => 'Juan']
        );

        $usuario = $pipe->encontrar($id);
        $usuario->apellidos = 'Valencia';
        $usuario->actualizar();

        $usuario = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $usuario);
        $this->assertObjectHasProperty('apellidos', $usuario);
        $this->assertNull($usuario->apellidos);
    }

    private function baseTestDeDefinicionDeVisibles()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario',
            'visibles' => ['id', 'nombres', 'creado_en', 'actualizado_en']
        ];

        $pipe = new ConstructorConsulta($propiedades);

        $id = $pipe->insertarObtenerId(
            ['telefono_id' => 1, 'nombres' => 'Juan', 'apellidos' => 'Valencia']
        );

        $usuario = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $usuario);
        $this->assertObjectNotHasProperty('apellidos', $usuario);
    }

    private function baseTestDeDefinicionDeOcultos()
    {
        Configuracion::inicializar($this->configGlobal, $this->conexion);

        vaciarTablas($this->conexion);

        generarRegistros($this->conexion, 'telefonos');

        $propiedades = [
            'tabla' => 'usuarios',
            'clase' => 'Usuario',
            'ocultos' => ['apellidos']
        ];

        $pipe = new ConstructorConsulta($propiedades);

        $id = $pipe->insertarObtenerId(
            ['telefono_id' => 1, 'nombres' => 'Juan', 'apellidos' => 'Valencia']
        );

        $usuario = $pipe->encontrar($id);

        $this->assertInstanceOf(ConstructorConsulta::class, $usuario);
        $this->assertObjectNotHasProperty('apellidos', $usuario);
    }
}
