create table apuesta
(
	id int not null auto_increment
		primary key,
	nombre varchar(50) not null,
	constraint apuesta_nombre_uindex
	unique (nombre)
)
;

create table apuesta_partido
(
	id int not null auto_increment
		primary key,
	partido_id int not null,
	apuesta_id int not null,
	constraint apuesta_partido_partido_id_apuesta_id_uindex
	unique (partido_id, apuesta_id),
	constraint apuesta_partido_apuesta_id_fk
	foreign key (apuesta_id) references apuesta (id)
)
;

create index apuesta_partido_apuesta_id_fk
	on apuesta_partido (apuesta_id)
;

create table campo
(
	id int not null auto_increment
		primary key,
	nombre varchar(100) not null,
	par_hoyo_1 int null,
	par_hoyo_2 int null,
	par_hoyo_3 int null,
	par_hoyo_4 int null,
	par_hoyo_5 int null,
	par_hoyo_6 int null,
	par_hoyo_7 int null,
	par_hoyo_8 int null,
	par_hoyo_9 int null,
	par_hoyo_10 int null,
	par_hoyo_11 int null,
	par_hoyo_12 int null,
	par_hoyo_13 int null,
	par_hoyo_14 int null,
	par_hoyo_15 int null,
	par_hoyo_16 int null,
	par_hoyo_17 int null,
	par_hoyo_18 int null,
	ventaja_hoyo_1 int null,
	ventaja_hoyo_2 int null,
	ventaja_hoyo_3 int null,
	ventaja_hoyo_4 int null,
	ventaja_hoyo_5 int null,
	ventaja_hoyo_6 int null,
	ventaja_hoyo_7 int null,
	ventaja_hoyo_8 int null,
	ventaja_hoyo_9 int null,
	ventaja_hoyo_10 int null,
	ventaja_hoyo_11 int null,
	ventaja_hoyo_12 int null,
	ventaja_hoyo_13 int null,
	ventaja_hoyo_14 int null,
	ventaja_hoyo_15 int null,
	ventaja_hoyo_16 int null,
	ventaja_hoyo_17 int null,
	ventaja_hoyo_18 int null
)
;

create table jugador
(
	id int not null auto_increment
		primary key,
	nombre varchar(255) not null,
	apodo varchar(10) not null,
	handicap int not null,
	sexo char not null,
	url_foto varchar(255) not null,
	password varchar(100) not null,
	email varchar(100) not null,
	constraint jugador_email_uindex
	unique (email)
)
;

create table jugador_partido
(
	id int not null auto_increment
		primary key,
	jugador_id int not null,
	partido_id int not null,
	constraint jugador_partido_jugador_id_partido_id_uindex
	unique (jugador_id, partido_id),
	constraint jugador_partido_jugador_id_fk
	foreign key (jugador_id) references jugador (id)
)
;

create index jugador_partido_partido_id_fk
	on jugador_partido (partido_id)
;

create table partido
(
	id int not null auto_increment
		primary key,
	clave char(8) not null,
	inicio datetime not null,
	fin datetime null,
	jugador_id int not null,
	campo_id int not null,
	constraint partido_clave_uindex
	unique (clave),
	constraint partido_jugador_id_fk
	foreign key (jugador_id) references jugador (id),
	constraint partido_campo_id_fk
	foreign key (campo_id) references campo (id)
)
;

create index partido_jugador_id_fk
	on partido (jugador_id)
;

create index partido_campo_id_fk
	on partido (campo_id)
;

alter table apuesta_partido
	add constraint apuesta_partido_partido_id_fk
foreign key (partido_id) references partido (id)
;

alter table jugador_partido
	add constraint jugador_partido_partido_id_fk
foreign key (partido_id) references partido (id)
;

create table puntuaciones
(
	id int not null auto_increment
		primary key,
	hoyo int not null,
	golpes int not null,
	unidades int default '0' not null,
	jugador_id int not null,
	partido_id int not null,
	constraint puntuaciones_jugador_id_partido_id_uindex
	unique (jugador_id, partido_id),
	constraint puntuaciones_jugador_id_fk
	foreign key (jugador_id) references jugador (id),
	constraint puntuaciones_partido_id_fk
	foreign key (partido_id) references partido (id)
)
;

create index puntuaciones_partido_id_fk
	on puntuaciones (partido_id)
;

