CREATE DATABASE estados_financieros;
USE estados_financieros;

CREATE TABLE perfil_usuario(
	id_usuario int(11) not null auto_increment,
    nombre varchar(20) not null,
    puntaje int(11) not null,
    PRIMARY KEY pk_usuario(id_usuario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pregunta(
	id_pregunta int(11) not null auto_increment,
    preg varchar(500) not null,
    respuesta varchar(500) not null,
    used int(11) DEFAULT '0',
    PRIMARY KEY pk_pregunta(id_pregunta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;