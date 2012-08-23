CREATE TABLE IF NOT EXISTS `clinicas` (
  `id_clinica` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `logo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_clinica`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `especialidades` (
  `id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `especialidades` (`id_especialidad`, `nombre`) VALUES
(1, 'Ginecologia'),
(2, 'Otorrinolaringologia');

CREATE TABLE IF NOT EXISTS `consultorios` (
  `id_consultorio` int(11) NOT NULL AUTO_INCREMENT,
  `clinica_id` int(11) NOT NULL REFERENCES `clinicas`(`id_clinica`),
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_consultorio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `obras_sociales` (
  `id_obra_social` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci,
  `telefono` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_obra_social`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `grupos` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `grupos` (`id_grupo`, `nombre`) VALUES
(1, 'Administradores'),
(2, 'Medicos'),
(3, 'Secretarias'),
(4, 'Paciente');

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `apellido` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `telefono` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `celular` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `obra_social_id` bigint(20) DEFAULT NULL REFERENCES `obras_sociales`(`id_obra_social`),
  `notificaciones` tinyint(1) NOT NULL DEFAULT '1',
  `contra` text COLLATE utf8_spanish_ci NOT NULL,
  `grupo_id` int(11) NOT NULL REFERENCES `grupos`(`id_grupo`),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_unico` (`email`(100))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO `usuarios` (`id_usuario`, `email`, `nombre`, `apellido`, `telefono`, `celular`, `obra_social_id`, `notificaciones`, `contra`, `grupo_id`) VALUES
(2, 'tranfuga25s@gmail.com', 'Esteban Javier', 'Zeller', '', '', NULL, 1, '999d9cffdf4589ff0b2c5cc951fd7d8b872ade69', 1),
(3, 'daniels591@gmail.com', 'Daniel Emilio', 'Sequeira', '4690441', '155128211', NULL, 1, '329cf8fcd743944ee6872027abe2b468dac1bc9e', 1),
(4, 'admin@admin.com', 'Zeller', 'Test', '1223', '283848', NULL, 1, 'be310bfe533c9e09f9967523e122519dc9057915', 4);

CREATE TABLE IF NOT EXISTS `medicos` (
  `id_medico` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL REFERENCES `usuarios`(`id_usuario`),
  `especialidad_id` int(11) NOT NULL REFERENCES `especialidades`(`id_especialidad`),
  `clinica_id` int(11) NOT NULL REFERENCES `clinicas`(`id_clinica`),
  PRIMARY KEY (`id_medico`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `secretarias` (
  `id_secretaria` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL REFERENCES `usuarios`(`id_usuario`),
  `clinica_id` int(11) NOT NULL REFERENCES `clinicas`(`id_clinica`),
  PRIMARY KEY (`id_secretaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `medico_id` BIGINT(20) NOT NULL REFERENCES `medicos`(`id_medico`),
  `duracion` INT(20) NOT NULL DEFAULT 10,
  `consultorio_id` INT(20) NOT NULL REFERENCES `consultios`(`id_consultorio`),
  PRIMARY KEY (`id_disponibilidad`) 
 )  ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `dia_disponibilidad` (
  `disponibilidad_id` bigint(20) NOT NULL,
  `dia` smallint(6) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `hora_inicio_tarde` time DEFAULT NULL,
  `hora_fin_tarde` int(11) DEFAULT NULL,
  PRIMARY KEY (`disponibilidad_id`,`dia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `excepciones` (
  `id_excepcion` bigint(20) NOT NULL AUTO_INCREMENT,
  `medico_id` bigint(20) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `rep_semanal` tinyint(1) NOT NULL,
  `rep_mensual` tinyint(1) NOT NULL,
  `rep_anual` tinyint(1) NOT NULL,
  `relativo` int(11) NOT NULL,
  PRIMARY KEY (`id_excepcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `avisos` (
  `id_aviso` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha_envio` datetime NOT NULL,
  `template` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `layout` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `formato` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `to` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `subject` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `from` tinytext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_aviso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `variables_avisos` (
  `id_variable` int(11) NOT NULL AUTO_INCREMENT,
  `modelo` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `id` bigint(20) NOT NULL,
  `nombre` tinytext COLLATE utf8_spanish_ci NOT NULL,
  `aviso_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id_variable`),
  CONSTRAINT `aviso_fk` FOREIGN KEY (`aviso_id`) REFERENCES `avisos`(`id_aviso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `turnos` (
  `id_turno` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) DEFAULT NULL REFERENCES `usuario`(`id_usuario`),
  `medico_id` int(11) NOT NULL REFERENCES `medico`(`id_medico`),
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `consultorio_id` int(11) NOT NULL REFERENCES `consultorio`(`id_consultorio`),
  `recibido` tinyint(1) NOT NULL,
  `atendido` tinyint(1) NOT NULL,
  `cancelado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;