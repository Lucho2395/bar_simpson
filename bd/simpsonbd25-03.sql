-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-03-2022 a las 17:34:40
-- Versión del servidor: 5.7.33
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `simpsonbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes_salida`
--

CREATE TABLE `almacenes_salida` (
  `id_almacen` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `id_recurso_sede` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `almacen_salida_cantidad` decimal(10,2) NOT NULL,
  `almacen_salida_fecha_registro` datetime NOT NULL,
  `almacen_salida_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(11) NOT NULL,
  `id_persona_turno` int(11) NOT NULL,
  `asistencia_fecha` date NOT NULL,
  `asistencia_hora` time NOT NULL,
  `asistencia_hora_salida` time DEFAULT NULL COMMENT 'Para registrar Salida',
  `asistencia_valor` int(11) NOT NULL,
  `asistencia_horas` int(11) NOT NULL DEFAULT '0',
  `asistencia_observacion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asistencia_tipo` tinyint(2) DEFAULT NULL COMMENT '0 entrada, 1 salida',
  `asistencia_estado` tinyint(4) NOT NULL,
  `asistencia_proyectada` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia_fecha`
--

CREATE TABLE `asistencia_fecha` (
  `id_asistencia_fecha` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `id_turno` int(11) NOT NULL,
  `id_caja_numero` int(11) NOT NULL,
  `caja_fecha` date NOT NULL,
  `id_usuario_apertura` int(11) NOT NULL,
  `caja_apertura` decimal(10,2) NOT NULL,
  `caja_fecha_apertura` datetime NOT NULL,
  `id_usuario_cierre` int(11) DEFAULT NULL,
  `caja_cierre` decimal(10,2) DEFAULT NULL,
  `caja_fecha_cierre` datetime DEFAULT NULL,
  `caja_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_numero`
--

CREATE TABLE `caja_numero` (
  `id_caja_numero` int(11) NOT NULL,
  `caja_numero_nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `caja_numero_impresora` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caja_numero_fecha` datetime NOT NULL,
  `caja_numero_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `caja_numero`
--

INSERT INTO `caja_numero` (`id_caja_numero`, `caja_numero_nombre`, `caja_numero_impresora`, `caja_numero_fecha`, `caja_numero_estado`) VALUES
(1, 'Caja 1', 'Ticketera', '2021-10-15 09:52:20', 1),
(2, 'Caja 2', 'Ticketera_2', '2021-10-15 09:52:20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `categoria_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `categoria_fecha_registro` datetime NOT NULL,
  `categoria_tipo` tinyint(2) NOT NULL COMMENT '1 resta unsumos y 2 resta almacen',
  `categoria_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria_nombre`, `categoria_fecha_registro`, `categoria_tipo`, `categoria_estado`) VALUES
(6, 'INSUMOS', '2021-05-01 00:00:00', 1, 1),
(15, 'OTROS', '2022-03-02 12:56:48', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_negocio`
--

CREATE TABLE `categorias_negocio` (
  `id_categoria_negocio` int(11) NOT NULL,
  `id_usuario_creacion` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `recurso_categoria_estado` tinyint(1) NOT NULL,
  `recurso_categoria_fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_negocio`
--

INSERT INTO `categorias_negocio` (`id_categoria_negocio`, `id_usuario_creacion`, `id_negocio`, `id_categoria`, `recurso_categoria_estado`, `recurso_categoria_fecha`) VALUES
(7, 1, 3, 6, 1, '2021-04-15 19:49:03'),
(14, 2, 3, 15, 1, '2022-03-02 12:56:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `ciudad_nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ciudad_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `ciudad_nombre`, `ciudad_estado`) VALUES
(1, 'Iquitos', 1),
(2, 'Nauta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_tipodocumento` int(11) NOT NULL,
  `cliente_razonsocial` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_numero` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_correo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_direccion_2` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente_fecha` datetime NOT NULL,
  `cliente_estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_tipodocumento`, `cliente_razonsocial`, `cliente_nombre`, `cliente_numero`, `cliente_correo`, `cliente_direccion`, `cliente_direccion_2`, `cliente_telefono`, `cliente_fecha`, `cliente_estado`) VALUES
(3, 2, '', 'Anonimo', '11111111', 'anonimo@gmail.com', 'Calle S/n', '', '999999999', '2021-03-26 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `comanda_nombre_delivery` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comanda_direccion_delivery` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comanda_telefono_delivery` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comanda_cantidad_personas` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comanda_correlativo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comanda_total` decimal(10,2) NOT NULL,
  `comanda_fecha_registro` datetime NOT NULL,
  `comanda_estado` tinyint(2) NOT NULL,
  `comanda_codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id_comanda`, `id_mesa`, `id_usuario`, `id_cliente`, `comanda_nombre_delivery`, `comanda_direccion_delivery`, `comanda_telefono_delivery`, `comanda_cantidad_personas`, `comanda_correlativo`, `comanda_total`, `comanda_fecha_registro`, `comanda_estado`, `comanda_codigo`) VALUES
(1, 6, 2, NULL, NULL, NULL, NULL, '1', '040322-1', '155.00', '2022-03-04 21:51:06', 1, '1646448666.7359');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda_detalle`
--

CREATE TABLE `comanda_detalle` (
  `id_comanda_detalle` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `comanda_detalle_precio` decimal(10,2) NOT NULL,
  `comanda_detalle_cantidad` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comanda_detalle_despacho` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `comanda_detalle_total` decimal(10,2) NOT NULL,
  `comanda_detalle_observacion` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comanda_detalle_eliminacion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comanda_detalle_fecha_eliminacion` datetime DEFAULT NULL,
  `comanda_detalle_fecha_registro` datetime NOT NULL,
  `comanda_detalle_estado` tinyint(4) NOT NULL,
  `comanda_detalle_estado_venta` tinyint(2) NOT NULL DEFAULT '0',
  `comanda_detalle_hora_entrega` time DEFAULT NULL,
  `comanda_detalle_usuario` int(11) DEFAULT NULL,
  `id_usuario` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `comanda_detalle`
--

INSERT INTO `comanda_detalle` (`id_comanda_detalle`, `id_comanda`, `id_producto`, `comanda_detalle_precio`, `comanda_detalle_cantidad`, `comanda_detalle_despacho`, `comanda_detalle_total`, `comanda_detalle_observacion`, `comanda_detalle_eliminacion`, `comanda_detalle_fecha_eliminacion`, `comanda_detalle_fecha_registro`, `comanda_detalle_estado`, `comanda_detalle_estado_venta`, `comanda_detalle_hora_entrega`, `comanda_detalle_usuario`, `id_usuario`) VALUES
(1, 1, 10, '35.00', '1', 'SALON', '35.00', '-', NULL, NULL, '2022-03-04 21:51:06', 1, 0, NULL, NULL, 2),
(2, 1, 30, '10.00', '12', 'SALON', '120.00', '-', NULL, NULL, '2022-03-04 21:53:31', 1, 0, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversiones`
--

CREATE TABLE `conversiones` (
  `id_conversion` int(11) NOT NULL,
  `id_recurso_sede` int(11) NOT NULL,
  `conversion_cantidad` decimal(10,2) NOT NULL,
  `conversion_unidad_medida` int(11) NOT NULL,
  `conversion_fecha_registro` datetime NOT NULL,
  `conversion_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativos`
--

CREATE TABLE `correlativos` (
  `id_correlativo` int(11) NOT NULL,
  `correlativo_b` int(11) NOT NULL,
  `correlativo_f` int(11) NOT NULL,
  `correlativo_in` int(11) NOT NULL,
  `correlativo_out` int(11) NOT NULL,
  `correlativo_nc` int(11) NOT NULL,
  `correlativo_nd` int(11) NOT NULL,
  `correlativo_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `correlativos`
--

INSERT INTO `correlativos` (`id_correlativo`, `correlativo_b`, `correlativo_f`, `correlativo_in`, `correlativo_out`, `correlativo_nc`, `correlativo_nd`, `correlativo_venta`) VALUES
(2, 6, 3, 100000, 100001, 2, 1, 100030);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_detalle_compra` int(11) NOT NULL,
  `id_orden_compra` int(11) NOT NULL,
  `id_recurso_sede` int(11) NOT NULL,
  `detalle_compra_cantidad` float NOT NULL,
  `detalle_compra_cantidad_recibida` float DEFAULT NULL,
  `detalle_compra_precio_compra` decimal(10,2) NOT NULL,
  `detalle_compra_total_pedido` decimal(10,2) NOT NULL,
  `detalle_compra_tipo_moneda` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detalle_compra_tipo_cambio` decimal(10,5) DEFAULT NULL,
  `detalle_compra_total_dolares` decimal(10,2) DEFAULT '0.00',
  `detalle_compra_total_pagado` decimal(10,2) DEFAULT NULL,
  `detalle_compra_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recetas`
--

CREATE TABLE `detalle_recetas` (
  `id_detalle_receta` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_recursos_sede` int(11) NOT NULL,
  `detalle_receta_unidad_medida` int(11) DEFAULT NULL,
  `detalle_receta_cantidad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalle_receta_precio` decimal(10,2) NOT NULL,
  `detalle_receta_estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_recetas`
--

INSERT INTO `detalle_recetas` (`id_detalle_receta`, `id_receta`, `id_recursos_sede`, `detalle_receta_unidad_medida`, `detalle_receta_cantidad`, `detalle_receta_precio`, `detalle_receta_estado`) VALUES
(1, 32, 7, 0, '1', '0.00', 1),
(2, 30, 5, 0, '1', '0.00', 1),
(3, 27, 2, 0, '1', '0.00', 1),
(4, 29, 4, 0, '1', '0.00', 1),
(5, 34, 9, 0, '1', '0.00', 1),
(6, 28, 3, 0, '1', '0.00', 1),
(7, 31, 6, 0, '1', '0.00', 1),
(8, 33, 8, 0, '1', '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documento` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_adjunto` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `documento_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `documento_fechainicio` date NOT NULL,
  `documento_fechafin` date NOT NULL,
  `documento_fecha_registro` datetime NOT NULL,
  `documento_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `empresa_razon_social` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_nombrecomercial` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_descrpcion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_ruc` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_domiciliofiscal` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_pais` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_departamento` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_provincia` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_distrito` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_ubigeo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_telefono1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_telefono2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_celular1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_celular2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_foto` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_correo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa_usuario_sol` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_clave_sol` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_fechayhora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `empresa_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa_razon_social`, `empresa_nombrecomercial`, `empresa_descrpcion`, `empresa_ruc`, `empresa_domiciliofiscal`, `empresa_pais`, `empresa_departamento`, `empresa_provincia`, `empresa_distrito`, `empresa_ubigeo`, `empresa_telefono1`, `empresa_telefono2`, `empresa_celular1`, `empresa_celular2`, `empresa_foto`, `empresa_correo`, `empresa_usuario_sol`, `empresa_clave_sol`, `empresa_fechayhora`, `empresa_estado`) VALUES
(1, 'HNOS.GARCIA SERVICIOS MULTIPLES S.R.L.', 'SIMPSON RESTOBAR', 'SIMPSON RESTOBAR', '20606798939', 'CAL.LOS ROSALES NRO. 219C', 'PE', 'LORETO', 'MAYNAS', 'SAN JUAN BAUTISTA', '160101', NULL, NULL, NULL, NULL, NULL, NULL, 'SIMPBUFE', 'Simpbufeo1', '2022-03-02 12:30:31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen`
--

CREATE TABLE `envio_resumen` (
  `id_envio_resumen` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT '1',
  `envio_resumen_fecha` date NOT NULL,
  `envio_resumen_serie` varchar(20) NOT NULL,
  `envio_resumen_correlativo` varchar(20) NOT NULL,
  `envio_resumen_nombreXML` varchar(200) DEFAULT NULL,
  `envio_resumen_nombreCDR` varchar(200) DEFAULT NULL,
  `envio_resumen_estado` tinyint(4) NOT NULL DEFAULT '0',
  `envio_resumen_estadosunat` varchar(2000) DEFAULT NULL,
  `envio_resumen_estadosunat_consulta` varchar(2000) DEFAULT NULL,
  `envio_resumen_ticket` varchar(100) NOT NULL,
  `envio_sunat_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio_resumen_detalle`
--

CREATE TABLE `envio_resumen_detalle` (
  `id_envio_resumen_detalle` int(11) NOT NULL,
  `id_envio_resumen` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `envio_resumen_detalle_condicion` tinyint(4) NOT NULL COMMENT '1-Creacion, 2-Actualizacion, 3-Baja'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feriados`
--

CREATE TABLE `feriados` (
  `id_feriado` int(11) NOT NULL,
  `feriado_dia` date NOT NULL,
  `feriado_motivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `feriados`
--

INSERT INTO `feriados` (`id_feriado`, `feriado_dia`, `feriado_motivo`) VALUES
(2, '2020-06-29', 'San Pedro y San Pablo'),
(3, '2020-07-28', 'Fiestas Patrias'),
(5, '2020-08-30', 'Santa Rosa de Lima'),
(7, '2020-11-01', 'Dia de Todos los Santos'),
(8, '2020-12-08', 'Inmaculada Concepción'),
(9, '2020-12-25', 'Navidad'),
(12, '2021-07-28', 'Fiestas Patrias'),
(13, '2021-12-31', 'Año Nuevo'),
(14, '2021-01-01', 'Año Nuevo'),
(15, '2021-04-01', 'Jueves Santo'),
(16, '2021-04-02', 'Viernes Santo'),
(17, '2021-05-01', 'Dia del Trabajo'),
(18, '2021-06-29', 'San Pedro y San Pablo'),
(19, '2021-07-28', 'FIestas Patrias'),
(21, '2021-07-29', 'Fiestas Patrias'),
(22, '2021-08-30', 'Santa Rosa de Lima'),
(23, '2021-10-08', 'Combate de Angamos'),
(24, '2021-11-01', 'Dia de los Santos'),
(25, '2021-12-08', 'Dia de la Inmaculada Concepción'),
(26, '2021-12-25', 'Navidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_personal`
--

CREATE TABLE `gastos_personal` (
  `id_gasto_personal` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_caja_numero` int(11) NOT NULL,
  `gasto_personal_concepto` varchar(300) NOT NULL,
  `gasto_personal_monto` decimal(10,2) NOT NULL,
  `gasto_personal_fecha` date DEFAULT NULL,
  `gasto_personal_fecha_registro` datetime NOT NULL,
  `gasto_personal_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `grupo_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `grupo_ticketera` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grupo_fecha_registro` datetime NOT NULL,
  `grupo_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `grupo_nombre`, `grupo_ticketera`, `grupo_fecha_registro`, `grupo_estado`) VALUES
(1, 'CALIENTES', 'Ticketera', '2021-03-15 00:00:00', 1),
(2, 'FRIOS', 'Ticketera', '2021-03-15 00:00:00', 1),
(3, 'CALIENTE FRIO', 'Ticketera', '2021-04-30 21:26:17', 1),
(4, 'BEBIDAS', 'Ticketera', '2021-10-06 09:41:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `igv`
--

CREATE TABLE `igv` (
  `id_igv` int(11) NOT NULL,
  `igv_codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `igv_codigoafectacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `igv_descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `igv_codigoInternacional` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `igv_nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `igv_tipodeafectacion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `igv_tipo_json` tinyint(4) NOT NULL,
  `igv_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `igv`
--

INSERT INTO `igv` (`id_igv`, `igv_codigo`, `igv_codigoafectacion`, `igv_descripcion`, `igv_codigoInternacional`, `igv_nombre`, `igv_tipodeafectacion`, `igv_tipo_json`, `igv_estado`) VALUES
(1, '1000', '10', 'IGV Impuesto General a las Ventas', 'VAT', 'IGV', 'Gravado - Operación Onerosa', 1, 1),
(2, '9998', '30', 'Inafecta', 'FRE', 'INA', 'Inafecto - Operación Onerosa', 9, 1),
(3, '9997', '20', 'Exonerado', 'VAT', 'EXO', 'Exonerado - Operación Onerosa', 8, 1),
(4, '9996', '11', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Retiro por premio', 2, 1),
(5, '9996', '12', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Retiro por donación', 3, 1),
(6, '9996', '13', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Retiro', 4, 1),
(7, '9996', '14', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Retiro por publicidad', 5, 1),
(8, '9996', '15', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Bonificaciones', 6, 1),
(9, '9996', '16', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - Retiro por entrega a trabajadores', 7, 1),
(10, '1016', '17', 'Impuesto a la Venta Arroz Pilado', 'VAT', 'IVAP', 'Gravado - IVAP', 17, 1),
(11, '9996', '21', 'Gratuita', 'FRE', 'GRA', '[Gratuita] Exonerado - Transferencia gratuita', 0, 0),
(12, '9996', '31', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecta - Retiro por Bonificación', 10, 1),
(13, '9996', '32', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Retiro', 11, 1),
(14, '9996', '33', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Retiro por Muestras Médicas', 12, 1),
(15, '9996', '34', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Retiro por Convenio Colectivo', 13, 1),
(16, '9996', '35', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Retiro por premio', 14, 1),
(17, '9996', '36', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Retiro por publicidad', 15, 1),
(18, '9996', '37', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Inafecto - Transferencia gratuita', 0, 0),
(19, '9995', '40', 'Exportación', 'FRE', 'EXP', 'Exportación de Bienes o Servicios', 16, 1),
(20, '9996', '17', 'Gratuito', 'FRE', 'GRA', '[Gratuita] Gravado - IVAP', 101, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memorandum`
--

CREATE TABLE `memorandum` (
  `id_memorandum` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `memorandum_numero` int(11) DEFAULT NULL,
  `memorandum_motivo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `memorandum_otros` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `memorandum_fecha` date NOT NULL,
  `memorandum_descripcion` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `memorandum_fecha_creacion` datetime NOT NULL,
  `id_user_aprobacion` int(11) DEFAULT NULL,
  `memoradum_fecha_aprobacion` datetime DEFAULT NULL,
  `memorandum_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `menu_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_controlador` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_icono` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `menu_orden` int(11) NOT NULL,
  `menu_mostrar` tinyint(1) NOT NULL,
  `menu_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `menu_nombre`, `menu_controlador`, `menu_icono`, `menu_orden`, `menu_mostrar`, `menu_estado`) VALUES
(1, 'Login', 'Login', '-', 0, 0, 1),
(2, 'Panel de Inicio', 'Admin', 'fa fa-dashboard', 1, 1, 1),
(3, 'Gestión de Menu', 'Menu', 'fa fa-desktop', 2, 1, 1),
(4, 'Roles de Usuario', 'Rol', 'fa fa-user-secret', 3, 1, 1),
(5, 'Usuarios', 'Usuario', 'fa fa-user', 4, 1, 1),
(6, 'Datos Personales', 'Datos', 'fa fa-', 0, 0, 1),
(7, 'Negocios', 'Negocio', 'fa fa-industry', 10, 1, 1),
(8, 'Recursos', 'Recursos', 'fa fa-cart-plus', 7, 0, 1),
(9, 'Proveedores', 'Proveedor', 'fa fa-car', 9, 1, 1),
(10, 'Orden de Compra', 'Ordencompra', 'fa fa-plus-square', 9, 1, 1),
(11, 'Productos', 'Producto', 'fa fa-tags', 9, 1, 1),
(12, 'Pedidos', 'Pedido', 'fa fa-shopping-cart', 11, 1, 1),
(13, 'Mesas', 'Mesa', 'fa fa-sitemap', 6, 1, 1),
(14, 'Almacen', 'Almacen', 'fa fa-folder-open', 6, 1, 1),
(15, 'Recetas', 'Receta', 'fa fa-file-text-o', 9, 1, 1),
(16, 'Ventas ', 'Ventas', 'fa fa-money', 12, 1, 1),
(17, 'Clientes', 'Cliente', 'fa fa-male', 5, 1, 1),
(18, 'Conversiones', 'Conversiones', 'fa fa-refresh', 8, 1, 1),
(19, 'Movimientos', 'Egreso', 'fa fa-usd', 13, 1, 1),
(20, 'Reportes', 'Reporte', 'fa fa-calendar-minus-o', 14, 1, 1),
(21, 'Insumos', 'Insumos', 'fa fa-apple', 8, 0, 1),
(22, 'Categorias', 'Categorias', 'fa fa-cutlery', 6, 0, 1),
(23, 'Recursos Humanos', 'Rhumanos', 'fa fa-folder-open', 2, 1, 1),
(24, 'Pedido Libre', 'Pedido', 'fa fa-', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `mesa_nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mesa_capacidad` int(100) NOT NULL,
  `mesa_estado` tinyint(4) NOT NULL,
  `mesa_estado_atencion` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `id_sucursal`, `mesa_nombre`, `mesa_capacidad`, `mesa_estado`, `mesa_estado_atencion`) VALUES
(-28, 5, 'B - 09', 1, 1, 0),
(-27, 5, 'B - 08', 1, 1, 0),
(-26, 5, 'B - 07', 1, 1, 0),
(-25, 5, 'B - 06', 1, 1, 0),
(-24, 5, 'B - 05', 1, 1, 0),
(-23, 5, 'B - 04', 1, 1, 0),
(-22, 5, 'B - 03', 1, 1, 0),
(-21, 5, 'B - 02', 1, 1, 0),
(-20, 5, 'B - 01', 1, 1, 0),
(-6, 5, 'TG - 06', 2, 1, 0),
(-5, 5, 'TG - 05', 2, 1, 0),
(-4, 5, 'TG - 04', 2, 1, 0),
(-3, 5, 'TG - 03', 2, 1, 0),
(-2, 5, 'TG - 02', 2, 1, 0),
(-1, 5, 'TG - 01', 2, 1, 0),
(0, 5, 'DELIVERY', 1, 1, 0),
(6, 5, 'Mesa 01', 3, 1, 1),
(7, 5, 'Mesa 02', 2, 1, 0),
(8, 5, 'Mesa 03', 4, 1, 0),
(9, 5, 'Mesa 04', 6, 1, 0),
(16, 5, 'Mesa 05', 4, 1, 0),
(17, 5, 'Mesa 06', 4, 1, 0),
(18, 5, 'Mesa 07', 4, 1, 0),
(19, 5, 'Mesa 08', 4, 1, 0),
(20, 5, 'Mesa 09', 4, 1, 0),
(21, 5, 'Mesa 10', 4, 1, 0),
(22, 5, 'Mesa 11', 4, 1, 0),
(23, 5, 'Mesa 12', 4, 1, 0),
(24, 5, 'Mesa 13', 4, 1, 0),
(25, 5, 'Mesa 14', 4, 1, 0),
(26, 5, 'Mesa 15', 4, 1, 0),
(27, 5, 'Mesa 16', 4, 1, 0),
(28, 5, 'Mesa 17', 4, 1, 0),
(29, 5, 'Mesa 18', 4, 1, 0),
(30, 5, 'Mesa 19', 4, 1, 0),
(31, 5, 'Mesa 20', 4, 1, 0),
(32, 5, 'Mesa 21', 4, 1, 0),
(33, 5, 'Mesa 22', 4, 1, 0),
(34, 5, 'Mesa 23', 4, 1, 0),
(35, 5, 'Mesa 24', 4, 1, 0),
(36, 5, 'Mesa 25', 4, 1, 0),
(37, 5, 'Mesa 26', 4, 1, 0),
(38, 5, 'Mesa 27', 4, 1, 0),
(39, 5, 'Mesa 28', 4, 1, 0),
(40, 5, 'Mesa 29', 4, 1, 0),
(41, 5, 'Mesa 30', 4, 1, 0),
(42, 5, 'Mesa 31', 4, 1, 0),
(43, 5, 'Mesa 32', 4, 1, 0),
(44, 5, 'Mesa 33', 4, 1, 0),
(45, 5, 'Mesa 34', 4, 1, 0),
(46, 5, 'Mesa 35', 4, 1, 0),
(47, 5, 'Mesa 36', 4, 1, 0),
(48, 5, 'Mesa 37', 4, 1, 0),
(49, 5, 'Mesa 38', 4, 1, 0),
(50, 5, 'Mesa 39', 4, 1, 0),
(51, 5, 'Mesa 40', 4, 1, 0),
(52, 5, 'Mesa 41', 4, 1, 0),
(53, 5, 'Mesa 42', 4, 1, 0),
(54, 5, 'Mesa 43', 4, 1, 0),
(55, 5, 'Mesa 44', 4, 1, 0),
(56, 5, 'Mesa 45', 4, 1, 0),
(57, 5, 'Mesa 46', 4, 1, 0),
(58, 5, 'Mesa 47', 4, 1, 0),
(59, 5, 'Mesa 48', 4, 1, 0),
(60, 5, 'Mesa 49', 4, 1, 0),
(61, 5, 'Mesa 50', 4, 1, 0),
(62, 5, 'Mesa 99', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `id_moneda` int(11) NOT NULL,
  `moneda` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `abreviado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `abrstandar` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `activo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`id_moneda`, `moneda`, `abreviado`, `abrstandar`, `simbolo`, `activo`) VALUES
(1, 'SOLES', 'sol', 'PEN', 'S/', '1'),
(2, 'DÓLARES', 'dol', 'USD', '$', '1'),
(3, 'EUROS', 'eur', 'EUR', 'E', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `id_caja_numero` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `movimiento_tipo` tinyint(2) NOT NULL COMMENT '1 es entrada y 2 es salida',
  `egreso_descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `egreso_monto` decimal(10,2) NOT NULL,
  `egreso_fecha_registro` datetime NOT NULL,
  `egreso_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocios`
--

CREATE TABLE `negocios` (
  `id_negocio` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `negocio_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `negocio_direccion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `negocio_ruc` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `negocio_foto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `negocio_telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `negocio_estado` tinyint(1) NOT NULL,
  `negocio_fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `negocios`
--

INSERT INTO `negocios` (`id_negocio`, `id_ciudad`, `negocio_nombre`, `negocio_direccion`, `negocio_ruc`, `negocio_foto`, `negocio_telefono`, `negocio_estado`, `negocio_fecha_registro`) VALUES
(3, 1, 'SIMPSON RESTOBAR', 'CAL.LOS ROSALES NRO. 219C', '20606798939', 'media/negocio/LA ULTIMA CONCHITA_24032021142225.jp', '9999999999', 1, '2021-03-24 14:22:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_venta`
--

CREATE TABLE `nota_venta` (
  `id_nota_venta` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT '1',
  `id_usuario` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `nota_venta_tipo` varchar(10) NOT NULL COMMENT 'aca siempre 20, porque es nota de venta',
  `nota_venta_serie` varchar(10) NOT NULL,
  `nota_venta_correlativo` varchar(60) NOT NULL,
  `nota_venta_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_pago_cliente` decimal(10,2) DEFAULT '0.00',
  `nota_venta_vuelto` decimal(10,2) DEFAULT '0.00',
  `nota_venta_fecha` datetime NOT NULL,
  `nota_venta_observacion` varchar(500) DEFAULT NULL,
  `nota_venta_cancelar` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'si esta 1 significa que fue cancelada',
  `nota_venta_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_venta_detalle`
--

CREATE TABLE `nota_venta_detalle` (
  `id_nota_venta_detalle` int(11) NOT NULL,
  `id_nota_venta` int(11) NOT NULL,
  `id_comanda_detalle` int(11) NOT NULL,
  `nota_venta_detalle_valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_precio_valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_nombre_producto` varchar(200) NOT NULL,
  `nota_venta_detalle_cantidad` double NOT NULL,
  `nota_venta_detalle_total_igv` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_porcentaje_igv` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_total_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_valor_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nota_venta_detalle_importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_producto_precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obligacion_pagar`
--

CREATE TABLE `obligacion_pagar` (
  `id_obligacion` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `id_user_creacion` int(11) NOT NULL,
  `id_user_aprobacion` int(11) DEFAULT NULL,
  `obligacion_clase` tinyint(4) NOT NULL,
  `obligacion_codigo` int(11) DEFAULT NULL,
  `obligacion_fecha_creacion` date NOT NULL,
  `obligacion_hora_creacion` time NOT NULL,
  `obligacion_fecha_inicio` date DEFAULT NULL,
  `obligacion_fecha_fin` date NOT NULL,
  `obligacion_estado` tinyint(1) NOT NULL,
  `obligacion_tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `obligacion_concepto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obligacion_activo` tinyint(1) NOT NULL,
  `obligacion_moneda` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obligacion_importe` float(10,2) DEFAULT NULL,
  `obligacion_id_persona` int(11) DEFAULT NULL,
  `obligacion_documentacion` tinyint(4) NOT NULL,
  `obligacion_fecha_aprobacion` date DEFAULT NULL,
  `obligacion_hora_aprobacion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obligacion_personal`
--

CREATE TABLE `obligacion_personal` (
  `id_obligacionper` int(11) NOT NULL,
  `id_obligacion` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `obligacionper_dias_efectivos` float(10,2) NOT NULL,
  `obligacionper_dias_laborales` int(11) NOT NULL,
  `obligacionper_monto_mensual` float(10,2) NOT NULL,
  `obligacionper_total_mensual` float(10,2) NOT NULL,
  `obligacionper_subtotal` float(10,2) NOT NULL,
  `obligacionper_total` float(10,2) NOT NULL,
  `obligacionper_banco` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obligacionper_cuenta` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `obligacionper_estadi` tinyint(1) NOT NULL,
  `obligacionper_cts` float(10,2) DEFAULT NULL,
  `obligacionper_grati` float(10,2) DEFAULT NULL,
  `obligacionper_vaca` float(10,2) DEFAULT NULL,
  `obligacionper_reint` float(10,2) DEFAULT NULL,
  `obligacionper_fondo` float(10,2) DEFAULT NULL,
  `obligacionper_desc` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id_opcion` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `opcion_nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `opcion_funcion` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `opcion_icono` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opcion_mostrar` tinyint(1) NOT NULL,
  `opcion_orden` int(11) NOT NULL,
  `opcion_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`id_opcion`, `id_menu`, `opcion_nombre`, `opcion_funcion`, `opcion_icono`, `opcion_mostrar`, `opcion_orden`, `opcion_estado`) VALUES
(1, 1, 'Inicio de Sesion', 'inicio', '-', 0, 0, 1),
(2, 2, 'Inicio', 'inicio', 'fa fa-play', 1, 1, 1),
(3, 2, 'Cerrar Sesión', 'finalizar_sesion', 'fa fa-sign-out', 0, 1, 1),
(4, 3, 'Gestionar Menús', 'inicio', NULL, 1, 1, 1),
(5, 3, 'Iconos', 'iconos', NULL, 1, 2, 1),
(6, 3, 'Accesos por Rol', 'roles', NULL, 0, 0, 1),
(7, 3, 'Opciones por Menú', 'opciones', NULL, 0, 0, 1),
(8, 3, 'Gestionar Permisos(breve)', 'gestion_permisos', '', 0, 0, 1),
(9, 4, 'Gestionar Roles', 'inicio', '', 1, 1, 1),
(10, 4, 'Accesos por Rol', 'accesos', '', 0, 0, 1),
(11, 3, 'Gestionar Restricciones(breve)', 'gestion_restricciones', '', 0, 0, 1),
(12, 5, 'Gestionar Usuarios', 'inicio', '', 1, 1, 1),
(13, 6, 'Editar Datos', 'editar_datos', '', 0, 0, 1),
(14, 6, 'Editar Usuario', 'editar_usuario', '', 0, 0, 1),
(15, 6, 'Cambiar Contraseña', 'cambiar_contrasenha', '', 0, 0, 1),
(16, 7, 'Gestionar', 'gestionar', '', 1, 1, 1),
(17, 7, 'Asignar Sucursal', 'sucursal', '', 0, 2, 1),
(18, 7, 'Usuarios Sucursal', 'usuarios_sucursal', '', 0, 3, 1),
(19, 7, 'Usuarios Negocios', 'usuarios_negocio', '', 0, 4, 1),
(20, 8, 'Gestionar Categorias', 'categorias', '', 1, 1, 1),
(21, 8, 'Gestionar Recursos', 'recursos', '', 1, 2, 1),
(22, 9, 'Gestionar', 'inicio', '', 1, 1, 1),
(23, 10, 'Registrar Orden de Compra', 'orden_compra', '', 1, 1, 1),
(24, 10, 'Ordenes de Compras Pendientes', 'orden_pendiente', '', 1, 2, 1),
(25, 10, 'Ordenes de Compra Aprobadas', 'orden_aprobada', '', 1, 3, 1),
(26, 10, 'Detalle de la Orden de Compra', 'detalle_orden_compra', '', 0, 4, 1),
(27, 10, 'Editar Orden de Compra', 'orden_editar', '', 0, 5, 1),
(28, 10, 'Recepcion Detalle Compra', 'recepcion_orden', '', 0, 6, 1),
(29, 11, 'Gestionar Productos', 'gestionar', '', 1, 1, 1),
(30, 12, 'Gestionar Pedidos', 'gestionar', '', 1, 1, 1),
(31, 13, 'Gestionar Mesas', 'inicio', '', 1, 1, 1),
(32, 14, 'Gestionar Almacen', 'inicio', '', 1, 1, 1),
(33, 12, 'Asignar Pedido', 'asignar', '', 0, 2, 1),
(34, 12, 'Listar Grupos', 'listar_grupos', '', 1, 5, 1),
(35, 12, 'Listado', 'listado_detalle_grupo', '', 0, 4, 1),
(36, 12, 'Listado Bebidas', 'listado_bebida', '', 0, 5, 1),
(37, 15, 'Gestionar Recetas', 'inicio', '', 1, 1, 1),
(38, 15, 'Gestionar Detalle Recetas', 'detalle_receta', '', 0, 2, 1),
(39, 16, 'Pendientes de Declarar', 'historial_ventas', '', 1, 2, 1),
(40, 12, 'Detalle del Pedido', 'detalle_pedido', '', 0, 6, 1),
(41, 17, 'Gestionar Clientes', 'inicio', '', 1, 1, 1),
(42, 18, 'Gestionar', 'gestionar', '', 1, 1, 1),
(43, 19, 'Gestionar Movimientos', 'gestionar', '', 1, 1, 1),
(44, 20, 'Reporte Ingresos y Egresos', 'ingresos_egresos', '', 1, 1, 1),
(45, 21, 'Gestionar Insumos', 'gestionar', '', 1, 1, 1),
(46, 12, 'Realizar Delivery', 'delivery', '', 1, 2, 1),
(47, 16, 'Ver Detalle Venta', 'ver_detalle_venta', '', 0, 0, 1),
(48, 12, 'Historial de Deliverys', 'historial_delivery', '', 1, 3, 1),
(49, 20, 'Reporte Clientes', 'reporte_clientes', '', 1, 2, 1),
(50, 20, 'Reporte Proveedores', 'reporte_proveedores', '', 0, 3, 1),
(51, 20, 'Reporte Meseros', 'reporte_meseros', '', 1, 4, 1),
(52, 16, 'Historial Ventas Sunat', 'historial_ventas_enviadas', '', 1, 3, 1),
(53, 16, 'Resumen Diario', 'envio_resumenes_diario', '', 1, 4, 1),
(54, 20, 'Reporte Insumos', 'reporte_insumos', '', 0, 6, 1),
(55, 16, 'Historial Resumen Diario', 'historial_resumen_diario', '', 1, 5, 1),
(56, 16, 'Ver Detalle Resumen', 'ver_detalle_resumen', '', 0, 0, 1),
(57, 12, 'ticket_pedido', 'ticket_pedido', '', 0, 0, 1),
(58, 16, 'imprimir_ticket_pdf', 'imprimir_ticket_pdf', '', 0, 0, 1),
(59, 12, 'ticket_venta', 'ticket_venta', '', 0, 0, 1),
(60, 16, 'Excel Ventas', 'excel_ventas_enviadas', '', 0, 0, 1),
(61, 12, 'Detalle Delivery', 'detalle_delivery', '', 0, 2, 1),
(62, 12, 'Historial Deliverys Entregados', 'historial_delivery_entregados', '', 1, 4, 1),
(63, 12, 'Ticket Venta Delivery', 'ticket_venta_delivery', '', 0, 0, 1),
(64, 16, 'Historia Bajas de Facturas', 'historial_bajas_facturas', '', 1, 6, 1),
(65, 16, 'Generar Nota', 'generar_nota', '', 0, 0, 1),
(66, 22, 'Gestionar Categorias', 'gestionar', '', 1, 0, 1),
(67, 23, 'Periodo Laboral', 'periodolaboral', '', 1, 4, 1),
(68, 23, 'Asistencia de Personal', 'asistencia', '', 1, 5, 1),
(69, 23, 'Convocatoria', 'convocatoria', '', 0, 1, 1),
(70, 23, 'Gestión de Personal', 'gestion_personal', '', 1, 2, 1),
(71, 23, 'Memorandum al Personal', 'memorandum', '', 1, 6, 1),
(72, 23, 'Obligación Laboral', 'obligacion_laboral', '', 0, 7, 1),
(73, 23, 'Listado de Memorandum', 'listar_memo', '', 0, 6, 1),
(74, 23, 'PDF MEMO', 'ver_memo', '', 0, 0, 1),
(75, 23, 'Editar Personal', 'editar_personal', '', 0, 0, 1),
(76, 23, 'Detalle Periodo Laboral', 'detalle_periodo_laboral', '', 0, 0, 1),
(77, 23, 'Agregar Periodo', 'agregar_periodo', '', 0, 0, 1),
(78, 23, 'Adjuntar Documentos', 'adjuntar', '', 0, 0, 1),
(79, 23, 'Gestionar Feriados', 'feriados', '', 0, 0, 1),
(80, 23, 'Proyectar Asistencia', 'proyectar_asistencia', '', 0, 0, 1),
(81, 23, 'Opciones', 'opciones', '', 0, 0, 1),
(82, 23, 'Por Persona', 'por_persona', '', 0, 0, 1),
(83, 23, 'Consultar', 'consultar', '', 0, 0, 1),
(84, 23, 'Asitencia Personal', 'asistencia_personal', '', 0, 0, 1),
(85, 23, 'Constancia de Trabajo', 'constancia_trabajo', '', 0, 0, 1),
(86, 23, 'Vacaciones', 'vacaciones', '', 0, 0, 1),
(87, 23, 'Editar Periodo', 'editar', '', 0, 0, 1),
(88, 23, 'Pendientes de Aprobación', 'aprobar', '', 0, 0, 1),
(89, 23, 'Ver Periodo', 'ver_periodo', '', 0, 0, 1),
(90, 23, 'Aprobar Asistencias', 'aprobar_asistencias', '', 0, 0, 1),
(91, 23, 'Renovar Periodo', 'renovar_periodo', '', 0, 0, 1),
(92, 23, 'guardar', 'guardar_departamento', '', 0, 0, 0),
(93, 10, 'Compra Rapida', 'facturas_sin_oc', '', 1, 7, 1),
(94, 23, 'Asignar Turnos', 'asignar_turnos', '', 0, 0, 1),
(95, 10, 'Ver Facturas', 'ver_facturas', '', 1, 8, 1),
(96, 12, 'Historial Pedido', 'historial_pedidos', '', 1, 2, 1),
(97, 12, 'Detalle Pedido Ver', 'detalle_pedido_ver', '', 0, 0, 1),
(98, 20, 'Tiempo de Atención por Pedido', 'tiempo_promedio_atencion', '', 0, 7, 1),
(99, 20, 'Ventas por Tipo de Pago', 'ventas_tipo_pago', '', 0, 8, 1),
(100, 20, 'Reporte Ventas por Productos', 'reporte_ventas_productos', '', 1, 0, 1),
(101, 23, 'Gestionar Turnos', 'gestionar_turnos', '', 0, 0, 1),
(102, 20, 'Reporte Ventas Productos PDF', 'reporte_ventas_productos_pdf', '', 0, 0, 1),
(103, 16, 'Historial Notas Ventas', 'historial_notas_ventas', '', 1, 1, 1),
(104, 16, 'tabla_productos_editar', 'tabla_productos_editar', '', 0, 0, 1),
(105, 16, 'editar_nota_venta', 'editar_nota_venta', '', 0, 0, 1),
(106, 20, 'Reporte General', 'reporte_general', '', 1, 0, 1),
(107, 20, 'Reporte General PDF', 'reporte_general_pdf', '', 0, 0, 1),
(108, 20, 'Reporte por Caja', 'reporte_por_caja', '', 0, 0, 1),
(109, 14, 'Gestionar Recursos', 'recursos', '', 1, 2, 1),
(110, 14, 'Gestionar Categorias', 'categorias', '', 1, 3, 1),
(111, 12, 'Historial Pedidos Gratis', 'historial_pedidos_gratis', '', 1, 2, 1),
(112, 12, 'Pedidos Eliminados', 'pedidos_eliminados', '', 1, 6, 1),
(113, 24, 'ws libres', 'ws', '', 1, 0, 1),
(114, 19, 'Adelanto de Personal', 'gastos_personal', '', 1, 2, 1),
(115, 16, 'Enviar Venta Correo', 'enviar_venta_correo', '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id_orden_compra` int(11) NOT NULL,
  `id_caja_numero` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_aprobacion` int(11) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_tipo_pago` int(11) DEFAULT NULL,
  `orden_compra_observacion` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_aprob` datetime DEFAULT NULL,
  `orden_compra_titulo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `orden_compra_activo` int(11) DEFAULT NULL,
  `orden_compra_numero` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `orden_compra_estado` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `orden_compra_fecha` datetime NOT NULL,
  `orden_compra_tipo_doc` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_compra_numero_doc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_compra_doc_adjuntado` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_emision_doc` date DEFAULT NULL,
  `orden_compra_doc_cuotas` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `orden_compra_fecha_recibida` datetime DEFAULT NULL,
  `orden_compra_usuario_recibido` int(11) NOT NULL,
  `orden_compra_codigo` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_gratis`
--

CREATE TABLE `pedidos_gratis` (
  `id_pedido_gratis` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `pedido_gratis_numero` varchar(200) DEFAULT NULL,
  `pedido_gratis_nombre` varchar(20) DEFAULT NULL,
  `pedido_gratis_direccion` varchar(500) DEFAULT NULL,
  `pedido_gratis_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pedido_gratis_datetime` datetime DEFAULT NULL,
  `pedido_gratis_codigo` varchar(100) DEFAULT NULL,
  `pedido_gratis_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_gratis_detalles`
--

CREATE TABLE `pedidos_gratis_detalles` (
  `id_pedido_gratis_detalle` int(11) NOT NULL,
  `id_pedido_gratis` int(11) NOT NULL,
  `id_comanda_detalle` int(11) NOT NULL,
  `id_pedido_gratis_detalle_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodo_laboral`
--

CREATE TABLE `periodo_laboral` (
  `id_periodo` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_sede` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `periodo_fechainicio` date NOT NULL,
  `periodo_fechafin` date NOT NULL,
  `periodo_fechafirma` date DEFAULT NULL,
  `periodo_sueldo` decimal(11,2) NOT NULL,
  `periodo_movilidad` decimal(11,2) DEFAULT NULL,
  `periodo_total` decimal(11,2) NOT NULL,
  `periodo_observa` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_estado` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `periodo_contrato` tinyint(1) DEFAULT NULL,
  `periodo_nro_contrato` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_user_creacion` int(11) DEFAULT NULL,
  `id_user_aprobacion` int(11) DEFAULT NULL,
  `periodo_fecha_creacion` date DEFAULT NULL,
  `periodo_hora_creacion` time DEFAULT NULL,
  `periodo_bono` float(10,2) DEFAULT NULL,
  `perioido_ruc_centro_estudio` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_nombre_centro_estudio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_domicilio_centro_estudio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_dni_representante` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_nombre_representante` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_ciclo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_especialidad` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `permiso_accion` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `permiso_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_opcion`, `permiso_accion`, `permiso_estado`) VALUES
(1, 1, 'validar_sesion', 1),
(2, 4, 'guardar_menu', 1),
(3, 6, 'configurar_relacion', 1),
(4, 7, 'guardar_opcion', 1),
(5, 7, 'agregar_permiso', 1),
(6, 7, 'eliminar_permiso', 1),
(7, 7, 'configurar_acceso', 1),
(8, 9, 'guardar_rol', 1),
(9, 10, 'gestionar_acceso_rol', 1),
(10, 12, 'guardar_nuevo_usuario', 1),
(11, 12, 'guardar_edicion_usuario', 1),
(12, 12, 'guardar_edicion_persona', 1),
(13, 12, 'restablecer_contrasenha', 1),
(14, 13, 'guardar_datos', 1),
(15, 14, 'guardar_usuario', 1),
(16, 15, 'guardar_contrasenha', 1),
(17, 16, 'guardar_negocio', 1),
(18, 16, 'editar_negocio', 1),
(19, 17, 'guardar_sucursal', 1),
(20, 17, 'editar_sucursal', 1),
(21, 18, 'guardar_usuario_sucursal', 1),
(22, 19, 'guardar_usuario_negocio', 1),
(23, 16, 'cambiar_estado_negocio', 1),
(24, 17, 'cambiar_estado_sucursal', 1),
(25, 19, 'cambiar_estado_usuario_negocio', 1),
(27, 18, 'cambiar_estado_usuariosucursal', 1),
(28, 20, 'guardar_categoria', 1),
(29, 21, 'guardar_recursos', 1),
(30, 21, 'listar_categoria_por_id', 1),
(31, 22, 'guardar_nuevo_proveedor', 1),
(32, 22, 'guardar_edicion_proveedor', 1),
(33, 22, 'eliminar_proveedor', 1),
(34, 23, 'listar_recursos_x_sucursal', 1),
(35, 23, 'guardar_orden', 1),
(36, 27, 'editar_orden', 1),
(37, 26, 'aprobar_orden', 1),
(38, 24, 'eliminar_orden', 1),
(39, 21, 'cambiar_estado_recurso', 1),
(40, 20, 'cambiar_estado_categoria', 1),
(41, 28, 'actualizar_recepcion', 1),
(42, 29, 'guardar_producto', 1),
(43, 29, 'editar_producto', 1),
(44, 29, 'listar_precios', 1),
(45, 29, 'agregar_nuevo_precio', 1),
(46, 29, 'cambiar_estado_producto', 1),
(47, 31, 'guardar_nuevo_mesa', 1),
(48, 31, 'guardar_edicion_mesa', 1),
(49, 31, 'eliminar_mesa', 1),
(50, 31, 'listar_negocio_por_id', 1),
(51, 32, 'guardar_nuevo_almacen', 1),
(52, 32, 'guardar_edicion_almacen', 1),
(53, 32, 'eliminar_almacen', 1),
(54, 32, 'listar_negocio_por_id', 1),
(55, 30, 'listar_precio_producto', 1),
(56, 33, 'guardar_comanda', 1),
(57, 35, 'cambiar_estado_pedido', 1),
(58, 33, 'ver_productos', 1),
(60, 37, 'guardar_edicion_receta', 1),
(61, 37, 'eliminar_receta', 1),
(62, 38, 'guardar_nuevo_detalle_receta', 1),
(63, 38, 'guardar_edicion_detalle_receta', 1),
(64, 38, 'eliminar_detalle_receta', 1),
(65, 37, 'guardar_nuevo_receta', 1),
(67, 41, 'guardar_cliente', 1),
(68, 41, 'guardar_edicion_cliente', 1),
(69, 41, 'eliminar_cliente', 1),
(70, 40, 'guardar_venta', 1),
(71, 38, 'listar_unidad_precio', 1),
(72, 21, 'jalar_categorias', 1),
(73, 40, 'ver_productos_nuevo', 1),
(74, 40, 'guardar_comanda_nuevo', 1),
(75, 40, 'eliminar_comanda_detalle', 1),
(76, 40, 'cambiar_mesa', 1),
(77, 40, 'buscar_cliente', 1),
(78, 31, 'listar_negocio_por_id_editar', 1),
(79, 40, 'cambiar_cantidad_personas', 1),
(80, 42, 'jalar_recursos', 1),
(81, 42, 'guardar_nueva_conversion', 1),
(82, 38, 'jalar_valor_preparacion', 1),
(83, 38, 'guardar_sub_receta', 1),
(84, 43, 'guardar_egresos', 1),
(85, 43, 'eliminar_egreso', 1),
(86, 43, 'editar_egresos', 1),
(87, 45, 'guardar_insumos', 1),
(88, 45, 'editar_insumos', 1),
(89, 30, 'consultar_serie', 1),
(90, 46, 'guardar_delivery', 1),
(91, 39, 'crear_xml_enviar_sunat', 1),
(92, 53, 'crear_enviar_resumen_sunat', 1),
(93, 40, 'ticket_venta', 1),
(94, 40, 'ticket_pedido', 1),
(95, 34, 'agregar_grupo', 1),
(96, 46, 'buscar_cliente_delivery', 1),
(97, 61, 'buscar_cliente_delivery_pagos', 1),
(98, 52, 'comunicacion_baja', 1),
(99, 39, 'anular_boleta_cambiarestado', 1),
(100, 41, 'guardar_cliente_nuevo', 1),
(101, 48, 'eliminar_comanda_delivery', 1),
(102, 65, 'tipo_nota_descripcion', 1),
(103, 65, 'consultar_serie', 1),
(104, 65, 'guardar_nota', 1),
(105, 52, 'consultar_comprobante', 1),
(106, 41, 'obtener_datos_x_dni', 1),
(107, 41, 'obtener_datos_x_ruc', 1),
(108, 66, 'guardar_categoria', 1),
(109, 66, 'editar_categoria', 1),
(110, 66, 'eliminar_categoria', 1),
(111, 21, 'editar_stock_minimo', 1),
(112, 22, 'obtener_datos_x_dni', 1),
(113, 22, 'obtener_datos_x_ruc', 1),
(114, 42, 'eliminar_conversion', 1),
(115, 38, 'eliminar_sub_receta', 1),
(116, 71, 'guardar_memo', 1),
(117, 73, 'editar_memo', 1),
(118, 73, 'aprobar_memo', 1),
(120, 73, 'eliminar_memo', 1),
(121, 70, 'guardar_personal', 1),
(122, 70, 'eliminar_personal', 1),
(123, 77, 'guardar_periodo', 1),
(124, 78, 'guardar_archivo', 1),
(125, 78, 'eliminar_documento', 1),
(126, 79, 'eliminar_feriado', 1),
(127, 79, 'agregar_feriado', 1),
(128, 80, 'guardar_asistencia_proyectada', 1),
(129, 80, 'registrar_asistencia_proyectad', 1),
(130, 76, 'aprobar_periodo', 1),
(131, 84, 'aprobar_asistencia', 1),
(132, 84, 'guardar_asistencia', 1),
(133, 84, 'registrar_asistencia', 1),
(134, 89, 'generar_contrato', 1),
(135, 76, 'eliminar_periodo', 1),
(137, 12, 'guardar_departamento', 1),
(138, 12, 'eliminar_departamento', 1),
(139, 12, 'eliminar_cargo', 1),
(140, 12, 'guardar_cargo', 1),
(141, 94, 'guardar_turno', 1),
(142, 90, 'guardar_horas', 1),
(143, 93, 'guardar_compra_rapida', 1),
(144, 2, 'guardar_apertura_caja', 1),
(145, 29, 'consultar_datos', 1),
(146, 101, 'agregar_turnos', 1),
(147, 101, 'agregar_turnos_editado', 1),
(148, 84, 'registrar_salida', 1),
(149, 30, 'habilitar_mesa', 1),
(150, 105, 'addproduct', 1),
(151, 105, 'eliminar_producto', 1),
(152, 105, 'search_by_barcode', 1),
(153, 105, 'consultar_serie', 1),
(154, 105, 'tipo_nota_descripcion', 1),
(155, 105, 'ticket_electronico', 1),
(156, 105, 'editar_cantidad_tabla', 1),
(157, 105, 'guardar_venta_market', 1),
(158, 40, 'cambiar_comanda_detalle_cantid', 1),
(159, 30, 'guardar_reserva', 1),
(160, 30, 'habilitar_reserva', 1),
(161, 30, 'eliminar_reserva', 1),
(162, 2, 'guardar_cierre_caja', 1),
(163, 29, 'guardar_familia', 1),
(164, 32, 'guardar_salida', 1),
(165, 29, 'eliminar_familia', 1),
(166, 95, 'eliminar_orden_cr', 1),
(167, 109, 'guardar_recursos', 1),
(168, 109, 'listar_categoria_por_id', 1),
(169, 109, 'cambiar_estado_recurso', 1),
(170, 109, 'jalar_categorias', 1),
(171, 109, 'editar_stock_minimo', 1),
(172, 110, 'guardar_categoria', 1),
(173, 110, 'cambiar_estado_categoria', 1),
(174, 93, 'recargar_recursos', 1),
(175, 55, 'consultar_ticket_resumen', 1),
(176, 40, 'ticket_comanda', 1),
(177, 41, 'guardar_puntos', 1),
(178, 113, 'guardar_comanda', 1),
(179, 113, 'guardar_comanda_nuevo', 1),
(180, 113, 'guardar_delivery', 1),
(181, 113, 'guardar_venta', 1),
(182, 113, 'ticket_pedido', 1),
(183, 113, 'ticket_comanda', 1),
(184, 113, 'ticket_venta', 1),
(185, 113, 'ticket_venta_delivery', 1),
(186, 46, 'guardar_delivery_venta', 1),
(187, 46, 'ver_productos_x_delivery', 1),
(188, 62, 'cambiar_estado_comanda_deliver', 1),
(189, 30, 'guardar_cambio', 1),
(190, 30, 'mesa_visible', 1),
(191, 106, 'ticket_reporte', 1),
(192, 1, 'validar_sesion_app', 1),
(193, 31, 'listar_mesas', 1),
(194, 33, 'listar_familias_productos', 1),
(195, 106, 'ticket_productos', 1),
(196, 40, 'transferir_pedido', 1),
(197, 114, 'guardar_gasto_personal', 1),
(198, 114, 'guardar_personal', 1),
(199, 114, 'guardar_gasto_personal_editado', 1),
(200, 114, 'eliminar_gasto_personal', 1),
(201, 39, 'enviar_venta_correo', 1),
(202, 52, 'enviar_venta_correo', 1),
(203, 29, 'sumar_stock_nuevo', 1),
(204, 39, 'cambiarestado_enviado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `persona_nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `persona_apellido_paterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `persona_apellido_materno` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_tipo_documento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_dni` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `persona_nacionalidad` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_estado_civil` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_direccion` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_discapacidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_job` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_nacimiento` date DEFAULT NULL,
  `persona_sexo` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_telefono` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_telefono_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_foto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_hijos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_departamento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_provincia` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_distrito` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_adicional` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_afp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_cuspp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_afiliac` date DEFAULT NULL,
  `persona_blacklist` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_bank` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_number_account` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_bank_alt` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `persona_number_account_alt` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_bank_cts` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_account_cts` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_cv` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_empleado` tinyint(1) DEFAULT NULL,
  `persona_creacion` datetime NOT NULL,
  `persona_modificacion` datetime NOT NULL,
  `person_codigo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `persona_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `id_empresa`, `persona_nombre`, `persona_apellido_paterno`, `persona_apellido_materno`, `persona_email`, `persona_tipo_documento`, `persona_dni`, `persona_nacionalidad`, `persona_estado_civil`, `persona_direccion`, `persona_discapacidad`, `persona_job`, `persona_nacimiento`, `persona_sexo`, `persona_telefono`, `persona_telefono_2`, `persona_foto`, `persona_hijos`, `persona_departamento`, `persona_provincia`, `persona_distrito`, `persona_adicional`, `persona_afp`, `persona_cuspp`, `persona_afiliac`, `persona_blacklist`, `persona_bank`, `persona_number_account`, `persona_bank_alt`, `persona_number_account_alt`, `persona_bank_cts`, `persona_account_cts`, `persona_cv`, `persona_empleado`, `persona_creacion`, `persona_modificacion`, `person_codigo`, `persona_estado`) VALUES
(1, 1, 'César José', 'Ruiz', 'Reategui', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '', '', NULL, 0, '2020-09-17 00:00:00', '2020-09-17 00:00:00', '010101010101', 1),
(2, 1, 'SIMPSON', 'Admin', 'Restobar', NULL, NULL, '99999999', NULL, NULL, NULL, NULL, NULL, '1996-06-14', NULL, '965874123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '', '', NULL, 1, '2020-10-27 18:29:10', '2020-10-27 18:29:10', '1603841350.1786', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_turno`
--

CREATE TABLE `persona_turno` (
  `id_persona_turno` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_turno` int(11) NOT NULL,
  `persona_turno_fecha_registro` datetime NOT NULL,
  `persona_estado_turno` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto_familia` int(11) NOT NULL,
  `producto_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `producto_descripcion` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `producto_foto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `producto_estado` tinyint(1) NOT NULL,
  `producto_fecha_registro` datetime NOT NULL,
  `producto_codigo` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_receta`, `id_grupo`, `id_usuario`, `id_producto_familia`, `producto_nombre`, `producto_descripcion`, `producto_foto`, `producto_estado`, `producto_fecha_registro`, `producto_codigo`) VALUES
(1, 1, 1, 2, 27, 'Cerveza Cristal 337', '', 'media/producto/default.png', 1, '2022-03-02 13:23:38', '1646245418.8761'),
(2, 1, 2, 1, 1, 'LECHE SIMPLE', '', 'media/producto/default.png', 1, '2022-03-04 19:49:06', '1646441346.0513'),
(3, 2, 2, 1, 1, 'LECHE NATURAL', '', 'media/producto/default.png', 1, '2022-03-04 19:49:25', '1646441365.8884'),
(4, 3, 2, 1, 1, 'LECHE MIXTA', '', 'media/producto/default.png', 1, '2022-03-04 19:49:40', '1646441380.2888'),
(5, 4, 2, 1, 1, 'LECHE SIMPSON', '', 'media/producto/default.png', 1, '2022-03-04 19:49:51', '1646441391.72'),
(6, 5, 2, 1, 2, 'CEVICHE SIMPLE', '', 'media/producto/default.png', 1, '2022-03-04 19:50:16', '1646441416.7493'),
(7, 6, 2, 1, 2, 'CEVICHE NATURAL', '', 'media/producto/default.png', 1, '2022-03-04 19:50:31', '1646441431.7758'),
(8, 7, 2, 1, 2, 'CEVICHE MIXTO', '', 'media/producto/default.png', 1, '2022-03-04 19:51:22', '1646441482.8051'),
(9, 8, 2, 1, 2, 'CEVICHE  DE MARISCO', '', 'media/producto/default.png', 1, '2022-03-04 19:51:39', '1646441499.112'),
(10, 9, 2, 1, 3, 'CEVICHE  + CHICHARRON', '', 'media/producto/default.png', 1, '2022-03-04 19:52:07', '1646441527.1559'),
(11, 10, 2, 1, 3, 'CEVICHE  + CHAUFA CON MARISCO', '', 'media/producto/default.png', 1, '2022-03-04 19:52:32', '1646441552.8886'),
(12, 11, 2, 1, 3, 'CEVICHE  + CHICHARRON + CHAUFA CON MARISCO', '', 'media/producto/default.png', 1, '2022-03-04 19:52:50', '1646441570.4004'),
(13, 12, 2, 1, 4, 'CHICHARRON DE POLLO', '', 'media/producto/default.png', 1, '2022-03-04 19:53:18', '1646441598.2824'),
(14, 13, 2, 1, 4, 'CHICHARRON DE PESCADO', '', 'media/producto/default.png', 1, '2022-03-04 19:53:33', '1646441613.7823'),
(15, 14, 2, 1, 4, 'CHICHARRON  DE LANGOSTINO', '', 'media/producto/default.png', 1, '2022-03-04 19:53:54', '1646441634.8728'),
(16, 15, 2, 1, 5, 'CHAUFA DE MARISCO', '', 'media/producto/default.png', 1, '2022-03-04 19:54:18', '1646441658.1863'),
(17, 16, 2, 1, 5, 'CHAUFA ESPECIAL', '', 'media/producto/default.png', 1, '2022-03-04 19:54:35', '1646441675.4306'),
(18, 17, 2, 1, 5, 'CHAUFA REGIONAL', '', 'media/producto/default.png', 1, '2022-03-04 19:54:54', '1646441694.9228'),
(19, 18, 2, 1, 6, 'CECINA CON TACACHO', '', 'media/producto/default.png', 1, '2022-03-04 19:55:14', '1646441714.5222'),
(20, 19, 2, 1, 6, 'CHORISO CON TACACHO', '', 'media/producto/default.png', 1, '2022-03-04 19:55:28', '1646441728.7664'),
(21, 20, 2, 1, 7, 'POLLO A LO POBRE', '', 'media/producto/default.png', 1, '2022-03-04 19:55:47', '1646441747.7727'),
(22, 21, 2, 1, 7, 'POLLO A LA PLANCHA', '', 'media/producto/default.png', 1, '2022-03-04 19:56:04', '1646441764.2536'),
(23, 22, 2, 1, 7, 'POLLO BROASTER', '', 'media/producto/default.png', 1, '2022-03-04 19:56:35', '1646441795.1666'),
(24, 23, 2, 1, 8, 'FUENTE REGIONAL', '', 'media/producto/default.png', 1, '2022-03-04 19:56:54', '1646441814.4918'),
(25, 24, 2, 1, 8, 'FUENTE CEVICHE', '', 'media/producto/default.png', 1, '2022-03-04 19:57:12', '1646441832.6416'),
(26, 25, 2, 1, 8, 'FUENTE DE CHICHARRON', '', 'media/producto/default.png', 1, '2022-03-04 19:57:51', '1646441871.4281'),
(27, 26, 2, 1, 8, 'FUENTE DE CEVICHE MIXTO', '', 'media/producto/default.png', 1, '2022-03-04 19:58:08', '1646441888.7726'),
(28, 27, 2, 1, 9, 'CERVEZA CRISTAL', '', 'media/producto/default.png', 1, '2022-03-04 20:01:27', '1646442087.5986'),
(29, 28, 2, 1, 9, 'CERVEZA PILSEN', '', 'media/producto/default.png', 1, '2022-03-04 20:01:41', '1646442101.3074'),
(30, 29, 2, 1, 9, 'CERVEZA CUSQUEÑA', '', 'media/producto/default.png', 1, '2022-03-04 20:01:55', '1646442115.8821'),
(31, 30, 2, 1, 9, 'BUDWEISER', '', 'media/producto/default.png', 1, '2022-03-04 20:02:23', '1646442143.1862'),
(32, 31, 2, 1, 9, 'CORONA', '', 'media/producto/default.png', 1, '2022-03-04 20:02:36', '1646442156.7619'),
(33, 32, 2, 1, 9, 'BECKS', '', 'media/producto/default.png', 1, '2022-03-04 20:02:53', '1646442173.6232'),
(34, 33, 2, 1, 9, 'STELLA ARTOIS', '', 'media/producto/default.png', 1, '2022-03-04 20:03:08', '1646442188.8408'),
(35, 34, 4, 1, 9, 'CERVEZA GOLDEN', '', 'media/producto/default.png', 1, '2022-03-04 20:13:43', '1646442823.3222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_familia`
--

CREATE TABLE `producto_familia` (
  `id_producto_familia` int(11) NOT NULL,
  `producto_familia_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `producto_familia_fecha_registro` datetime NOT NULL,
  `producto_familia_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto_familia`
--

INSERT INTO `producto_familia` (`id_producto_familia`, `producto_familia_nombre`, `producto_familia_fecha_registro`, `producto_familia_estado`) VALUES
(1, 'LECHE DE TIGRE', '2022-03-04 19:47:14', 1),
(2, 'CEVICHES', '2022-03-04 19:47:21', 1),
(3, 'DUOS Y TRIOS', '2022-03-04 19:47:30', 1),
(4, 'CHICHARRONES', '2022-03-04 19:47:37', 1),
(5, 'CHAUFAS', '2022-03-04 19:47:45', 1),
(6, 'PLATO REGIONAL', '2022-03-04 19:47:52', 1),
(7, 'PLATOS A LA CARTA', '2022-03-04 19:48:13', 1),
(8, 'FUENTES', '2022-03-04 19:48:20', 1),
(9, 'BEBIDAS', '2022-03-04 19:48:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_precio`
--

CREATE TABLE `producto_precio` (
  `id_producto_precio` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_unidad_medida` int(11) NOT NULL,
  `producto_precio_codigoafectacion` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '20',
  `producto_precio_venta` decimal(10,2) NOT NULL,
  `producto_precio_fecha_registro` datetime NOT NULL,
  `producto_precio_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto_precio`
--

INSERT INTO `producto_precio` (`id_producto_precio`, `id_producto`, `id_unidad_medida`, `producto_precio_codigoafectacion`, `producto_precio_venta`, `producto_precio_fecha_registro`, `producto_precio_estado`) VALUES
(1, 1, 58, '20', '7.00', '2022-03-02 13:23:38', 1),
(2, 2, 59, '20', '12.00', '2022-03-04 19:49:06', 1),
(3, 3, 59, '20', '15.00', '2022-03-04 19:49:25', 1),
(4, 4, 59, '20', '18.00', '2022-03-04 19:49:40', 1),
(5, 5, 59, '20', '20.00', '2022-03-04 19:49:51', 1),
(6, 6, 59, '20', '25.00', '2022-03-04 19:50:16', 1),
(7, 7, 59, '20', '28.00', '2022-03-04 19:50:31', 1),
(8, 8, 59, '20', '32.00', '2022-03-04 19:51:22', 1),
(9, 9, 59, '20', '35.00', '2022-03-04 19:51:39', 1),
(10, 10, 59, '20', '35.00', '2022-03-04 19:52:07', 1),
(11, 11, 59, '20', '35.00', '2022-03-04 19:52:32', 1),
(12, 12, 59, '20', '40.00', '2022-03-04 19:52:50', 1),
(13, 13, 59, '20', '30.00', '2022-03-04 19:53:18', 1),
(14, 14, 59, '20', '35.00', '2022-03-04 19:53:33', 1),
(15, 15, 59, '20', '45.00', '2022-03-04 19:53:54', 1),
(16, 16, 59, '20', '30.00', '2022-03-04 19:54:18', 1),
(17, 17, 59, '20', '45.00', '2022-03-04 19:54:35', 1),
(18, 18, 59, '20', '45.00', '2022-03-04 19:54:54', 1),
(19, 19, 59, '20', '35.00', '2022-03-04 19:55:14', 1),
(20, 20, 59, '20', '35.00', '2022-03-04 19:55:28', 1),
(21, 21, 59, '20', '30.00', '2022-03-04 19:55:47', 1),
(22, 22, 59, '20', '30.00', '2022-03-04 19:56:04', 1),
(23, 23, 59, '20', '25.00', '2022-03-04 19:56:35', 1),
(24, 24, 59, '20', '90.00', '2022-03-04 19:56:54', 1),
(25, 25, 59, '20', '80.00', '2022-03-04 19:57:12', 1),
(26, 26, 59, '20', '90.00', '2022-03-04 19:57:51', 1),
(27, 27, 59, '20', '120.00', '2022-03-04 19:58:08', 1),
(28, 28, 59, '20', '8.00', '2022-03-04 20:01:27', 1),
(29, 29, 59, '20', '9.00', '2022-03-04 20:01:41', 1),
(30, 30, 59, '20', '10.00', '2022-03-04 20:01:55', 1),
(31, 31, 59, '20', '8.00', '2022-03-04 20:02:23', 1),
(32, 32, 59, '20', '10.00', '2022-03-04 20:02:36', 1),
(33, 33, 59, '20', '10.00', '2022-03-04 20:02:53', 1),
(34, 34, 59, '20', '12.00', '2022-03-04 20:03:08', 1),
(35, 35, 59, '20', '6.00', '2022-03-04 20:13:43', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `id_tipodocumento` int(11) NOT NULL,
  `proveedor_nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor_ruc` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor_direccion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor_nombre_contacto` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedor_cargo_persona` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proveedor_numero` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proveedor_estado` int(4) NOT NULL,
  `proveedor_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE `puntos` (
  `id_puntos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `puntos_cantidad` decimal(10,2) NOT NULL,
  `puntos_cantidad_soles` decimal(10,2) NOT NULL,
  `puntos_fecha_registro` datetime NOT NULL,
  `puntos_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_cliente`
--

CREATE TABLE `puntos_cliente` (
  `id_punto_cliente` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_puntos` int(11) NOT NULL,
  `puntos_cliente_acumulado` decimal(10,2) NOT NULL,
  `puntos_cliente_fecha_registro` datetime NOT NULL,
  `puntos_cliente_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id_receta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `receta_nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receta_fecha` datetime NOT NULL,
  `receta_estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id_receta`, `id_usuario`, `receta_nombre`, `receta_fecha`, `receta_estado`) VALUES
(1, 1, 'LECHE SIMPLE', '2022-03-04 19:37:11', 1),
(2, 1, 'LECHE NATURAL', '2022-03-04 19:37:30', 1),
(3, 1, 'LECHE MIXTA', '2022-03-04 19:37:40', 1),
(4, 1, 'LECHE SIMPSON', '2022-03-04 19:37:49', 1),
(5, 1, 'CEVICHE SIMPLE', '2022-03-04 19:38:02', 1),
(6, 1, 'CEVICHE NATURAL', '2022-03-04 19:38:17', 1),
(7, 1, 'CEVICHE MIXTO', '2022-03-04 19:38:26', 1),
(8, 1, 'CEVICHE  DE MARISCO', '2022-03-04 19:38:42', 1),
(9, 1, 'CEVICHE  + CHICHARRON', '2022-03-04 19:39:10', 1),
(10, 1, 'CEVICHE  + CHAUFA CON MARISCO', '2022-03-04 19:39:42', 1),
(11, 1, 'CEVICHE  + CHICHARRON + CHAUFA CON MARISCO', '2022-03-04 19:40:03', 1),
(12, 1, 'CHICHARRON DE POLLO', '2022-03-04 19:40:21', 1),
(13, 1, 'CHICHARRON DE PESCADO', '2022-03-04 19:40:39', 1),
(14, 1, 'CHICHARRON  DE LANGOSTINO', '2022-03-04 19:40:52', 1),
(15, 1, 'CHAUFA DE MARISCO', '2022-03-04 19:41:03', 1),
(16, 1, 'CHAUFA ESPECIAL', '2022-03-04 19:41:15', 1),
(17, 1, 'CHAUFA REGIONAL', '2022-03-04 19:41:26', 1),
(18, 1, 'CECINA CON TACACHO', '2022-03-04 19:41:38', 1),
(19, 1, 'CHORISO CON TACACHO', '2022-03-04 19:41:59', 1),
(20, 1, 'POLLO A LO POBRE', '2022-03-04 19:42:17', 1),
(21, 1, 'POLLO A LA PLANCHA', '2022-03-04 19:42:34', 1),
(22, 1, 'POLLO BROASTER', '2022-03-04 19:42:46', 1),
(23, 1, 'FUENTE REGIONAL', '2022-03-04 19:43:04', 1),
(24, 1, 'FUENTE CEVICHE', '2022-03-04 19:43:15', 1),
(25, 1, 'FUENTE DE CHICHARRON', '2022-03-04 19:43:28', 1),
(26, 1, 'FUENTE DE CEVICHE MIXTO', '2022-03-04 19:43:48', 1),
(27, 1, 'CERVEZA CRISTAL', '2022-03-04 19:44:11', 1),
(28, 1, 'CERVEZA PILSEN', '2022-03-04 19:44:23', 1),
(29, 1, 'CERVEZA CUSQUEÑA', '2022-03-04 19:44:31', 1),
(30, 1, 'BUDWEISER', '2022-03-04 19:44:45', 1),
(31, 1, 'CORONA', '2022-03-04 19:44:52', 1),
(32, 1, 'BECKS', '2022-03-04 19:45:04', 1),
(33, 1, 'STELLA ARTOIS', '2022-03-04 19:45:24', 1),
(34, 1, 'CERVEZA GOLDEN', '2022-03-04 19:45:38', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id_recurso` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `recurso_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `recurso_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id_recurso`, `id_categoria`, `recurso_nombre`, `recurso_estado`) VALUES
(4, 15, 'CERVEZA CRISTAL', 1),
(5, 15, 'CERVEZA PILSEN', 1),
(6, 15, 'CERVEZA CUZQUEÑA', 1),
(7, 15, 'BUDWEISER', 1),
(8, 15, 'CORONA', 1),
(9, 15, 'BECKS', 1),
(10, 15, 'STELLA ARTOIS', 1),
(11, 15, 'CERVEZA GOLDEN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos_sede`
--

CREATE TABLE `recursos_sede` (
  `id_recurso_sede` int(11) NOT NULL,
  `id_usuario_creacion` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `recurso_sede_factor_unidad` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_cantidad` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_precio_unit` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_precio_total` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_peso_inicial` decimal(10,2) DEFAULT NULL,
  `recurso_sede_peso_final` decimal(10,2) DEFAULT NULL,
  `recurso_sede_merma` decimal(10,2) DEFAULT NULL,
  `recurso_sede_precio` decimal(10,2) NOT NULL,
  `recurso_sede_stock` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_stock_minimo` decimal(10,2) DEFAULT '0.00',
  `recurso_sede_estado` tinyint(1) NOT NULL,
  `recurso_sede_fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recursos_sede`
--

INSERT INTO `recursos_sede` (`id_recurso_sede`, `id_usuario_creacion`, `id_sucursal`, `id_recurso`, `id_medida`, `recurso_sede_factor_unidad`, `recurso_sede_cantidad`, `recurso_sede_precio_unit`, `recurso_sede_precio_total`, `recurso_sede_peso_inicial`, `recurso_sede_peso_final`, `recurso_sede_merma`, `recurso_sede_precio`, `recurso_sede_stock`, `recurso_sede_stock_minimo`, `recurso_sede_estado`, `recurso_sede_fecha`) VALUES
(2, 1, 4, 4, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(3, 1, 4, 5, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(4, 1, 4, 6, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(5, 1, 4, 7, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(6, 1, 4, 8, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(7, 1, 4, 9, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(8, 1, 4, 10, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23'),
(9, 1, 4, 11, 59, '0.00', '0.00', '0.00', '0.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', 1, '2022-03-05 00:57:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_asistencias`
--

CREATE TABLE `registro_asistencias` (
  `id_registro` int(11) NOT NULL,
  `id_persona_turno` int(11) NOT NULL,
  `asistencia_fecha` date NOT NULL,
  `asistencia_valor` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `asistencia_cambio_fecha` date NOT NULL,
  `asistencia_cambio_hora` time NOT NULL,
  `asistencia_comentarios` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `reserva_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `reserva_cantidad` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reserva_fecha` date NOT NULL,
  `reserva_hora` time NOT NULL,
  `reserva_contacto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reserva_fecha_registro` datetime NOT NULL,
  `reserva_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones`
--

CREATE TABLE `restricciones` (
  `id_restriccion` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `restricciones`
--

INSERT INTO `restricciones` (`id_restriccion`, `id_rol`, `id_opcion`) VALUES
(1, 5, 80),
(2, 6, 80),
(3, 4, 80),
(4, 4, 70),
(6, 6, 70),
(7, 4, 67),
(9, 6, 67),
(10, 4, 71),
(11, 5, 71),
(12, 6, 71),
(13, 4, 46),
(14, 4, 111),
(15, 4, 48);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol_nombre` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `rol_descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rol_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol_nombre`, `rol_descripcion`, `rol_estado`) VALUES
(1, 'Libre', 'Accesos sin inicio de sesión', 1),
(2, 'SuperAdmin', 'Tiene acceso a la gestión total del sistema', 1),
(3, 'Admin', 'Gestión del sistema', 1),
(4, 'Mesero', 'Atencion al publico', 1),
(5, 'Cajero', 'Encargado de estar en caja', 1),
(6, 'Cocinero', 'Encargado de la preparación del pedido', 1),
(7, 'Supervisor', 'Supervisar todo el negocio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_menus`
--

CREATE TABLE `roles_menus` (
  `id_rol_menu` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles_menus`
--

INSERT INTO `roles_menus` (`id_rol_menu`, `id_rol`, `id_menu`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 3, 2),
(7, 3, 5),
(8, 2, 6),
(9, 3, 6),
(10, 2, 7),
(11, 2, 8),
(12, 2, 9),
(13, 2, 10),
(14, 2, 11),
(15, 2, 12),
(16, 2, 13),
(17, 2, 14),
(18, 2, 15),
(19, 2, 16),
(20, 2, 17),
(21, 2, 18),
(22, 2, 19),
(23, 2, 20),
(24, 2, 21),
(25, 4, 2),
(26, 4, 12),
(28, 4, 17),
(29, 5, 2),
(30, 5, 16),
(31, 5, 12),
(32, 2, 22),
(33, 3, 8),
(34, 3, 9),
(35, 3, 10),
(36, 3, 11),
(37, 3, 12),
(38, 3, 13),
(39, 3, 14),
(40, 3, 15),
(41, 3, 16),
(42, 3, 17),
(43, 3, 18),
(44, 3, 19),
(45, 3, 20),
(46, 3, 21),
(47, 3, 7),
(48, 4, 13),
(50, 5, 13),
(51, 5, 17),
(52, 5, 19),
(53, 5, 20),
(54, 6, 2),
(55, 6, 12),
(56, 6, 13),
(57, 3, 22),
(58, 2, 23),
(59, 3, 23),
(60, 7, 2),
(61, 7, 5),
(62, 7, 7),
(63, 7, 8),
(64, 7, 9),
(66, 7, 11),
(67, 7, 12),
(68, 7, 13),
(69, 7, 17),
(70, 7, 16),
(71, 7, 15),
(72, 7, 18),
(73, 7, 19),
(74, 7, 20),
(75, 7, 21),
(76, 7, 22),
(77, 4, 23),
(78, 1, 24),
(79, 2, 24),
(80, 3, 24),
(81, 4, 24),
(82, 5, 24),
(83, 6, 24),
(84, 7, 24),
(85, 5, 15),
(86, 5, 11),
(87, 5, 5),
(88, 5, 23),
(89, 5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie`
--

CREATE TABLE `serie` (
  `id_serie` int(11) NOT NULL,
  `id_caja_numero` int(11) DEFAULT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `serie` varchar(8) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

--
-- Volcado de datos para la tabla `serie`
--

INSERT INTO `serie` (`id_serie`, `id_caja_numero`, `tipocomp`, `serie`, `correlativo`, `estado`) VALUES
(1, 1, '01', 'F001', 0, 1),
(2, 2, '01', 'F002', 0, 1),
(3, 1, '03', 'B001', 0, 1),
(5, 1, '07', 'FN01', 0, 1),
(6, 1, '07', 'BN01', 0, 1),
(7, 1, '08', 'FD01', 0, 1),
(8, 1, '08', 'BD01', 0, 1),
(9, 1, 'RC', '20220124', 0, 1),
(10, 1, 'RA', '20210520', 0, 1),
(4, 2, '03', 'B002', 0, 1),
(13, 1, '20', 'NV01', 0, 1),
(14, 2, '20', 'NV02', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_recetas`
--

CREATE TABLE `sub_recetas` (
  `id_sub_receta` int(11) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_receta_2` int(11) NOT NULL,
  `sub_receta_cantidad` decimal(10,2) NOT NULL,
  `sub_receta_total` decimal(10,2) NOT NULL,
  `sub_receta_fecha_registro` datetime NOT NULL,
  `sub_receta_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `sucursal_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_direccion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_ruc` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_foto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sucursal_telefono` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sucursal_estado` tinyint(1) NOT NULL,
  `sucursal_fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `id_ciudad`, `id_negocio`, `sucursal_nombre`, `sucursal_direccion`, `sucursal_ruc`, `sucursal_foto`, `sucursal_telefono`, `sucursal_estado`, `sucursal_fecha_registro`) VALUES
(4, 1, 3, 'SIMPSON RESTOBAR', 'Av. Quiñones 4757', '20606798939', 'media/sucursal/default.png', '987100215', 0, '2021-03-24 14:23:50'),
(5, 1, 3, 'SIMPSON RESTOBAR', 'CAL.LOS ROSALES NRO. 219C', '20606798939', 'media/sucursal/default.png', '999999999', 1, '2021-09-30 09:38:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoadjuntos`
--

CREATE TABLE `tipoadjuntos` (
  `id_adjunto` int(11) NOT NULL,
  `adjunto_nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `adjunto_ext` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipoadjuntos`
--

INSERT INTO `tipoadjuntos` (`id_adjunto`, `adjunto_nombre`, `adjunto_ext`) VALUES
(1, 'Boleta de Pago', 'BolPago'),
(2, 'Contrato firmado', 'ContrFirma'),
(3, 'Alta de PDT', 'AltaPDT'),
(4, 'Baja de PDT', 'BajaPDT'),
(5, 'Memorandum - Vacaciones', 'MemoVacac'),
(6, 'Memorandum - Sanciones', 'MemoSanc'),
(7, 'Memorandum - Cambio de Puesto', 'MemoCambP'),
(8, 'Memorandum - Varios', 'MemoVar'),
(9, 'Antecedentes Penales', 'AntPen'),
(10, 'Antecedentes Policiales', 'AntPol'),
(11, 'Otros Documentos y/o Solicitudes', 'Otros'),
(12, 'Renuncia', 'Renun'),
(13, 'Liquidación de Beneficios Sociales', 'LBS'),
(14, 'Carta de No Adeudo', 'CartNAd'),
(15, 'Licencia por Maternidad y/o Paternidad', 'LicMatPat'),
(16, 'Declaración Jurada', 'DeclJur'),
(17, 'Boleta de Pago - Vacaciones', 'BolPagVac'),
(18, 'Examen Medico', 'ExamMed'),
(19, 'Vacunas', 'Vac'),
(20, 'Certificado de Trabajo', 'CerTrab'),
(21, 'Boleta - Gratificación', 'BolGrat');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocargo`
--

CREATE TABLE `tipocargo` (
  `id_cargo` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `cargo_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipocargo`
--

INSERT INTO `tipocargo` (`id_cargo`, `id_departamento`, `cargo_nombre`) VALUES
(1, 1, 'MESERO'),
(2, 2, 'PERSONAL LIMPIEZA'),
(3, 1, 'COCINERO'),
(4, 3, 'AUXILIAR CONTABLE'),
(5, 1, 'AYUDANTE'),
(6, 0, 'Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontrato`
--

CREATE TABLE `tipocontrato` (
  `id_contrato` int(11) NOT NULL,
  `contrato_nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipocontrato`
--

INSERT INTO `tipocontrato` (`id_contrato`, `contrato_nombre`) VALUES
(0, '--'),
(1, 'INDETERMINADO'),
(2, 'SUJETO A MODALIDAD'),
(3, 'POR OBRA DETERMINADA O SERVICIO ESPECIFICO'),
(7, 'DE PERSONAL EXTRANJERO A PLAZO DETERMINADO'),
(8, 'LOCACION DE SERVICIOS'),
(9, 'A TIEMPO PARCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodepartamento`
--

CREATE TABLE `tipodepartamento` (
  `id_departamento` int(11) NOT NULL,
  `departamento_nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipodepartamento`
--

INSERT INTO `tipodepartamento` (`id_departamento`, `departamento_nombre`) VALUES
(0, '--'),
(1, 'COCINA'),
(2, 'LIMPIEZA Y ASEO'),
(3, 'CONTABILIDAD Y FINANZAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposede`
--

CREATE TABLE `tiposede` (
  `id_sede` int(11) NOT NULL,
  `sede_nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiposede`
--

INSERT INTO `tiposede` (`id_sede`, `sede_nombre`) VALUES
(0, '--'),
(1, 'Sede Iquitos'),
(2, 'Sede Punchana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id_tipo_afectacion` int(11) NOT NULL,
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `codigo_afectacion` char(4) DEFAULT NULL,
  `nombre_afectacion` char(3) DEFAULT NULL,
  `tipo_afectacion` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_afectacion`
--

INSERT INTO `tipo_afectacion` (`id_tipo_afectacion`, `codigo`, `descripcion`, `codigo_afectacion`, `nombre_afectacion`, `tipo_afectacion`) VALUES
(1, '10', 'OP. GRAVADAS', '1000', 'IGV', 'VAT'),
(2, '20', 'OP. EXONERADAS', '9997', 'EXO', 'VAT'),
(3, '30', 'OP. INAFECTAS', '9998', 'INA', 'FRE'),
(4, '21', 'OP. GRATUITAS', '9996', 'GRA', 'FRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documentos`
--

CREATE TABLE `tipo_documentos` (
  `id_tipodocumento` int(11) NOT NULL,
  `tipodocumento_codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipodocumento_identidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipodocumento_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_documentos`
--

INSERT INTO `tipo_documentos` (`id_tipodocumento`, `tipodocumento_codigo`, `tipodocumento_identidad`, `tipodocumento_estado`) VALUES
(1, '0', 'DOC.TRIB.NO.DOM.SIN.RUC', 0),
(2, '1', 'Documento Nacional de Identidad', 1),
(3, '4', 'Carnet de extranjería', 0),
(4, '6', 'Registro Unico de Contributentes', 1),
(5, '7', 'Pasaporte', 0),
(6, 'A', 'Cédula Diplomática de identidad', 0),
(7, 'B', 'DOC.IDENT.PAIS.RESIDENCIA-NO.D', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ncreditos`
--

CREATE TABLE `tipo_ncreditos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_nota_descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_ncreditos`
--

INSERT INTO `tipo_ncreditos` (`id`, `codigo`, `tipo_nota_descripcion`, `estado`) VALUES
(1, '01', 'Anulación de la operacion', 0),
(2, '02', 'Anulación por error en el RUC', 0),
(3, '03', 'Corrección por error en la descripcion', 0),
(4, '04', 'Descuento Global', 0),
(5, '05', 'Descuento por ítem', 0),
(6, '06', 'Devolución total', 0),
(7, '07', 'Devolución por ítem', 0),
(8, '08', 'Bonificación', 0),
(9, '09', 'Disminición en el valor', 0),
(10, '10', 'Otros conceptos', 0),
(11, '11', 'Ajustes de operaciones de exportacion', 0),
(12, '12', 'Ajustes afectos al IVAP', 0),
(13, '13', 'Corrección del monto neto pendiente de pago y/o la(s) fechas(s) de vencimiento del pago \r\núnico o de las cuotas y/o los montos correspondientes a cada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ndebitos`
--

CREATE TABLE `tipo_ndebitos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_nota_descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_ndebitos`
--

INSERT INTO `tipo_ndebitos` (`id`, `codigo`, `tipo_nota_descripcion`, `estado`) VALUES
(1, '01', 'Intereses por mora', 0),
(2, '02', 'Aumento en el valor', 0),
(3, '03', 'Penalidades / Otros conceptos', 0),
(4, '10', 'Ajustes de operaciones de exportación', 0),
(5, '11', 'Ajustes afectos al IVAP', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_tipo_pago` int(11) NOT NULL,
  `tipo_pago_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_pago_estado` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipo_pago`, `tipo_pago_nombre`, `tipo_pago_estado`) VALUES
(1, 'TARJETA', 1),
(2, 'SIN MODALIDAD', 0),
(3, 'EFECTIVO', 1),
(4, 'TRANSFERENCIA YAPE', 1),
(5, 'TRANSFERENCIA PLIN', 1),
(6, 'TRANSFERENCIA OTROS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `id_turno` int(11) NOT NULL,
  `turno_nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `turno_hora_entrada` time NOT NULL,
  `turno_hora_tolerancia` time NOT NULL,
  `turno_hora_salida` time NOT NULL,
  `turno_estado` tinyint(2) NOT NULL,
  `turno_fecha_registro` datetime NOT NULL,
  `turno_usuario_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`id_turno`, `turno_nombre`, `turno_hora_entrada`, `turno_hora_tolerancia`, `turno_hora_salida`, `turno_estado`, `turno_fecha_registro`, `turno_usuario_registro`) VALUES
(1, 'Turno 1', '08:00:00', '08:10:00', '16:00:00', 1, '0000-00-00 00:00:00', 1),
(2, 'Turno 2', '13:15:00', '13:25:00', '19:00:00', 1, '0000-00-00 00:00:00', 1),
(3, 'Turno 3', '18:30:00', '18:40:00', '23:35:00', 1, '2021-08-09 22:15:29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id_medida` int(11) NOT NULL,
  `medida_codigo_unidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `medida_nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `medida_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id_medida`, `medida_codigo_unidad`, `medida_nombre`, `medida_activo`) VALUES
(1, '4A', 'BOBINAS                                           ', 0),
(2, 'BJ', 'BALDE                                             ', 1),
(3, 'BLL', 'BARRILES                                          ', 0),
(4, 'BG', 'BOLSA                                             ', 1),
(5, 'BO', 'BOTELLA                                      ', 1),
(6, 'BX', 'CAJA                                              ', 1),
(7, 'CT', 'CARTONES                                          ', 0),
(8, 'CMK', 'CENTIMETRO CUADRADO                               ', 0),
(9, 'CMQ', 'CENTIMETRO CUBICO                                 ', 0),
(10, 'CMT', 'CENTIMETRO LINEAL                                 ', 0),
(11, 'CEN', 'CIENTO DE UNIDADES                                ', 1),
(12, 'CY', 'CILINDRO                                          ', 0),
(13, 'CJ', 'CONOS                                             ', 0),
(14, 'DZN', 'DOCENA                                            ', 1),
(15, 'DZP', 'DOCENA POR 10**6                                  ', 0),
(16, 'BE', 'FARDO                                             ', 0),
(17, 'GLI', 'GALON INGLES (4,545956L)', 1),
(18, 'GRM', 'GRAMO                                             ', 1),
(19, 'GRO', 'GRUESA                                            ', 0),
(20, 'HLT', 'HECTOLITRO                                        ', 0),
(21, 'LEF', 'HOJA                                              ', 0),
(22, 'SET', 'JUEGO                                             ', 0),
(23, 'KGM', 'KILOGRAMO                                         ', 1),
(24, 'KTM', 'KILOMETRO                                         ', 0),
(25, 'KWH', 'KILOVATIO HORA                                    ', 0),
(26, 'KT', 'KIT                                               ', 0),
(27, 'CA', 'LATAS                                             ', 0),
(28, 'LBR', 'LIBRAS                                            ', 0),
(29, 'LTR', 'LITRO                                             ', 1),
(30, 'MWH', 'MEGAWATT HORA                                     ', 0),
(31, 'MTR', 'METRO                                             ', 1),
(32, 'MTK', 'METRO CUADRADO                                    ', 0),
(33, 'MTQ', 'METRO CUBICO                                      ', 0),
(34, 'MGM', 'MILIGRAMOS                                        ', 0),
(35, 'MLT', 'MILILITRO                                         ', 0),
(36, 'MMT', 'MILIMETRO                                         ', 0),
(37, 'MMK', 'MILIMETRO CUADRADO                                ', 0),
(38, 'MMQ', 'MILIMETRO CUBICO                                  ', 0),
(39, 'MLL', 'MILLARES                                          ', 0),
(40, 'UM', 'MILLON DE UNIDADES                                ', 0),
(41, 'ONZ', 'ONZAS                                             ', 0),
(42, 'PF', 'PALETAS                                           ', 0),
(43, 'PK', 'PAQUETE                                           ', 1),
(44, 'PR', 'PAR                                               ', 0),
(45, 'FOT', 'PIES                                              ', 0),
(46, 'FTK', 'PIES CUADRADOS                                    ', 0),
(47, 'FTQ', 'PIES CUBICOS                                      ', 0),
(48, 'C62', 'PIEZAS                                            ', 0),
(49, 'PG', 'PLACAS                                            ', 0),
(50, 'ST', 'PLIEGO                                            ', 0),
(51, 'INH', 'PULGADAS                                          ', 0),
(52, 'RM', 'RESMA                                             ', 0),
(53, 'DR', 'TAMBOR                                            ', 0),
(54, 'STN', 'TONELADA CORTA                                    ', 0),
(55, 'LTN', 'TONELADA LARGA                                    ', 0),
(56, 'TNE', 'TONELADAS                                         ', 0),
(57, 'TU', 'TUBOS                                             ', 0),
(58, 'NIU', 'UNIDAD (BIENES)                                   ', 1),
(59, 'ZZ', 'UNIDAD (SERVICIOS) ', 1),
(60, 'GLL', 'US GALON (3,7843 L)', 0),
(61, 'YRD', 'YARDA                                             ', 0),
(62, 'YDK', 'YARDA CUADRADA                                    ', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `usuario_nickname` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_contrasenha` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_imagen` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_estado` tinyint(1) NOT NULL,
  `usuario_creacion` datetime NOT NULL,
  `usuario_ultimo_login` datetime NOT NULL,
  `usuario_ultima_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `id_rol`, `usuario_nickname`, `usuario_contrasenha`, `usuario_email`, `usuario_imagen`, `usuario_estado`, `usuario_creacion`, `usuario_ultimo_login`, `usuario_ultima_modificacion`) VALUES
(1, 1, 2, 'superadmin', '$2y$10$oPOOOgTUr4zIh511ATm/q.vzsAmxP.e2.vzyEbRn/1pzyWz2oXj0a', 'cesarjose@bufeotec.com', 'media/usuarios/usuario.jpg', 1, '2020-09-17 00:00:00', '2022-03-25 12:32:26', '2020-09-17 00:00:00'),
(2, 2, 3, 'admin', '$2y$10$SMsrzOaJ/nGY1FSmy9SyG.vdL6xmt9/rKjBYj0z4RYa79d1N5KqAW', 'carlos@gmail.com', 'media/usuarios/usuario.jpg', 1, '2020-10-27 18:29:10', '2022-03-25 12:29:33', '2020-10-27 18:29:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_negocio`
--

CREATE TABLE `usuarios_negocio` (
  `id_usuario_negocio` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `usuario_negocio_fecha` datetime NOT NULL,
  `usuario_negocio_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_negocio`
--

INSERT INTO `usuarios_negocio` (`id_usuario_negocio`, `id_negocio`, `id_usuario`, `usuario_negocio_fecha`, `usuario_negocio_estado`) VALUES
(3, 3, 1, '2021-03-24 14:24:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_sucursal`
--

CREATE TABLE `usuarios_sucursal` (
  `id_usuario_sucursal` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `usuario_sucursal_fecha` datetime NOT NULL,
  `usuario_sucursal_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_sucursal`
--

INSERT INTO `usuarios_sucursal` (`id_usuario_sucursal`, `id_sucursal`, `id_usuario`, `id_rol`, `usuario_sucursal_fecha`, `usuario_sucursal_estado`) VALUES
(3, 5, 1, 2, '2021-03-24 14:24:09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_caja_numero` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT '1',
  `id_usuario` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL DEFAULT '3',
  `id_moneda` int(11) NOT NULL DEFAULT '1',
  `venta_condicion_resumen` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-Registro, 2-Actualizar, 3-baja',
  `venta_tipo_envio` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1-directo, 2-resumen diario',
  `venta_direccion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_tipo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `venta_serie` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_correlativo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `venta_totalgratuita` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalexonerada` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalinafecta` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totalgravada` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_totaligv` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_incluye_igv` tinyint(2) NOT NULL DEFAULT '1',
  `venta_totaldescuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_pago_cliente` decimal(10,2) DEFAULT NULL,
  `venta_vuelto` decimal(10,2) DEFAULT NULL,
  `venta_fecha` datetime NOT NULL,
  `venta_observacion` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_documento_modificar` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serie_modificar` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correlativo_modificar` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_codigo_motivo_nota` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_estado_sunat` tinyint(4) NOT NULL DEFAULT '0',
  `venta_fecha_envio` datetime DEFAULT NULL,
  `venta_rutaXML` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_rutaCDR` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_respuesta_sunat` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `venta_fecha_de_baja` date DEFAULT NULL,
  `anulado_sunat` tinyint(4) NOT NULL DEFAULT '0',
  `venta_cancelar` tinyint(1) NOT NULL DEFAULT '1',
  `venta_seriecorrelativo_notaventa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '	Aqui se llena cuando se edita una nota de venta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_anulados`
--

CREATE TABLE `ventas_anulados` (
  `id_venta_anulado` int(11) NOT NULL,
  `venta_anulado_fecha` date NOT NULL,
  `venta_anulado_serie` varchar(20) NOT NULL,
  `venta_anulado_correlativo` int(11) NOT NULL,
  `venta_anulacion_ticket` varchar(100) NOT NULL,
  `venta_anulado_rutaXML` varchar(1000) NOT NULL,
  `venta_anulado_rutaCDR` varchar(1000) DEFAULT NULL,
  `venta_anulado_estado_sunat` varchar(1000) DEFAULT NULL,
  `id_venta` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `venta_anulado_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `venta_anulado_estado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_cuotas`
--

CREATE TABLE `ventas_cuotas` (
  `id_ventas_cuotas` int(11) NOT NULL,
  `id_ventas` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `venta_cuota_numero` varchar(30) NOT NULL,
  `venta_cuota_importe` decimal(10,2) NOT NULL,
  `venta_cuota_fecha` date NOT NULL,
  `venta_cuota_estado` tinyint(4) NOT NULL DEFAULT '1',
  `venta_cuota_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id_venta_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_comanda_detalle` int(11) NOT NULL,
  `venta_detalle_valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_precio_unitario` decimal(10,2) NOT NULL,
  `venta_detalle_nombre_producto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `venta_detalle_cantidad` double NOT NULL,
  `venta_detalle_total_igv` decimal(10,2) NOT NULL,
  `venta_detalle_porcentaje_igv` decimal(10,2) NOT NULL DEFAULT '0.18',
  `venta_detalle_total_icbper` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_valor_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_importe_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_producto_precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle_pagos`
--

CREATE TABLE `ventas_detalle_pagos` (
  `id_venta_detalle_pago` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `venta_detalle_pago_monto` decimal(10,2) NOT NULL DEFAULT '0.00',
  `venta_detalle_pago_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes_salida`
--
ALTER TABLE `almacenes_salida`
  ADD PRIMARY KEY (`id_almacen`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_sucursal` (`id_recurso_sede`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD KEY `id_persona_turno` (`id_persona_turno`);

--
-- Indices de la tabla `asistencia_fecha`
--
ALTER TABLE `asistencia_fecha`
  ADD PRIMARY KEY (`id_asistencia_fecha`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `caja_numero`
--
ALTER TABLE `caja_numero`
  ADD PRIMARY KEY (`id_caja_numero`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `categorias_negocio`
--
ALTER TABLE `categorias_negocio`
  ADD PRIMARY KEY (`id_categoria_negocio`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `comanda_detalle`
--
ALTER TABLE `comanda_detalle`
  ADD PRIMARY KEY (`id_comanda_detalle`),
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `conversiones`
--
ALTER TABLE `conversiones`
  ADD PRIMARY KEY (`id_conversion`),
  ADD KEY `id_recurso_sede` (`id_recurso_sede`),
  ADD KEY `conversion_unidad_medida` (`conversion_unidad_medida`);

--
-- Indices de la tabla `correlativos`
--
ALTER TABLE `correlativos`
  ADD PRIMARY KEY (`id_correlativo`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `id_orden_compra` (`id_orden_compra`),
  ADD KEY `id_recurso_sede` (`id_recurso_sede`);

--
-- Indices de la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  ADD PRIMARY KEY (`id_detalle_receta`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_recursos_sede` (`id_recursos_sede`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  ADD PRIMARY KEY (`id_envio_resumen`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  ADD PRIMARY KEY (`id_envio_resumen_detalle`),
  ADD KEY `id_envio_resumen` (`id_envio_resumen`);

--
-- Indices de la tabla `feriados`
--
ALTER TABLE `feriados`
  ADD PRIMARY KEY (`id_feriado`);

--
-- Indices de la tabla `gastos_personal`
--
ALTER TABLE `gastos_personal`
  ADD PRIMARY KEY (`id_gasto_personal`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `igv`
--
ALTER TABLE `igv`
  ADD PRIMARY KEY (`id_igv`);

--
-- Indices de la tabla `memorandum`
--
ALTER TABLE `memorandum`
  ADD PRIMARY KEY (`id_memorandum`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id_negocio`),
  ADD KEY `id_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `nota_venta`
--
ALTER TABLE `nota_venta`
  ADD PRIMARY KEY (`id_nota_venta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `nota_venta_detalle`
--
ALTER TABLE `nota_venta_detalle`
  ADD PRIMARY KEY (`id_nota_venta_detalle`),
  ADD KEY `id_nota_venta` (`id_nota_venta`),
  ADD KEY `id_comanda_detalle` (`id_comanda_detalle`);

--
-- Indices de la tabla `obligacion_pagar`
--
ALTER TABLE `obligacion_pagar`
  ADD PRIMARY KEY (`id_obligacion`);

--
-- Indices de la tabla `obligacion_personal`
--
ALTER TABLE `obligacion_personal`
  ADD PRIMARY KEY (`id_obligacionper`),
  ADD KEY `id_obligacion` (`id_obligacion`),
  ADD KEY `id_periodo` (`id_periodo`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_opcion`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id_orden_compra`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_sucursal` (`id_sucursal`);

--
-- Indices de la tabla `pedidos_gratis`
--
ALTER TABLE `pedidos_gratis`
  ADD PRIMARY KEY (`id_pedido_gratis`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedidos_gratis_detalles`
--
ALTER TABLE `pedidos_gratis_detalles`
  ADD PRIMARY KEY (`id_pedido_gratis_detalle`),
  ADD KEY `id_pedido_gratis` (`id_pedido_gratis`),
  ADD KEY `id_comanda_detalle` (`id_comanda_detalle`);

--
-- Indices de la tabla `periodo_laboral`
--
ALTER TABLE `periodo_laboral`
  ADD PRIMARY KEY (`id_periodo`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_contrato` (`id_contrato`),
  ADD KEY `id_cargo` (`id_cargo`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `id_sede` (`id_sede`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `id_opcion` (`id_opcion`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `persona_turno`
--
ALTER TABLE `persona_turno`
  ADD PRIMARY KEY (`id_persona_turno`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_turno` (`id_turno`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `producto_familia`
--
ALTER TABLE `producto_familia`
  ADD PRIMARY KEY (`id_producto_familia`);

--
-- Indices de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  ADD PRIMARY KEY (`id_producto_precio`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_tipodocumento` (`id_tipodocumento`);

--
-- Indices de la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id_puntos`);

--
-- Indices de la tabla `puntos_cliente`
--
ALTER TABLE `puntos_cliente`
  ADD PRIMARY KEY (`id_punto_cliente`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id_recurso`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `recursos_sede`
--
ALTER TABLE `recursos_sede`
  ADD PRIMARY KEY (`id_recurso_sede`),
  ADD KEY `id_medida` (`id_medida`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_recurso` (`id_recurso`);

--
-- Indices de la tabla `registro_asistencias`
--
ALTER TABLE `registro_asistencias`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`);

--
-- Indices de la tabla `restricciones`
--
ALTER TABLE `restricciones`
  ADD PRIMARY KEY (`id_restriccion`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_opcion` (`id_opcion`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_menus`
--
ALTER TABLE `roles_menus`
  ADD PRIMARY KEY (`id_rol_menu`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`id_serie`) USING BTREE;

--
-- Indices de la tabla `sub_recetas`
--
ALTER TABLE `sub_recetas`
  ADD PRIMARY KEY (`id_sub_receta`),
  ADD KEY `id_receta` (`id_receta`),
  ADD KEY `id_receta_2` (`id_receta_2`),
  ADD KEY `id_medida` (`id_medida`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`),
  ADD KEY `id_ciudad` (`id_ciudad`),
  ADD KEY `id_negocio` (`id_negocio`);

--
-- Indices de la tabla `tipoadjuntos`
--
ALTER TABLE `tipoadjuntos`
  ADD PRIMARY KEY (`id_adjunto`);

--
-- Indices de la tabla `tipocargo`
--
ALTER TABLE `tipocargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `tipodepartamento`
--
ALTER TABLE `tipodepartamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `tiposede`
--
ALTER TABLE `tiposede`
  ADD PRIMARY KEY (`id_sede`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`id_tipo_afectacion`);

--
-- Indices de la tabla `tipo_documentos`
--
ALTER TABLE `tipo_documentos`
  ADD PRIMARY KEY (`id_tipodocumento`);

--
-- Indices de la tabla `tipo_ncreditos`
--
ALTER TABLE `tipo_ncreditos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_ndebitos`
--
ALTER TABLE `tipo_ndebitos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipo_pago`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`id_turno`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id_medida`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `usuarios_negocio`
--
ALTER TABLE `usuarios_negocio`
  ADD PRIMARY KEY (`id_usuario_negocio`),
  ADD KEY `id_negocio` (`id_negocio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios_sucursal`
--
ALTER TABLE `usuarios_sucursal`
  ADD PRIMARY KEY (`id_usuario_sucursal`),
  ADD KEY `id_sucursal` (`id_sucursal`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `ventas_anulados`
--
ALTER TABLE `ventas_anulados`
  ADD PRIMARY KEY (`id_venta_anulado`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `ventas_cuotas`
--
ALTER TABLE `ventas_cuotas`
  ADD PRIMARY KEY (`id_ventas_cuotas`),
  ADD KEY `id_ventas` (`id_ventas`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`);

--
-- Indices de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id_venta_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_comanda_detalle` (`id_comanda_detalle`);

--
-- Indices de la tabla `ventas_detalle_pagos`
--
ALTER TABLE `ventas_detalle_pagos`
  ADD PRIMARY KEY (`id_venta_detalle_pago`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes_salida`
--
ALTER TABLE `almacenes_salida`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistencia_fecha`
--
ALTER TABLE `asistencia_fecha`
  MODIFY `id_asistencia_fecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja_numero`
--
ALTER TABLE `caja_numero`
  MODIFY `id_caja_numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `categorias_negocio`
--
ALTER TABLE `categorias_negocio`
  MODIFY `id_categoria_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comanda_detalle`
--
ALTER TABLE `comanda_detalle`
  MODIFY `id_comanda_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conversiones`
--
ALTER TABLE `conversiones`
  MODIFY `id_conversion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correlativos`
--
ALTER TABLE `correlativos`
  MODIFY `id_correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  MODIFY `id_detalle_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `envio_resumen`
--
ALTER TABLE `envio_resumen`
  MODIFY `id_envio_resumen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio_resumen_detalle`
--
ALTER TABLE `envio_resumen_detalle`
  MODIFY `id_envio_resumen_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `feriados`
--
ALTER TABLE `feriados`
  MODIFY `id_feriado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `gastos_personal`
--
ALTER TABLE `gastos_personal`
  MODIFY `id_gasto_personal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `igv`
--
ALTER TABLE `igv`
  MODIFY `id_igv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `memorandum`
--
ALTER TABLE `memorandum`
  MODIFY `id_memorandum` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `negocios`
--
ALTER TABLE `negocios`
  MODIFY `id_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nota_venta`
--
ALTER TABLE `nota_venta`
  MODIFY `id_nota_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_venta_detalle`
--
ALTER TABLE `nota_venta_detalle`
  MODIFY `id_nota_venta_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obligacion_pagar`
--
ALTER TABLE `obligacion_pagar`
  MODIFY `id_obligacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obligacion_personal`
--
ALTER TABLE `obligacion_personal`
  MODIFY `id_obligacionper` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_gratis`
--
ALTER TABLE `pedidos_gratis`
  MODIFY `id_pedido_gratis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos_gratis_detalles`
--
ALTER TABLE `pedidos_gratis_detalles`
  MODIFY `id_pedido_gratis_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo_laboral`
--
ALTER TABLE `periodo_laboral`
  MODIFY `id_periodo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona_turno`
--
ALTER TABLE `persona_turno`
  MODIFY `id_persona_turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `producto_familia`
--
ALTER TABLE `producto_familia`
  MODIFY `id_producto_familia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  MODIFY `id_producto_precio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntos`
--
ALTER TABLE `puntos`
  MODIFY `id_puntos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntos_cliente`
--
ALTER TABLE `puntos_cliente`
  MODIFY `id_punto_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id_recurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `recursos_sede`
--
ALTER TABLE `recursos_sede`
  MODIFY `id_recurso_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `registro_asistencias`
--
ALTER TABLE `registro_asistencias`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `restricciones`
--
ALTER TABLE `restricciones`
  MODIFY `id_restriccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles_menus`
--
ALTER TABLE `roles_menus`
  MODIFY `id_rol_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `serie`
--
ALTER TABLE `serie`
  MODIFY `id_serie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `sub_recetas`
--
ALTER TABLE `sub_recetas`
  MODIFY `id_sub_receta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipoadjuntos`
--
ALTER TABLE `tipoadjuntos`
  MODIFY `id_adjunto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tipocargo`
--
ALTER TABLE `tipocargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipodepartamento`
--
ALTER TABLE `tipodepartamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiposede`
--
ALTER TABLE `tiposede`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_documentos`
--
ALTER TABLE `tipo_documentos`
  MODIFY `id_tipodocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_ncreditos`
--
ALTER TABLE `tipo_ncreditos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_ndebitos`
--
ALTER TABLE `tipo_ndebitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios_negocio`
--
ALTER TABLE `usuarios_negocio`
  MODIFY `id_usuario_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios_sucursal`
--
ALTER TABLE `usuarios_sucursal`
  MODIFY `id_usuario_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_anulados`
--
ALTER TABLE `ventas_anulados`
  MODIFY `id_venta_anulado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_cuotas`
--
ALTER TABLE `ventas_cuotas`
  MODIFY `id_ventas_cuotas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id_venta_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle_pagos`
--
ALTER TABLE `ventas_detalle_pagos`
  MODIFY `id_venta_detalle_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacenes_salida`
--
ALTER TABLE `almacenes_salida`
  ADD CONSTRAINT `almacenes_salida_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`id_persona_turno`) REFERENCES `persona_turno` (`id_persona_turno`);

--
-- Filtros para la tabla `categorias_negocio`
--
ALTER TABLE `categorias_negocio`
  ADD CONSTRAINT `categorias_negocio_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`),
  ADD CONSTRAINT `categorias_negocio_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `comanda_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`),
  ADD CONSTRAINT `comanda_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `comanda_detalle`
--
ALTER TABLE `comanda_detalle`
  ADD CONSTRAINT `comanda_detalle_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id_comanda`),
  ADD CONSTRAINT `comanda_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `conversiones`
--
ALTER TABLE `conversiones`
  ADD CONSTRAINT `conversiones_ibfk_1` FOREIGN KEY (`id_recurso_sede`) REFERENCES `recursos_sede` (`id_recurso_sede`),
  ADD CONSTRAINT `conversiones_ibfk_2` FOREIGN KEY (`conversion_unidad_medida`) REFERENCES `unidad_medida` (`id_medida`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`id_orden_compra`) REFERENCES `orden_compra` (`id_orden_compra`),
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_recurso_sede`) REFERENCES `recursos_sede` (`id_recurso_sede`);

--
-- Filtros para la tabla `detalle_recetas`
--
ALTER TABLE `detalle_recetas`
  ADD CONSTRAINT `detalle_recetas_ibfk_1` FOREIGN KEY (`id_recursos_sede`) REFERENCES `recursos_sede` (`id_recurso_sede`),
  ADD CONSTRAINT `detalle_recetas_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`);

--
-- Filtros para la tabla `memorandum`
--
ALTER TABLE `memorandum`
  ADD CONSTRAINT `memorandum_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD CONSTRAINT `negocios_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`);

--
-- Filtros para la tabla `obligacion_personal`
--
ALTER TABLE `obligacion_personal`
  ADD CONSTRAINT `obligacion_personal_ibfk_1` FOREIGN KEY (`id_obligacion`) REFERENCES `obligacion_pagar` (`id_obligacion`),
  ADD CONSTRAINT `obligacion_personal_ibfk_2` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_laboral` (`id_periodo`),
  ADD CONSTRAINT `obligacion_personal_ibfk_3` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`);

--
-- Filtros para la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`id_solicitante`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `orden_compra_ibfk_2` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id_tipo_pago`),
  ADD CONSTRAINT `orden_compra_ibfk_3` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`),
  ADD CONSTRAINT `orden_compra_ibfk_4` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`);

--
-- Filtros para la tabla `periodo_laboral`
--
ALTER TABLE `periodo_laboral`
  ADD CONSTRAINT `periodo_laboral_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `periodo_laboral_ibfk_2` FOREIGN KEY (`id_contrato`) REFERENCES `tipocontrato` (`id_contrato`),
  ADD CONSTRAINT `periodo_laboral_ibfk_3` FOREIGN KEY (`id_cargo`) REFERENCES `tipocargo` (`id_cargo`),
  ADD CONSTRAINT `periodo_laboral_ibfk_4` FOREIGN KEY (`id_departamento`) REFERENCES `tipodepartamento` (`id_departamento`),
  ADD CONSTRAINT `periodo_laboral_ibfk_5` FOREIGN KEY (`id_sede`) REFERENCES `tiposede` (`id_sede`),
  ADD CONSTRAINT `periodo_laboral_ibfk_6` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`id_opcion`);

--
-- Filtros para la tabla `persona_turno`
--
ALTER TABLE `persona_turno`
  ADD CONSTRAINT `persona_turno_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `persona_turno_ibfk_2` FOREIGN KEY (`id_turno`) REFERENCES `turno` (`id_turno`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`);

--
-- Filtros para la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  ADD CONSTRAINT `producto_precio_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`),
  ADD CONSTRAINT `proveedor_ibfk_2` FOREIGN KEY (`id_tipodocumento`) REFERENCES `tipo_documentos` (`id_tipodocumento`);

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `recursos_sede`
--
ALTER TABLE `recursos_sede`
  ADD CONSTRAINT `recursos_sede_ibfk_1` FOREIGN KEY (`id_medida`) REFERENCES `unidad_medida` (`id_medida`),
  ADD CONSTRAINT `recursos_sede_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `recursos_sede_ibfk_3` FOREIGN KEY (`id_recurso`) REFERENCES `recursos` (`id_recurso`);

--
-- Filtros para la tabla `restricciones`
--
ALTER TABLE `restricciones`
  ADD CONSTRAINT `restricciones_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `restricciones_ibfk_2` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`id_opcion`);

--
-- Filtros para la tabla `roles_menus`
--
ALTER TABLE `roles_menus`
  ADD CONSTRAINT `roles_menus_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `roles_menus_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`);

--
-- Filtros para la tabla `sub_recetas`
--
ALTER TABLE `sub_recetas`
  ADD CONSTRAINT `sub_recetas_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`),
  ADD CONSTRAINT `sub_recetas_ibfk_2` FOREIGN KEY (`id_receta_2`) REFERENCES `recetas` (`id_receta`),
  ADD CONSTRAINT `sub_recetas_ibfk_3` FOREIGN KEY (`id_medida`) REFERENCES `unidad_medida` (`id_medida`);

--
-- Filtros para la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD CONSTRAINT `sucursal_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`),
  ADD CONSTRAINT `sucursal_ibfk_2` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `usuarios_negocio`
--
ALTER TABLE `usuarios_negocio`
  ADD CONSTRAINT `usuarios_negocio_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`),
  ADD CONSTRAINT `usuarios_negocio_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios_sucursal`
--
ALTER TABLE `usuarios_sucursal`
  ADD CONSTRAINT `usuarios_sucursal_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `usuarios_sucursal_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuarios_sucursal_ibfk_3` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `id_tipo_venta` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id_tipo_pago`),
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_moneda`) REFERENCES `monedas` (`id_moneda`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id_mesa`),
  ADD CONSTRAINT `ventas_ibfk_4` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD CONSTRAINT `id_venta` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
