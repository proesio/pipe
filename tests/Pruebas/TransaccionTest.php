<?php

/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * PHP version 8.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  8.0.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

namespace PIPE\Tests\Pruebas;

use PIPE\PIPE;
use Modelos\Tema;
use Modelos\Usuario;
use Modelos\Telefono;
use PIPE\Configuracion;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;
use PIPE\Excepciones\ORMExcepcion;
use PIPE\Excepciones\SQLExcepcion;

class TransaccionTest extends TestCase
{
    public $conexiones = [];

    public $configGlobal = [];

    public function setUp(): void
    {
        $this->conexiones = $GLOBALS['CONEXIONES'];
        $this->configGlobal = $GLOBALS['CONFIG_GLOBAL'];
    }

    public function testDeDefinicionDeTransaccionAutomatica()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            vaciarTablas();

            $resultados = PIPE::transaccion(
                function () {
                    $telefono = Telefono::crear(['numero' => 1234567890]);

                    $usuario = Usuario::crear(
                        [
                            'telefono_id' => $telefono->id,
                            'nombres' => 'Nombre1',
                            'apellidos' => 'Apellido1'
                        ]
                    );

                    $tema = Tema::crear(
                        [
                            'usuario_id' => $usuario->id,
                            'titulo' => 'Tema1',
                            'descripcion' => 'Descripcion1'
                        ]
                    );

                    return [$telefono, $usuario, $tema];
                }
            );

