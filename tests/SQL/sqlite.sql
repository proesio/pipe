/**
 * Este archivo es parte del proyecto PIPE.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2018 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  5.1.0
 * @link      https://pipe.proes.io
 * @since     Fecha inicio de creación del proyecto  2018-09-13
 */

drop table if exists documentos;
drop table if exists role_usuario;
drop table if exists temas;
drop table if exists roles;
drop table if exists usuarios;
drop table if exists telefonos;

create table telefonos (
	id integer primary key autoincrement not null,
	numero bigint,
	creado_en timestamp null,
	actualizado_en timestamp null
);

create table usuarios (
	id integer primary key autoincrement not null,
    telefono_id int not null,
	nombres varchar(50),
	apellidos varchar(50),
	creado_en timestamp null,
	actualizado_en timestamp null,
    constraint fk_usuarios_telefono_id foreign key (telefono_id) references telefonos (id)
);

create table roles (
	id integer primary key autoincrement not null,
    nombre varchar(50),
	creado_en timestamp null,
	actualizado_en timestamp null
);

create table temas (
	id integer primary key autoincrement not null,
    usuario_id int,
	titulo varchar(100),
	descripcion varchar(1000),
	creado_en timestamp null,
	actualizado_en timestamp null,
    constraint fk_temas_usuario_id foreign key (usuario_id) references usuarios (id)
);

create table role_usuario (
    role_id int not null,
    usuario_id int not null,
    constraint fk_role_usuario_role_id foreign key (role_id) references roles (id),
    constraint fk_role_usuario_usuario_id foreign key (usuario_id) references usuarios (id)
);

create table documentos (
	id integer primary key autoincrement not null,
    usuario_id int not null,
	numero varchar(20),
	creado_en timestamp null,
	actualizado_en timestamp null,
    constraint fk_documentos_usuario_id foreign key (usuario_id) references usuarios (id)
);
