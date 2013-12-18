

DROP TABLE IF EXISTS `turnera`.`avisos`;
DROP TABLE IF EXISTS `turnera`.`clinicas`;
DROP TABLE IF EXISTS `turnera`.`consultorios`;
DROP TABLE IF EXISTS `turnera`.`dia_disponibilidad`;
DROP TABLE IF EXISTS `turnera`.`disponibilidad`;
DROP TABLE IF EXISTS `turnera`.`especialidad`;
DROP TABLE IF EXISTS `turnera`.`excepcion`;
DROP TABLE IF EXISTS `turnera`.`grupo`;
DROP TABLE IF EXISTS `turnera`.`medico`;
DROP TABLE IF EXISTS `turnera`.`obras_sociales`;
DROP TABLE IF EXISTS `turnera`.`secretarias`;
DROP TABLE IF EXISTS `turnera`.`turnos`;
DROP TABLE IF EXISTS `turnera`.`usuarios`;
DROP TABLE IF EXISTS `turnera`.`variables_avisos`;


CREATE TABLE `turnera`.`avisos` (
	`id_aviso` int(20) NOT NULL AUTO_INCREMENT,
	`fecha_envio` datetime NOT NULL,
	`template` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`layout` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`formato` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`metodo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'email' NOT NULL,
	`to` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`from` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,	PRIMARY KEY  (`id_aviso`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`clinicas` (
	`id_clinica` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`telefono` int(11) NOT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,	PRIMARY KEY  (`id_clinica`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`consultorios` (
	`id_consultorio` int(11) NOT NULL AUTO_INCREMENT,
	`clinica_id` int(11) NOT NULL,
	`nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,	PRIMARY KEY  (`id_consultorio`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`dia_disponibilidad` (
	`disponibilidad_id` int(20) NOT NULL,
	`dia` int(6) NOT NULL,
	`habilitado` tinyint(1) NOT NULL,
	`hora_inicio` time NOT NULL,
	`hora_fin` time NOT NULL,
	`hora_inicio_tarde` time DEFAULT NULL,
	`hora_fin_tarde` time DEFAULT NULL,
	`id` int(11) NOT NULL AUTO_INCREMENT,	PRIMARY KEY  (`id`),
	UNIQUE KEY `disponibilidad_id` (`disponibilidad_id`, `dia`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`disponibilidad` (
	`id_disponibilidad` int(20) NOT NULL AUTO_INCREMENT,
	`medico_id` int(20) NOT NULL,
	`duracion` int(20) DEFAULT 10 NOT NULL,
	`consultorio_id` int(20) NOT NULL,	PRIMARY KEY  (`id_disponibilidad`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`especialidades` (
	`id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,	PRIMARY KEY  (`id_especialidad`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`excepcion` (
	`id_excepcion` int(20) NOT NULL AUTO_INCREMENT,
	`medico_id` int(20) NOT NULL,
	`inicio` datetime NOT NULL,
	`fin` datetime NOT NULL,
	`rep_semanal` tinyint(1) NOT NULL,
	`rep_mensual` tinyint(1) NOT NULL,
	`rep_anual` tinyint(1) NOT NULL,
	`relativo` int(11) NOT NULL,	PRIMARY KEY  (`id_excepcion`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`grupo` (
	`id_grupo` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,	PRIMARY KEY  (`id_grupo`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish2_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`medicos` (
	`id_medico` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) NOT NULL,
	`especialidad_id` int(11) NOT NULL,
	`clinica_id` int(11) NOT NULL,
	`visible` tinyint(1) NOT NULL,	PRIMARY KEY  (`id_medico`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`obras_sociales` (
	`id_obra_social` int(11) NOT NULL AUTO_INCREMENT,
	`nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
	`telefono` int(11) DEFAULT NULL,
	`imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,	PRIMARY KEY  (`id_obra_social`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`secretarias` (
	`id_secretaria` int(11) NOT NULL AUTO_INCREMENT,
	`usuario_id` int(11) NOT NULL,
	`clinica_id` int(11) NOT NULL,
	`resumen` tinyint(1) NOT NULL,	PRIMARY KEY  (`id_secretaria`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`turnos` (
	`id_turno` int(11) NOT NULL AUTO_INCREMENT,
	`paciente_id` int(11) DEFAULT NULL,
	`medico_id` int(11) NOT NULL,
	`fecha_inicio` datetime NOT NULL,
	`fecha_fin` datetime NOT NULL,
	`consultorio_id` int(11) NOT NULL,
	`recibido` tinyint(1) NOT NULL,
	`atendido` tinyint(1) NOT NULL,
	`cancelado` tinyint(1) NOT NULL,	PRIMARY KEY  (`id_turno`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`usuarios` (
	`id_usuario` int(20) NOT NULL AUTO_INCREMENT,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`apellido` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`telefono` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`celular` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`obra_social_id` int(20) DEFAULT NULL,
	`notificaciones` tinyint(1) NOT NULL,
	`contra` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`grupo_id` int(11) NOT NULL,
	`facebook_id` int(20) NOT NULL,
	`sexo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,	PRIMARY KEY  (`id_usuario`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

CREATE TABLE `turnera`.`variables_avisos` (
	`id_variable` int(11) NOT NULL AUTO_INCREMENT,
	`modelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`id` int(20) NOT NULL,
	`nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`aviso_id` int(20) NOT NULL,	PRIMARY KEY  (`id_variable`),
	KEY `aviso_fk` (`aviso_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_spanish_ci,
	ENGINE=InnoDB;