            $this->assertEquals(1234567890, $resultados[0]->numero);
            $this->assertEquals('Nombre1', $resultados[1]->nombres);
            $this->assertEquals('Tema1', $resultados[2]->titulo);
        }
    }

    public function testDeFalloAlDefinirTransaccionAutomaticaMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        vaciarTablas();

        $this->expectException(SQLExcepcion::class);

        PIPE::transaccion(
            function () {
                $telefono = Telefono::crear(['numero' => 1234567890]);

                Usuario::crear(['campo_inexistente' => $telefono->id]);
            }
        );
    }

    public function testDeFalloAlDefinirTransaccionAutomaticaPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        vaciarTablas();

        $this->expectException(SQLExcepcion::class);

        PIPE::transaccion(
            function () {
                $telefono = Telefono::crear(['numero' => 1234567890]);

                Usuario::crear(['campo_inexistente' => $telefono->id]);
            }
        );
    }

    public function testDeFalloAlDefinirTransaccionAutomaticaSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        vaciarTablas();

        $this->expectException(SQLExcepcion::class);

        PIPE::transaccion(
            function () {
                $telefono = Telefono::crear(['numero' => 1234567890]);

                Usuario::crear(['campo_inexistente' => $telefono->id]);
            }
        );
    }

    public function testDeFalloAlDefinirTransaccionAutomaticaSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        vaciarTablas();

        $this->expectException(SQLExcepcion::class);

        PIPE::transaccion(
            function () {
                $telefono = Telefono::crear(['numero' => 1234567890]);

                Usuario::crear(['campo_inexistente' => $telefono->id]);
            }
        );
    }

    public function testDeFalloAlNoDefinirClosureEnTransaccionAutomaticaMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        vaciarTablas();

        $this->expectException(ORMExcepcion::class);

        PIPE::transaccion('closure_inexistente');
    }

    public function testDeFalloAlNoDefinirClosureEnTransaccionAutomaticaPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        vaciarTablas();

        $this->expectException(ORMExcepcion::class);

        PIPE::transaccion('closure_inexistente');
    }

    public function testDeFalloAlNoDefinirClosureEnTransaccionAutomaticaSQlite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        vaciarTablas();

        $this->expectException(ORMExcepcion::class);

        PIPE::transaccion('closure_inexistente');
    }

    public function testDeFalloAlNoDefinirClosureEnTransaccionAutomaticaSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        vaciarTablas();

        $this->expectException(ORMExcepcion::class);

        PIPE::transaccion('closure_inexistente');
    }

    public function testDeReintentoDeTransaccionAutomaticaPorInterbloqueoMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        vaciarTablas();

        $sqlExcepcion = new SQLExcepcion('Interbloqueo.', 1213);

        $reflectionProperty = new ReflectionProperty(
            SQLExcepcion::class, 'errorInfo'
        );

        $reflectionProperty->setValue(
            $sqlExcepcion, ['40001', 1213, 'Interbloqueo.']
        );

        $intentos = 0;

        $resultados = PIPE::transaccion(
            function () use ($sqlExcepcion, &$intentos) {
                $intentos++;

                if ($intentos < 3) {
                    throw $sqlExcepcion;
                }

                $telefono = Telefono::crear(['numero' => 1234567890]);

                $usuario = Usuario::crear(
                    [
                        'telefono_id' => $telefono->id,
                        'nombres' => 'Nombre1',
                        'apellidos' => 'Apellido1'
                    ]
                );

                $tema = Tema::crear(
                    [
                        'usuario_id' => $usuario->id,
                        'titulo' => 'Tema1',
                        'descripcion' => 'Descripcion1'
                    ]
                );

                return [$telefono, $usuario, $tema];
            }, 3
        );

        $this->assertEquals(3, $intentos);
        $this->assertEquals(1234567890, $resultados[0]->numero);
        $this->assertEquals('Nombre1', $resultados[1]->nombres);
        $this->assertEquals('Tema1', $resultados[2]->titulo);
    }

    public function testDeReintentoDeTransaccionAutomaticaPorInterbloqueoPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        vaciarTablas();

        $sqlExcepcion = new SQLExcepcion('Interbloqueo.', 0);

        $reflectionProperty = new ReflectionProperty(
            SQLExcepcion::class, 'errorInfo'
        );

        $reflectionProperty->setValue(
            $sqlExcepcion, ['40P01', 0, 'Interbloqueo.']
        );

        $intentos = 0;

        $resultados = PIPE::transaccion(
            function () use ($sqlExcepcion, &$intentos) {
                $intentos++;

                if ($intentos < 3) {
                    throw $sqlExcepcion;
                }

                $telefono = Telefono::crear(['numero' => 1234567890]);

                $usuario = Usuario::crear(
                    [
                        'telefono_id' => $telefono->id,
                        'nombres' => 'Nombre1',
                        'apellidos' => 'Apellido1'
                    ]
                );

                $tema = Tema::crear(
                    [
                        'usuario_id' => $usuario->id,
                        'titulo' => 'Tema1',
                        'descripcion' => 'Descripcion1'
                    ]
                );

                return [$telefono, $usuario, $tema];
            }, 3
        );

        $this->assertEquals(3, $intentos);
        $this->assertEquals(1234567890, $resultados[0]->numero);
        $this->assertEquals('Nombre1', $resultados[1]->nombres);
        $this->assertEquals('Tema1', $resultados[2]->titulo);
    }

    public function testDeReintentoDeTransaccionAutomaticaPorInterbloqueoSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        vaciarTablas();

        $sqlExcepcion = new SQLExcepcion('locked', 5);

        $reflectionProperty = new ReflectionProperty(
            SQLExcepcion::class, 'errorInfo'
        );

        $reflectionProperty->setValue(
            $sqlExcepcion, ['HY000', 5, 'locked']
        );

        $intentos = 0;

        $resultados = PIPE::transaccion(
            function () use ($sqlExcepcion, &$intentos) {
                $intentos++;

                if ($intentos < 3) {
                    throw $sqlExcepcion;
                }

                $telefono = Telefono::crear(['numero' => 1234567890]);

                $usuario = Usuario::crear(
                    [
                        'telefono_id' => $telefono->id,
                        'nombres' => 'Nombre1',
                        'apellidos' => 'Apellido1'
                    ]
                );

                $tema = Tema::crear(
                    [
                        'usuario_id' => $usuario->id,
                        'titulo' => 'Tema1',
                        'descripcion' => 'Descripcion1'
                    ]
                );

                return [$telefono, $usuario, $tema];
            }, 3
        );

        $this->assertEquals(3, $intentos);
        $this->assertEquals(1234567890, $resultados[0]->numero);
        $this->assertEquals('Nombre1', $resultados[1]->nombres);
        $this->assertEquals('Tema1', $resultados[2]->titulo);
    }

    public function testDeReintentoDeTransaccionAutomaticaPorInterbloqueoSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        vaciarTablas();

        $sqlExcepcion = new SQLExcepcion('Interbloqueo.', 1205);

        $reflectionProperty = new ReflectionProperty(
            SQLExcepcion::class, 'errorInfo'
        );

        $reflectionProperty->setValue(
            $sqlExcepcion, ['40001', 1205, 'Interbloqueo.']
        );

        $intentos = 0;

        $resultados = PIPE::transaccion(
            function () use ($sqlExcepcion, &$intentos) {
                $intentos++;

                if ($intentos < 3) {
                    throw $sqlExcepcion;
                }

                $telefono = Telefono::crear(['numero' => 1234567890]);

                $usuario = Usuario::crear(
                    [
                        'telefono_id' => $telefono->id,
                        'nombres' => 'Nombre1',
                        'apellidos' => 'Apellido1'
                    ]
                );

                $tema = Tema::crear(
                    [
                        'usuario_id' => $usuario->id,
                        'titulo' => 'Tema1',
                        'descripcion' => 'Descripcion1'
                    ]
                );

                return [$telefono, $usuario, $tema];
            }, 3
        );

        $this->assertEquals(3, $intentos);
        $this->assertEquals(1234567890, $resultados[0]->numero);
        $this->assertEquals('Nombre1', $resultados[1]->nombres);
        $this->assertEquals('Tema1', $resultados[2]->titulo);
    }

    public function testDeDefinicionDeTransaccionPersonalizada()
    {
        foreach ($this->conexiones as $conexion) {
            Configuracion::inicializar($this->configGlobal, $conexion, true);

            vaciarTablas();

            PIPE::iniciarTransaccion();

            try {
                $telefono = Telefono::crear(['numero' => 1234567890]);

                $usuario = Usuario::crear(
                    [
                        'telefono_id' => $telefono->id,
                        'nombres' => 'Nombre1',
                        'apellidos' => 'Apellido1'
                    ]
                );

                $tema = Tema::crear(
                    [
                        'usuario_id' => $usuario->id,
                        'titulo' => 'Tema1',
                        'descripcion' => 'Descripcion1'
                    ]
                );

                PIPE::confirmar();

                $this->assertEquals(1234567890, $telefono->numero);
                $this->assertEquals('Nombre1', $usuario->nombres);
                $this->assertEquals('Tema1', $tema->titulo);
            } catch (SQLExcepcion $e) {
                PIPE::revertir();
            }
        }
    }

    public function testDeFalloAlDefinirTransaccionPersonalizadaMySQL()
    {
        Configuracion::inicializar($this->configGlobal, 'mysql');

        vaciarTablas();

        PIPE::iniciarTransaccion();

        try {
            $telefono = Telefono::crear(['numero' => 1234567890]);

            Usuario::crear(
                ['campo_inexistente' => $telefono->id]
            );

            PIPE::confirmar();
        } catch (SQLExcepcion $e) {
            PIPE::revertir();
        }

        $telefono = Telefono::encontrar(1);
        $usuario = Usuario::encontrar(1);

        $this->assertNull($telefono);
        $this->assertNull($usuario);
    }

    public function testDeFalloAlDefinirTransaccionPersonalizadaPostgreSQL()
    {
        Configuracion::inicializar($this->configGlobal, 'pgsql');

        vaciarTablas();

        PIPE::iniciarTransaccion();

        try {
            $telefono = Telefono::crear(['numero' => 1234567890]);

            Usuario::crear(
                ['campo_inexistente' => $telefono->id]
            );

            PIPE::confirmar();
        } catch (SQLExcepcion $e) {
            PIPE::revertir();
        }

        $telefono = Telefono::encontrar(1);
        $usuario = Usuario::encontrar(1);

        $this->assertNull($telefono);
        $this->assertNull($usuario);
    }

    public function testDeFalloAlDefinirTransaccionPersonalizadaSQLite()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlite');

        vaciarTablas();

        PIPE::iniciarTransaccion();

        try {
            $telefono = Telefono::crear(['numero' => 1234567890]);

            Usuario::crear(
                ['campo_inexistente' => $telefono->id]
            );

            PIPE::confirmar();
        } catch (SQLExcepcion $e) {
            PIPE::revertir();
        }

        $telefono = Telefono::encontrar(1);
        $usuario = Usuario::encontrar(1);

        $this->assertNull($telefono);
        $this->assertNull($usuario);
    }

    public function testDeFalloAlDefinirTransaccionPersonalizadaSQLServer()
    {
        Configuracion::inicializar($this->configGlobal, 'sqlsrv');

        vaciarTablas();

        PIPE::iniciarTransaccion();

        try {
            $telefono = Telefono::crear(['numero' => 1234567890]);

            Usuario::crear(
                ['campo_inexistente' => $telefono->id]
            );

            PIPE::confirmar();
        } catch (SQLExcepcion $e) {
            PIPE::revertir();
        }

        $telefono = Telefono::encontrar(1);
        $usuario = Usuario::encontrar(1);

        $this->assertNull($telefono);
        $this->assertNull($usuario);
    }
}
