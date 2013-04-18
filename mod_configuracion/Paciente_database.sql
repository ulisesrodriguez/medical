-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 25-01-2011 a las 13:35:52
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `paciente`
-- 

-- --------------------------------------------------------

CREATE DATABASE `paciente`;

USE `paciente`;

-- 
-- Estructura de tabla para la tabla `expediente`
-- 

CREATE TABLE `expediente` (
  `ced_exp` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `dni_exp` int(11) NOT NULL auto_increment,
  `ced_paciente` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `fec_gen_exp` date NOT NULL,
  `estado_exp` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  `sala` varchar(5) character set utf8 collate utf8_spanish_ci NOT NULL,
  `direccion` varchar(200) character set utf8 collate utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `grusan` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`dni_exp`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `expediente`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial`
-- 

CREATE TABLE `historial` (
  `dni_historial` int(11) NOT NULL auto_increment,
  `ced_pac` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `ced_prof` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `fec_gen_hist` date NOT NULL,
  `observacion` varchar(255) character set utf8 collate utf8_spanish_ci NOT NULL,
  `diagnostico` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `tratamiento` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `receta` text character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`dni_historial`),
  UNIQUE KEY `ced_pac` (`ced_pac`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `historial`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `paciente`
-- 

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL auto_increment,
  `ced` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `apellido` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `fec_nac` date NOT NULL,
  `sexo` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  `nombre_representante` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `foto` varchar(200) character set utf8 collate utf8_spanish_ci NOT NULL,
  `pais` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  `estado` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL,
  `ciudad` varchar(11) character set utf8 collate utf8_spanish_ci NOT NULL,
  `municipio` varchar(11) character set utf8 collate utf8_spanish_ci NOT NULL,
  `estado_civil` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  `emergencia` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `grusan` varchar(5) character set utf8 collate utf8_spanish_ci NOT NULL,
  `vih` varchar(1) character set utf8 collate utf8_spanish_ci NOT NULL,
  `ocupacion` varchar(11) character set utf8 collate utf8_spanish_ci NOT NULL,
  `alergico` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `med_act` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `enf_act` text character set utf8 collate utf8_spanish_ci NOT NULL,
  `peso` varchar(11) character set utf8 collate utf8_spanish_ci NOT NULL,
  `talla` varchar(11) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`ced`),
  KEY `id_paciente` (`id_paciente`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `paciente`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `patologia`
-- 

CREATE TABLE `patologia` (
  `id` int(11) NOT NULL auto_increment,
  `ced` varchar(100) NOT NULL,
  `patologia_pac` varchar(100) NOT NULL,
  `habitos_personales` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `patologia`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `profesional`
-- 

CREATE TABLE `profesional` (
  `ced_prof` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  `nombre_apellido` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `tipo_prof` varchar(25) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`ced_prof`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `profesional`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `sala`
-- 

CREATE TABLE `sala` (
  `id_sala` int(11) NOT NULL auto_increment,
  `denominacion` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_sala`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `sala`
-- 

INSERT INTO `sala` VALUES (1, 'EMERGENCIA', 'PACIENTE');
INSERT INTO `sala` VALUES (2, 'SALA-A', 'PACIENTE');
INSERT INTO `sala` VALUES (3, 'LABORATARIO', 'PACIENTE');
INSERT INTO `sala` VALUES (4, 'RAYOS-X', 'PACIENTE');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_prof`
-- 

CREATE TABLE `tipo_prof` (
  `cod_prof` int(11) NOT NULL,
  `denominacion_prof` varchar(200) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`cod_prof`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `tipo_prof`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL auto_increment,
  `login` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `tipo` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  `nombre` varchar(100) character set utf8 collate utf8_spanish_ci NOT NULL,
  `password` varchar(50) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_usu`)
) ENGINE=MyISAM;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (27, 'ISCUlises', 'ADMINISTRADOR', 'ULI', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `usuarios` VALUES (29, 'leonardo', 'ADMINISTRADOR', 'LEONARDO', '81dc9bdb52d04dc20036dbd8313ed055');
