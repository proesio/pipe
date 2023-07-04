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

namespace Modelos;

use PIPE\Clases\Modelo;

class Usuario extends Modelo
{
    public $tieneUno = [
        Documento::class => [
            'llavePrincipal' => 'id',
            'llaveForanea' => 'usuario_id',
            'nombre' => 'documento'
        ]
    ];

    public $tieneMuchos = [
        Tema::class => [
            'llavePrincipal' => 'id',
            'llaveForanea' => 'usuario_id',
            'nombre' => 'temas'
        ]
    ];

    public $perteneceAUno = [
        Telefono::class => [
            'llavePrincipal' => 'id',
            'llaveForanea' => 'telefono_id',
            'nombre' => 'telefono'
        ]
    ];

    public $perteneceAMuchos = [
        Role::class => [
            'tablaUnion' => 'role_usuario',
            'llaveForaneaLocal' => 'usuario_id',
            'llaveForaneaUnion' => 'role_id',
            'nombre' => 'roles'
        ]
    ];
}
