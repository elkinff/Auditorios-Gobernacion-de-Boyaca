-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2015 a las 16:07:40
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `auditorios_gobernacion`
--
CREATE DATABASE `auditorios_gobernacion` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `auditorios_gobernacion`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditorio`
--

CREATE TABLE IF NOT EXISTS `auditorio` (
  `codigo_auditorio` int(11) NOT NULL,
  `cedula_persona` bigint(20) NOT NULL,
  `nombre_auditorio` varchar(50) NOT NULL,
  `imagen_auditorio` varchar(50) NOT NULL,
  `capacidad_auditorio` int(11) NOT NULL,
  `direccion_auditorio` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo_auditorio`),
  KEY `fk_encargado` (`cedula_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `auditorio`
--

INSERT INTO `auditorio` (`codigo_auditorio`, `cedula_persona`, `nombre_auditorio`, `imagen_auditorio`, `capacidad_auditorio`, `direccion_auditorio`) VALUES
(10, 1234567, 'Ezequiel Rojas', 'auditorio1.jpg', 80, 'Calle 20 # 9-90'),
(11, 1234567, 'Antigua Caja de Prevision', 'auditorio2.jpg', 100, 'Crr 11 # 20-96'),
(12, 1234567, 'Sala de Musica Francisco Cristancho', 'auditorio3.jpg', 86, 'Crr 10 # 11-86'),
(13, 1234567, 'Eduardo Caballero Calderon', 'auditorio4.jpg', 200, 'Crr 10 # 11-86');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `cedula_persona` bigint(20) NOT NULL,
  `nombre_persona` varchar(50) NOT NULL,
  `dependencia_persona` varchar(50) NOT NULL,
  `correo_persona` varchar(80) NOT NULL,
  `celular_persona` bigint(11) NOT NULL,
  `telefono_persona` int(11) DEFAULT NULL,
  `contrasena_persona` varchar(80) NOT NULL,
  `tipo_persona` varchar(2) NOT NULL,
  `jefe_inmediato_persona` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cedula_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE IF NOT EXISTS `reserva` (
  `codigo_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_persona_solicita` bigint(20) NOT NULL,
  `cedula_persona_aprueba` bigint(20) DEFAULT NULL,
  `codigo_auditorio` int(11) NOT NULL,
  `fecha_inicio_reserva` datetime NOT NULL,
  `fecha_final_reserva` datetime NOT NULL,
  `tipo_reserva` varchar(150) NOT NULL,
  `apoyo_logistico_reserva` varchar(150) NOT NULL,
  `descripcion_reserva` varchar(100) DEFAULT NULL,
  `aprobada_reserva` tinyint(1) NOT NULL,
  `observaciones_reserva` varchar(100) DEFAULT NULL,
  `fecha_reserva` datetime NOT NULL,
  PRIMARY KEY (`codigo_reserva`),
  KEY `fk_aprueba` (`cedula_persona_aprueba`),
  KEY `fk_asigna` (`codigo_auditorio`),
  KEY `fk_solicita` (`cedula_persona_solicita`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditorio`
--
ALTER TABLE `auditorio`
  ADD CONSTRAINT `fk_encargado` FOREIGN KEY (`cedula_persona`) REFERENCES `persona` (`cedula_persona`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_aprueba` FOREIGN KEY (`cedula_persona_aprueba`) REFERENCES `persona` (`cedula_persona`),
  ADD CONSTRAINT `fk_asigna` FOREIGN KEY (`codigo_auditorio`) REFERENCES `auditorio` (`codigo_auditorio`),
  ADD CONSTRAINT `fk_solicita` FOREIGN KEY (`cedula_persona_solicita`) REFERENCES `persona` (`cedula_persona`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
