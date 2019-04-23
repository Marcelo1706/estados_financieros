CREATE DATABASE estados_financieros;
USE estados_financieros;

CREATE TABLE perfil_usuario(
	id_usuario int(11) not null auto_increment,
    nombre varchar(20) not null,
    puntaje int(11) not null,
    PRIMARY KEY pk_usuario(id_usuario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE respuesta(
	id_respuesta int(11) not null auto_increment,
    resp varchar(1000) not null,
    PRIMARY KEY pk_respuestas(id_respuesta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pregunta(
	id_pregunta int(11) not null auto_increment,
    preg varchar(500) not null,
    resp_correcta int(11) not null, 
    PRIMARY KEY pk_pregunta(id_pregunta),
    FOREIGN KEY fk_respuesta(resp_correcta) REFERENCES respuesta(id_respuesta)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE administrador(
	id_usuario int(11) not null auto_increment,
    nombre varchar(20) not null,
    pass varchar(250) not null,
    PRIMARY KEY pk_administrador(id_usuario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;