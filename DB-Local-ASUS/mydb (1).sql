-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2017 a las 05:47:26
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--
DROP DATABASE IF EXISTS mydb;
CREATE DATABASE IF NOT EXISTS mydb;
USE mydb;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `addadmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addadmin` (IN `wnombre` VARCHAR(45), IN `wapellido` VARCHAR(45), IN `wcorreo` VARCHAR(45), IN `wcontraseña` VARCHAR(45), IN `wtelefono` INT, IN `wcargo` VARCHAR(45), IN `estado` INT, IN `wrol` INT, IN `wempre` INT)  BEGIN
INSERT INTO admin (nombre,apellido,correo,contraseña,telefono,cargo,estado,rol_id_rol,dato_empresa_id_dato)
VALUES(wnombre,wapellido,wcorreo,wcontraseña,wtelefono,wcargo,estado,wrol,wempre);
END$$

DROP PROCEDURE IF EXISTS `addcolor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addcolor` (IN `wcolor` VARCHAR(45))  BEGIN
INSERT INTO color(descripcion)
VALUES(wcolor);
END$$

DROP PROCEDURE IF EXISTS `addcoment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addcoment` (`comen` VARCHAR(45), `est` TINYINT, `producto` INT, `categoria` INT, `marca` INT, `correo` VARCHAR(45), `rol` INT)  BEGIN
INSERT INTO `comentario`(`comentario`, `estado`, `producto_id_producto`, `producto_categoria_id_categoria`, `producto_marca_id_marca`, `usuario_correo`, `usuario_rol_id_rol`) VALUES (comen,est,producto,categoria,marca,correo,rol);
END$$

DROP PROCEDURE IF EXISTS `adddevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `adddevolucion` (`fecha` DATE, `unitario` INT, `tot` INT, `justi` VARCHAR(100), `orden` INT, `correo` VARCHAR(45), `rol` INT)  BEGIN
INSERT INTO `devolucion`(`fecha`, `precio_unitario`, `cantidad`, `total`, `justificacion`, `orden_id_orden`,`orden_usuario_correo`, `orden_usuario_rol_id_rol`) VALUES (fecha,unitario,tot,justi,orden,correo,rol);
END$$

DROP PROCEDURE IF EXISTS `addempresa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addempresa` (IN `wnombre` VARCHAR(45), IN `wmision` VARCHAR(500), IN `wvision` VARCHAR(500), IN `wlogo` VARCHAR(60), IN `wcorreo` VARCHAR(45), IN `wtelefono` INT)  BEGIN
INSERT INTO dato_empresa (nombre_empresa,mision,Vision,logo,correo,telefono)
VALUES(wnombre,wmision,wvision,wlogo,wcorreo,wtelefono);
END$$

DROP PROCEDURE IF EXISTS `addFacturacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addFacturacion` (`wid` INT, `wdescripcion` VARCHAR(45), `wcantidad` VARCHAR(45), `wpreciou` VARCHAR(45), `wpreciot` VARCHAR(45))  BEGIN
INSERT INTO `facturacion`(`id_factura`, `descripcion`, `cantidad`, `precio_unitario`, `precio_total`) VALUES (wid,wdescripcion,wcantidad,wpreciou,wpreciot);
END$$

DROP PROCEDURE IF EXISTS `addmarca`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addmarca` (IN `wmarca` VARCHAR(45))  BEGIN
INSERT INTO marca (marca)
VALUES(wmarca);
END$$

DROP PROCEDURE IF EXISTS `Addrol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Addrol` (IN `rcargo` VARCHAR(45))  BEGIN
INSERT INTO rol (cargo)
VALUES(rcargo);
END$$

DROP PROCEDURE IF EXISTS `addscatego`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addscatego` ()  BEGIN
INSERT INTO subcategoria (nombre,descripcion,categoria_id_categoria)
VALUES(wnombre,wdescripcion,wcatego);
END$$

DROP PROCEDURE IF EXISTS `addtalla`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addtalla` (IN `wtalla` DOUBLE(3,1))  BEGIN
INSERT INTO talla (medida)
VALUES (wtalla);
END$$

DROP PROCEDURE IF EXISTS `addtarjetac`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addtarjetac` (IN `tdc` INT, IN `expira` INT, IN `ccv` INT, IN `titular` VARCHAR(45), IN `pago` INT)  BEGIN
INSERT INTO `tarjeta_credito`(`numero_tdc`, `fecha_expiracion`, `CCV2`, `nombre_titular`, `forma_pago_id_tipo_pago`) VALUES (tdc,expira,ccv,titular,pago);
END$$

DROP PROCEDURE IF EXISTS `addusuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addusuario` (IN `wcorreo` VARCHAR(45), IN `wcontrasena` VARCHAR(45), IN `wnombre` VARCHAR(45), IN `wapellido` VARCHAR(45), IN `westado` INT, IN `wrol` INT)  BEGIN
INSERT INTO usuario (correo,contrasena,nombre,apellido,estado,rol_id_rol)
VALUES (wcorreo,wcontrasena,wnombre,wapellido,westado,wrol);
END$$

DROP PROCEDURE IF EXISTS `deleteadmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteadmin` (IN `wid` INT)  BEGIN
DELETE FROM admin
WHERE idadmin = wid;
END$$

DROP PROCEDURE IF EXISTS `deletecolor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletecolor` (`id` INT)  BEGIN
DELETE FROM color WHERE id_color = id;
END$$

DROP PROCEDURE IF EXISTS `deletecoment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletecoment` (`id` INT)  BEGIN
DELETE FROM comentario WHERE id_comentario = id;
END$$

DROP PROCEDURE IF EXISTS `deletedevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletedevolucion` (`id` INT)  BEGIN
DELETE FROM devolucion WHERE id_devolución = id;
end$$

DROP PROCEDURE IF EXISTS `deleteempresa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteempresa` (IN `wid` INT)  BEGIN
DELETE FROM dato_empresa
WHERE id_dato = wid;
END$$

DROP PROCEDURE IF EXISTS `deletefactura`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletefactura` (`wid` INT)  BEGIN DELETE FROM facturacion WHERE id_factura = wid;
END$$

DROP PROCEDURE IF EXISTS `deletemarca`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletemarca` (IN `wid` INT)  BEGIN
DELETE FROM marca
where id_marca = wid;
END$$

DROP PROCEDURE IF EXISTS `Deleterol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Deleterol` (IN `Rid` INT)  BEGIN
DELETE from rol
WHERE id_rol=Rid;
END$$

DROP PROCEDURE IF EXISTS `deletescatego`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletescatego` (IN `wid` INT)  BEGIN
DELETE FROM subcategoria
WHERE id_categoria = wid;
END$$

DROP PROCEDURE IF EXISTS `deletetalla`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletetalla` (`id` INT)  BEGIN
DELETE FROM talla WHERE id_talla = id;
END$$

DROP PROCEDURE IF EXISTS `deletetdc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletetdc` (`id` INT)  BEGIN
DELETE FROM tarjeta_credito WHERE id_tdc = id;
END$$

DROP PROCEDURE IF EXISTS `deleteusuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteusuario` (IN `wcorreo` VARCHAR(45))  BEGIN
DELETE FROM usuario
WHERE correo = wcorreo;
END$$

DROP PROCEDURE IF EXISTS `editadmin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editadmin` (IN `Wid` INT, IN `wnombre` VARCHAR(45), IN `wapellido` VARCHAR(45), IN `wcorreo` VARCHAR(45), IN `wcontraseña` VARCHAR(45), IN `wtelefono` INT, IN `wcargo` VARCHAR(45), IN `westado` INT, IN `wrol` INT, IN `wempre` INT)  BEGIN
UPDATE admin SET
nombre = wnombre,
apellido = wapellido,
correo = wcorreo,
contraseña = wcontraseña,
telefono = wtelefono,
cargo = wcargo,
estado = westado,
rol_id_rol = wrol,
dato_empresa_id_dato = wempre
WHERE idadmin = wid;
END$$

DROP PROCEDURE IF EXISTS `editcolor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editcolor` (`id` INT, `wcolor` VARCHAR(45))  BEGIN
UPDATE color SET
descripcion = wcolor
WHERE id_color = id;
END$$

DROP PROCEDURE IF EXISTS `editcoment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editcoment` (`id` INT, `comen` VARCHAR(45), `esta` INT, `produ` INT, `catego` INT, `marca` INT, `correo` VARCHAR(45), `rol` INT)  BEGIN
UPDATE comentario SET
comentario = comen,
estado = esta,
producto_id_producto = produ,
producto_categoria_id_categoria = catego,
producto_marca_id_marca = marca,
usuario_correo = correo,
usuario_rol_id_rol = rol
WHERE id_comentario = id;
END$$

DROP PROCEDURE IF EXISTS `editdevolucion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editdevolucion` (IN `id` INT, IN `wfecha` DATE, IN `unitario` INT, IN `wcantidad` INT, IN `total` INT, IN `justi` VARCHAR(100), IN `orden` INT, IN `correo` VARCHAR(45), IN `rol` INT)  BEGIN
UPDATE devolucion SET
fecha = wfecha,
precio_unitario = unitario,
cantidad = wcantidad,
justificacion = justi,
orden_id_orden = orden,
orden_usuario_correo = correo,
orden_usuario_id_rol = rol
WHERE id_devolución = id;
END$$

DROP PROCEDURE IF EXISTS `editempresa`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editempresa` (IN `wid` INT, IN `wnombre` VARCHAR(45), IN `wmision` VARCHAR(500), IN `wvision` VARCHAR(500), IN `wlogo` VARCHAR(60), IN `wcorreo` VARCHAR(45), IN `wtelefono` INT)  BEGIN
UPDATE dato_empresa SET
nombre_empresa = wnombre,
mision = wmision,
Vision = wvision,
logo = wlogo,
correo = wcorreo,
telefono = wtelefono
WHERE id_dato = wid;
END$$

DROP PROCEDURE IF EXISTS `editfacturacion`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editfacturacion` (`wid` INT, `wdescripcion` VARCHAR(450), `cantidad` VARCHAR(450), `preciou` VARCHAR(450), `preciot` VARCHAR(450))  BEGIN
UPDATE `facturacion` SET `descripcion`=wdescripcion,`cantidad`=cantidad,`precio_unitario`=preciou,`precio_total`=preciot WHERE id_factura = wid;
END$$

DROP PROCEDURE IF EXISTS `editmarca`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editmarca` (IN `wid` INT, IN `wmarca` VARCHAR(45))  BEGIN
UPDATE marca SET
marca = wmarca
WHERE id_marca=wid;
END$$

DROP PROCEDURE IF EXISTS `Editrol`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Editrol` (IN `pid` INT, IN `pcargo` VARCHAR(45))  BEGIN
UPDATE rol SET
id_rol = pid,
cargo = pcargo
WHERE id_rol = pid;
END$$

DROP PROCEDURE IF EXISTS `editscatego`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editscatego` (IN `wid` INT, IN `wnombre` VARCHAR(45), IN `wdescripcion` VARCHAR(45), IN `wcatego` INT)  BEGIN
UPDATE subcategoria SET
nombre = wid,
descripcion = wdescripcion,
categoria_id_categoria = wcatego
WHERE id_categoria = wid;
END$$

DROP PROCEDURE IF EXISTS `edittalla`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edittalla` (IN `wid` INT, IN `wtalla` VARCHAR(45))  BEGIN
UPDATE talla SET
medida = wtalla
WHERE id_talla = wid;
END$$

DROP PROCEDURE IF EXISTS `edittarjetac`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `edittarjetac` (IN `id` INT(11), IN `tdc` INT(16), IN `fecha` INT(4), IN `ccv` INT(11), IN `titular` VARCHAR(45))  BEGIN
UPDATE tarjeta_credito SET
id_tdc = id,
numero_tdc = tdc,
fecha_expiracion = fecha,
CCV2 = ccv,
nombre_titular = titular
WHERE id_tdc = id;
END$$

DROP PROCEDURE IF EXISTS `editusuario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `editusuario` (IN `wcorreo` VARCHAR(45), IN `wcontrasena` VARCHAR(45), IN `wnombre` VARCHAR(45), IN `wapellido` VARCHAR(45), IN `westado` INT, IN `wrol` INT)  BEGIN
UPDATE usuario SET
contrasena = wcontrasena,
nombre = wnombre,
apellido = wapellido,
estado = westado,
rol_id_rol = wrol
WHERE correo = wcorreo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseña` varchar(45) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `cargo` varchar(45) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `rol_id_rol` int(11) NOT NULL,
  `dato_empresa_id_dato` int(11) NOT NULL,
  PRIMARY KEY (`idadmin`,`rol_id_rol`),
  KEY `fk_admin_rol1_idx` (`rol_id_rol`),
  KEY `fk_admin_dato_empresa1_idx` (`dato_empresa_id_dato`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`idadmin`, `nombre`, `apellido`, `correo`, `contraseña`, `telefono`, `cargo`, `estado`, `rol_id_rol`, `dato_empresa_id_dato`) VALUES
(1, 'Kelly', 'Cortez', 'kcortez@hotmail.com', '12345', 71458968, 'Administradora', 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE IF NOT EXISTS `carrito` (
  `id_carrito` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `orden_id_orden` int(11) NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  `producto_categoria_id_categoria` int(11) NOT NULL,
  `producto_marca_id_marca` int(11) NOT NULL,
  PRIMARY KEY (`id_carrito`),
  KEY `fk_detalle_orden_orden1_idx` (`orden_id_orden`),
  KEY `fk_detalle_orden_producto1_idx` (`producto_id_producto`,`producto_categoria_id_categoria`,`producto_marca_id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Mujeres', 'Zapatos de mujeres'),
(2, 'Hombres', 'Zapates de hombres'),
(3, 'Niños', 'Zapatos de niños'),
(4, 'Unisex', 'Zapatos unisex'),
(5, 'Niñas', 'Zapatos de niñas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

DROP TABLE IF EXISTS `color`;
CREATE TABLE IF NOT EXISTS `color` (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `descripcion`) VALUES
(1, 'Morado'),
(2, 'negro azulado'),
(3, 'purpura'),
(4, 'Negro'),
(5, 'rojo noegro');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `colores_productos`
--
DROP VIEW IF EXISTS `colores_productos`;
CREATE TABLE IF NOT EXISTS `colores_productos` (
`Id color` int(11)
,`color` varchar(45)
,`Marca` varchar(45)
,`Precio` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE IF NOT EXISTS `comentario` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(45) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  `producto_categoria_id_categoria` int(11) NOT NULL,
  `producto_marca_id_marca` int(11) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_comentario`,`producto_id_producto`,`producto_categoria_id_categoria`,`producto_marca_id_marca`,`usuario_correo`,`usuario_rol_id_rol`),
  KEY `fk_comentario_producto1_idx` (`producto_id_producto`,`producto_categoria_id_categoria`,`producto_marca_id_marca`),
  KEY `fk_comentario_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costo_envio`
--

DROP TABLE IF EXISTS `costo_envio`;
CREATE TABLE IF NOT EXISTS `costo_envio` (
  `id_costo` int(11) NOT NULL,
  `costo` int(11) NOT NULL,
  `departamento_id_departamento` int(11) NOT NULL,
  PRIMARY KEY (`id_costo`),
  KEY `fk_costo_envio_departamento1_idx` (`departamento_id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `costo_envio`
--

INSERT INTO `costo_envio` (`id_costo`, `costo`, `departamento_id_departamento`) VALUES
(1, 10, 1),
(2, 5, 2),
(3, 8, 3),
(4, 3, 4),
(5, 7, 5),
(6, 3, 6),
(7, 10, 7),
(8, 4, 8),
(9, 4, 9),
(10, 6, 10),
(11, 7, 11),
(12, 1, 12),
(13, 9, 13),
(14, 10, 14);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `costo_envio_producto`
--
DROP VIEW IF EXISTS `costo_envio_producto`;
CREATE TABLE IF NOT EXISTS `costo_envio_producto` (
`Departamento de envío` varchar(45)
,`Costo en dólares` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `datos_administrados`
--
DROP VIEW IF EXISTS `datos_administrados`;
CREATE TABLE IF NOT EXISTS `datos_administrados` (
`Nombre` varchar(45)
,`Apellido` varchar(45)
,`email` varchar(45)
,`Contraseña` varchar(45)
,`Teléfono` int(11)
,`Rol en sistema` varchar(45)
,`Estado de usuario` tinyint(1)
,`Cargo en empresa` varchar(45)
,`Nombre empresa` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `datos_usuario`
--
DROP VIEW IF EXISTS `datos_usuario`;
CREATE TABLE IF NOT EXISTS `datos_usuario` (
`email` varchar(45)
,`Contraseña` varchar(45)
,`Nombre` varchar(45)
,`Apellido` varchar(45)
,`Estado de usuario` int(11)
,`Rol en sistema` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dato_empresa`
--

DROP TABLE IF EXISTS `dato_empresa`;
CREATE TABLE IF NOT EXISTS `dato_empresa` (
  `id_dato` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(45) NOT NULL,
  `mision` varchar(500) NOT NULL,
  `Vision` varchar(500) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  PRIMARY KEY (`id_dato`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dato_empresa`
--

INSERT INTO `dato_empresa` (`id_dato`, `nombre_empresa`, `mision`, `Vision`, `logo`, `correo`, `telefono`) VALUES
(1, 'Zapateria Doris', 'ser una empresa de competitividad nacional', 'crecer y vender mas que los demás', '', 'zapateriadoris@dorizzapatos.com', 71426501),
(7, 'po', 'sad', 'asf', '29969.jpg', 'sfasfa@n.vom', 124),
(9, 'Prueba', 'despues del desvergue', 'a ver si guara', '84631.jpg', 'p@p.com', 12365478),
(12, 'hrthh', 'rthrthr', 'trhrth', '6ea32990ac47428b965294a908892e14.jpg', 'a@a.com', 12324365),
(14, 'asdad', 'asdad', 'asda', '26551.jpg', 'a@a.com', 12313212),
(16, 'si edita', 'pero lo probamos', 'con el procedimiento local ADM', '29969.jpg', 'a@a.com', 78);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE IF NOT EXISTS `departamento` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(45) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `departamento`) VALUES
(1, 'Ahuachapan'),
(2, 'Cabanas'),
(3, 'Chalatenango'),
(4, 'Cuscatlan'),
(5, 'La Libertad'),
(6, 'La Paz'),
(7, 'La Union'),
(8, 'Morazan'),
(9, 'Santa Ana'),
(10, 'San Miguel'),
(11, 'San Salvador'),
(12, 'San Vicente'),
(13, 'Sonsonate'),
(14, 'Usulutan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento`
--

DROP TABLE IF EXISTS `descuento`;
CREATE TABLE IF NOT EXISTS `descuento` (
  `id_descuento` int(11) NOT NULL AUTO_INCREMENT,
  `porcentaje` double NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  `tipo_descuento_id_tipo_descuento` int(11) NOT NULL,
  PRIMARY KEY (`id_descuento`,`tipo_descuento_id_tipo_descuento`),
  KEY `fk_descuento_producto1_idx` (`producto_id_producto`),
  KEY `fk_descuento_tipo_descuento1_idx` (`tipo_descuento_id_tipo_descuento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `descuento`
--

INSERT INTO `descuento` (`id_descuento`, `porcentaje`, `producto_id_producto`, `tipo_descuento_id_tipo_descuento`) VALUES
(1, 0.15, 1, 1),
(2, 0.1, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

DROP TABLE IF EXISTS `devolucion`;
CREATE TABLE IF NOT EXISTS `devolucion` (
  `id_devolución` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `precio_unitario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `justificacion` varchar(100) NOT NULL,
  `orden_id_orden` int(11) NOT NULL,
  `orden_usuario_correo` varchar(45) NOT NULL,
  `orden_usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_devolución`),
  KEY `fk_devolucion_orden1_idx` (`orden_id_orden`,`orden_usuario_correo`,`orden_usuario_rol_id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_envio`
--

DROP TABLE IF EXISTS `direccion_envio`;
CREATE TABLE IF NOT EXISTS `direccion_envio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(8) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `codigo_postal` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `departamento_id_departamento` int(11) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_direccion_envio_departamento1_idx` (`departamento_id_departamento`),
  KEY `fk_direccion_envio_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `direccion_envio`
--

INSERT INTO `direccion_envio` (`id`, `nombre`, `apellido`, `telefono`, `correo`, `codigo_postal`, `direccion`, `departamento_id_departamento`, `usuario_correo`, `usuario_rol_id_rol`) VALUES
(1, 'Carlos', 'Aguilar', '71403620', 'aasd@gmail.com', '2301', '1', 10, 'aasd@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `direccion_envio_producto`
--
DROP VIEW IF EXISTS `direccion_envio_producto`;
CREATE TABLE IF NOT EXISTS `direccion_envio_producto` (
`email` varchar(45)
,`Nombre` varchar(45)
,`Apellido` varchar(45)
,`Rol en sistema` varchar(45)
,`Teléfono` varchar(8)
,`Código postal` varchar(45)
,`Dirección` varchar(100)
,`Departamento` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_facturacion`
--

DROP TABLE IF EXISTS `direccion_facturacion`;
CREATE TABLE IF NOT EXISTS `direccion_facturacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `departamento_id_departamento` int(11) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_direccion_facturacion_departamento1_idx` (`departamento_id_departamento`),
  KEY `fk_direccion_facturacion_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `direccion_facturacion`
--

INSERT INTO `direccion_facturacion` (`id`, `nombre`, `apellido`, `telefono`, `correo`, `codigo_postal`, `direccion`, `departamento_id_departamento`, `usuario_correo`, `usuario_rol_id_rol`) VALUES
(1, 'carlos', 'aguilar', 71458978, 'asdqw@gmail.com', 2301, 'san salvador', 10, 'aasd@gmail.com', 1),
(2, 'luis', 'barrera', 78956410, 'gtdfh@gmail.com', 1250, 'col.san jose a la par de un pedazo de tierra', 10, 'gtdfh@gmail.com', 1),
(3, 'Kelly', 'Cortez', 45896230, 'qwerty@gmail.com', 1101, 'col las flores', 10, 'qwerty@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `direccion_facturacion_producto`
--
DROP VIEW IF EXISTS `direccion_facturacion_producto`;
CREATE TABLE IF NOT EXISTS `direccion_facturacion_producto` (
`Nombre` varchar(45)
,`Apellido` varchar(45)
,`Teléfono` int(11)
,`email` varchar(45)
,`Direccion` varchar(45)
,`Departamento` varchar(45)
,`email de usuario registrado` varchar(45)
,`Rol en el sistema` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencia`
--

DROP TABLE IF EXISTS `existencia`;
CREATE TABLE IF NOT EXISTS `existencia` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `producto_id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_existencia_producto1_idx` (`producto_id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `existencia`
--

INSERT INTO `existencia` (`id`, `cantidad`, `producto_id_producto`) VALUES
(1, 10, 1),
(2, 11, 2),
(3, 4, 1),
(4, 4, 2),
(5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `existencias_producto`
--
DROP VIEW IF EXISTS `existencias_producto`;
CREATE TABLE IF NOT EXISTS `existencias_producto` (
`Cantidad` int(11)
,`Marca` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

DROP TABLE IF EXISTS `facturacion`;
CREATE TABLE IF NOT EXISTS `facturacion` (
  `id_factura` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `cantidad` varchar(45) NOT NULL,
  `precio_unitario` varchar(45) NOT NULL,
  `precio_total` varchar(45) NOT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`id_factura`, `descripcion`, `cantidad`, `precio_unitario`, `precio_total`) VALUES
(1, 'compra de zapatos', '1', '10', '10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_pago`
--

DROP TABLE IF EXISTS `forma_pago`;
CREATE TABLE IF NOT EXISTS `forma_pago` (
  `id_tipo_pago` int(11) NOT NULL,
  `tipo_pago` varchar(45) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_pago`),
  KEY `fk_forma_pago_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forma_pago`
--

INSERT INTO `forma_pago` (`id_tipo_pago`, `tipo_pago`, `usuario_correo`, `usuario_rol_id_rol`) VALUES
(1, 'Tarjeta de crédito', 'aasd@gmail.com', 1),
(2, 'Paypal', 'gtdfh@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compra`
--

DROP TABLE IF EXISTS `historial_compra`;
CREATE TABLE IF NOT EXISTS `historial_compra` (
  `id_historial` int(11) NOT NULL,
  `nombreProducto` varchar(45) NOT NULL,
  PRIMARY KEY (`id_historial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(45) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `marca`) VALUES
(1, 'Nike'),
(2, 'All Star'),
(3, 'Adidas'),
(4, 'Reebok'),
(5, 'iphone');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

DROP TABLE IF EXISTS `mensajeria`;
CREATE TABLE IF NOT EXISTS `mensajeria` (
  `id_mensajeria` int(11) NOT NULL AUTO_INCREMENT,
  `mensajes` varchar(45) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`id_mensajeria`),
  KEY `fk_mensajeria_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mensajeria`
--

INSERT INTO `mensajeria` (`id_mensajeria`, `mensajes`, `usuario_correo`, `usuario_rol_id_rol`) VALUES
(1, 'Por favor construyan bien el sitio', 'aasd@gmail.com', 1),
(2, 'actualizar inventario de productos de hombre', 'gtdfh@gmail.com', 1),
(3, 'Cuando viene el siguiente pedido?', 'qwerty@gmail.com', 1),
(4, 'Cuando vienen las plataformas', 'qwhijk@gmail.com', 1),
(5, 'Muy buen sitio', 'sfdryy@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

DROP TABLE IF EXISTS `municipio`;
CREATE TABLE IF NOT EXISTS `municipio` (
  `id_municipio` int(11) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `departamento_id_departamento` int(11) NOT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `fk_municipio_departamento1_idx` (`departamento_id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_municipio`, `municipio`, `departamento_id_departamento`) VALUES
(1, 'Ahuachapan', 1),
(2, 'Apaneca', 1),
(3, 'Atiquizaya', 1),
(4, 'Concepcion de Ataco', 1),
(5, 'El Refugio', 1),
(6, 'Guaymango', 1),
(7, 'Jujutla', 1),
(8, 'San Francisco Menendez', 1),
(9, 'San Lorenzo', 1),
(10, 'San Pedro Puxtla', 1),
(11, 'Tacuba', 1),
(12, 'Turin', 1),
(13, 'Cinquera', 2),
(14, 'Dolores/Villa Dolores', 2),
(15, 'Guacotecti', 2),
(16, 'Ilobasco', 2),
(17, 'Jutiapa', 2),
(18, 'San Isidro', 2),
(19, 'Sensutepeque', 2),
(20, 'Tejutepeque', 2),
(21, 'Victoria', 2),
(22, 'Agua caliente', 3),
(23, 'Arcatao', 3),
(24, 'Azacualpa', 3),
(25, 'Chalatenango', 3),
(26, 'Citala', 3),
(27, 'Comalapa', 3),
(28, 'Concepcion Quetzaltepeque', 3),
(29, 'Dulce nombre de Maria', 3),
(30, 'El Carrizal', 3),
(31, 'El Paraiso', 3),
(32, 'La Laguna', 3),
(33, 'La Palma', 3),
(34, 'La Reina', 3),
(35, 'Las Vueltas', 3),
(36, 'Nombre de Jesus', 3),
(37, 'Nueva Concepcion', 3),
(38, 'Nueva Trinidad', 3),
(39, 'Ojos de Agua', 3),
(40, 'Potonico', 3),
(41, 'San Antonio de la Cruz', 3),
(42, 'San Antonio de los Ranchos', 3),
(43, 'San Fernando', 3),
(44, 'San Francisco Lempa', 3),
(45, 'San Francisco Morazan', 3),
(46, 'San Ignasio', 3),
(47, 'San Isidro Labrador', 3),
(48, 'San Jose Cancasque / Cancasque', 3),
(49, 'San Jose Las Flores / Las Flores', 3),
(50, 'San Luis del Carmen', 3),
(51, 'San Miguel de Mercedes', 3),
(52, 'San Rafael', 3),
(53, 'Santa rita', 3),
(54, 'tejutla', 3),
(55, 'candelaria', 4),
(56, 'Cojutepeque', 4),
(57, 'El carmen', 4),
(58, 'El Rosario', 4),
(59, 'Monte San Juan', 4),
(60, 'Oratorio de concepcion', 4),
(61, 'San Bartolome Perulapia', 4),
(62, 'San Cristobal', 4),
(63, 'San Jose Guayabal', 4),
(64, 'San Pedro Perulapan', 4),
(65, 'San Rafael Cedros', 4),
(69, 'San Ramon', 4),
(70, 'Santa Cruz Analquito', 4),
(71, 'Santa Cruz Michapa', 4),
(72, 'Suchitoto', 4),
(73, 'tenancingo', 4),
(74, 'Antiguo Cuscatlan', 5),
(75, 'Chiltiupan', 5),
(76, 'Ciudad Arce', 5),
(77, 'Colon', 5),
(78, 'Comasagua', 5),
(79, 'Huizucar', 5),
(80, 'jayaque', 5),
(81, 'jicalapa', 5),
(82, 'La Libertad', 5),
(83, 'Santa Tecla', 5),
(84, 'Nuevo Cuscatlan', 5),
(85, 'San Juan Opico', 5),
(86, 'Quezaltepeque', 5),
(87, 'Sacacoyo', 5),
(88, 'San Jose Villanueva', 5),
(89, 'San Matias', 5),
(90, 'San Pablo Tacachico', 5),
(91, 'Talnique', 5),
(92, 'Tamanique', 5),
(93, 'Teotepeque', 5),
(94, 'Tepecoyo', 5),
(95, 'Zaragoza', 5),
(96, 'Cuyultitan', 6),
(97, 'El Rosario/Rosario de la paz', 6),
(98, 'Jerusalen', 6),
(99, 'Mercedes la ceiba', 6),
(100, 'Olocuilta', 6),
(101, 'Paraiso de Osorio', 6),
(102, 'San Antonio Masahuat', 6),
(103, 'San Emigdio', 6),
(104, 'San Francisco Chinameca', 6),
(105, 'San Juan Nonualco', 6),
(106, 'San Juan Talpa', 6),
(107, 'San Miguel Tepezontes', 6),
(108, 'San Pedro Masahuat', 6),
(109, 'San Pedro Nonualco', 6),
(110, 'San Rafael Obrajuelo', 6),
(111, 'Santa maria ostuma', 6),
(112, 'Santiago nonualco', 6),
(113, 'Tapalhuaca', 6),
(114, 'Zacatecoluca', 6),
(115, 'Anamoros', 7),
(116, 'Bolivar', 7),
(117, 'Concepcion de oriente', 7),
(118, 'Conchagua', 7),
(119, 'El Carmen', 7),
(120, 'El Sauce', 7),
(121, 'Intipuca', 7),
(122, 'La Union', 7),
(123, 'Lilisque', 7),
(124, 'Meanguera del Golfo', 7),
(125, 'Nueva Esparta', 7),
(126, 'Pasaquina', 7),
(127, 'Poloros', 7),
(128, 'San Alejo', 7),
(129, 'San Jose', 7),
(130, 'Santa Rosa de Lima', 7),
(131, 'Yayantique', 7),
(132, 'Yucuaiquin', 7),
(133, 'Arambala', 8),
(134, 'Cacaopera', 8),
(135, 'Chilanga', 8),
(136, 'Corinto', 8),
(137, 'Delicias de Concepcion', 8),
(138, 'El Divisadero', 8),
(139, 'El Rosario', 8),
(140, 'Gualococti', 8),
(141, 'Guatajiagua', 8),
(142, 'Joateca', 8),
(143, 'Jocoaitique', 8),
(144, 'Jocoro', 8),
(145, 'Lolotiquillo', 8),
(146, 'Meanguera', 8),
(147, 'Osicala', 8),
(148, 'Perquin', 8),
(149, 'San Carlos', 8),
(150, 'San Fernando', 8),
(151, 'San Francisco Gotera', 8),
(152, 'San Isidro', 8),
(153, 'San Simon', 8),
(154, 'Sensembra', 8),
(155, 'Sociedad', 8),
(156, 'Torola', 8),
(157, 'Yamabal', 8),
(158, 'Yoloaiquin', 8),
(159, 'Candelaria de la Frontera', 9),
(160, 'Chalchuapa', 9),
(161, 'Coatepeque', 9),
(162, 'El Congo', 9),
(163, 'El Porvenir', 9),
(164, 'Masahuat', 9),
(165, 'Metapan', 9),
(166, 'San Antonio Pajonal', 9),
(167, 'San Sebastian Salitrillo', 9),
(168, 'Santa Ana', 9),
(169, 'Santa Rosa Guachipilin', 9),
(170, 'Santiago de la Frontera', 9),
(171, 'Texistepeque', 9),
(172, 'Carolina', 10),
(173, 'chapeltipeque', 10),
(174, 'Chinameca', 10),
(175, 'Chirilagua', 10),
(176, 'Ciudad barrios', 10),
(177, 'Comacaran', 10),
(178, 'El Transito', 10),
(179, 'Lolotique', 10),
(180, 'Moncagua', 10),
(181, 'Nueva Guadalupe', 10),
(182, 'Nuevo Eden de San Juan', 10),
(183, 'Quelepa', 10),
(184, 'San Antonio del Mosco', 10),
(185, 'San Gerardo', 10),
(186, 'San Jorge', 10),
(187, 'San Luis de la Reina', 10),
(188, 'San Miguel', 10),
(189, 'San Rafael Oriente', 10),
(190, 'Sesori', 10),
(191, 'Uluazapa', 10),
(192, 'Aguilares', 11),
(193, 'Apopa', 11),
(194, 'Ayutuxtepeque', 11),
(195, 'Delgado', 11),
(196, 'Cuscatancingo', 11),
(197, 'El Paisnal', 11),
(198, 'Guazapa', 11),
(199, 'Ilopango', 11),
(200, 'Mejicanos', 11),
(201, 'Nejapa', 11),
(202, 'Panchimalco', 11),
(203, 'Rosario de Mora', 11),
(204, 'San Marcos', 11),
(205, 'San Martin', 11),
(206, 'San Salvador', 11),
(207, 'Santiago Texacuangos', 11),
(208, 'Santo Tomas', 11),
(209, 'Soyapango', 11),
(210, 'Tonacatepeque', 11),
(211, 'Apastepeque', 12),
(212, 'guadalupe', 12),
(213, 'San Cayetano Istepeque', 12),
(214, 'San Esteban Catarina', 12),
(215, 'San Ildefonso', 12),
(216, 'San Lorenzo', 12),
(217, 'San Sebastian', 12),
(218, 'San Vicente', 12),
(219, 'Santa Clara', 12),
(220, 'Santo Domingo', 12),
(221, 'Tecoluca', 12),
(222, 'Tepetitan', 12),
(223, 'Verapaz', 12),
(224, 'Acajutla', 13),
(225, 'Armenia', 13),
(226, 'Caluco', 13),
(227, 'Cuisnahuat', 13),
(228, 'Izalco', 13),
(229, 'Juayua', 13),
(230, 'Nahuizalco', 13),
(231, 'Nahuilingo', 13),
(232, 'Salcoatitan', 13),
(233, 'San Antonio del Monte', 13),
(234, 'San Julian', 13),
(235, 'Santa Catarina Masahuat', 13),
(236, 'Santa Isabel Ishuatan', 13),
(237, 'Santo Domingo de Guzman', 13),
(238, 'Sonsonate', 13),
(239, 'Sonzacate', 13),
(240, 'Alegria', 14),
(241, 'Berlin', 14),
(242, 'california', 14),
(243, 'Concepcion Batres', 14),
(244, 'El Triunfo', 14),
(245, 'Ereguayquin', 14),
(246, 'Estanzuelas', 14),
(247, 'Jiquilisco', 14),
(248, 'Jucuapa', 14),
(249, 'Jucuaran', 14),
(250, 'Mercedes Umana', 14),
(251, 'Nueva Granada', 14),
(252, 'Ozatlan', 14),
(253, 'Puerto el Triunfo', 14),
(254, 'San Agustin', 14),
(255, 'San Buenaventura', 14),
(256, 'San Dionisio', 14),
(257, 'San Francisco Javier', 14),
(258, 'Santa Elena', 14),
(259, 'Santa Maria', 14),
(260, 'Santiago de Maria', 14),
(261, 'Tecapan', 14),
(262, 'Usulutan', 14);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `municipios_disponibles`
--
DROP VIEW IF EXISTS `municipios_disponibles`;
CREATE TABLE IF NOT EXISTS `municipios_disponibles` (
`Id departamento` int(11)
,`Departamento` varchar(45)
,`Municipio` varchar(45)
,`Id Municipio` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

DROP TABLE IF EXISTS `orden`;
CREATE TABLE IF NOT EXISTS `orden` (
  `id_orden` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `total` varchar(45) NOT NULL,
  `usuario_correo` varchar(45) NOT NULL,
  `usuario_rol_id_rol` int(11) NOT NULL,
  `costo_envio_id_costo` int(11) NOT NULL,
  PRIMARY KEY (`id_orden`,`usuario_correo`,`usuario_rol_id_rol`,`costo_envio_id_costo`),
  KEY `fk_orden_usuario1_idx` (`usuario_correo`,`usuario_rol_id_rol`),
  KEY `fk_orden_costo_envio1_idx` (`costo_envio_id_costo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id_orden`, `fecha`, `total`, `usuario_correo`, `usuario_rol_id_rol`, `costo_envio_id_costo`) VALUES
(1, '2017-08-17', '100', 'aasd@gmail.com', 1, 7);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pagos`
--
DROP VIEW IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
`Usuario` varchar(45)
,`Rol en el sistema` varchar(45)
,`Forma de pago` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pagos_paypal`
--
DROP VIEW IF EXISTS `pagos_paypal`;
CREATE TABLE IF NOT EXISTS `pagos_paypal` (
`Usuario` varchar(45)
,`Monto de pago en dólares` int(11)
,`Tipo pago` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pago_tarjeta_credito`
--
DROP VIEW IF EXISTS `pago_tarjeta_credito`;
CREATE TABLE IF NOT EXISTS `pago_tarjeta_credito` (
`id_tdc` int(11)
,`TITULAR` varchar(45)
,`TDC` int(16)
,`EXPIRACION` int(4)
,`CCV` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paypal`
--

DROP TABLE IF EXISTS `paypal`;
CREATE TABLE IF NOT EXISTS `paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(45) NOT NULL,
  `monto` int(11) NOT NULL,
  `forma_pago_id_tipo_pago` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_PAYPAL_forma_pago1_idx` (`forma_pago_id_tipo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paypal`
--

INSERT INTO `paypal` (`id`, `correo`, `monto`, `forma_pago_id_tipo_pago`) VALUES
(1, 'kcortez@hotmail.com', 10, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `pedidos`
--
DROP VIEW IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
`Fecha de la orden` date
,`Total en dólares` varchar(45)
,`Usuario` varchar(45)
,`Rol en el sistema` varchar(45)
,`Costo unitario` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `precio` int(11) NOT NULL,
  `descripción` varchar(45) NOT NULL,
  `imagen` varchar(60) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descuento` int(11) DEFAULT NULL,
  `proveedor_id_proveedor` int(11) NOT NULL,
  `talla_id_talla` int(11) NOT NULL,
  `color_id_color` int(11) NOT NULL,
  `categoria_id_categoria` int(11) NOT NULL,
  `marca_id_marca` int(11) NOT NULL,
  PRIMARY KEY (`id_producto`,`categoria_id_categoria`,`marca_id_marca`),
  KEY `fk_producto_proveedor1_idx` (`proveedor_id_proveedor`),
  KEY `fk_producto_talla1_idx` (`talla_id_talla`),
  KEY `fk_producto_color1_idx` (`color_id_color`),
  KEY `fk_producto_categoria1_idx` (`categoria_id_categoria`),
  KEY `fk_producto_marca1_idx` (`marca_id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `precio`, `descripción`, `imagen`, `nombre`, `descuento`, `proveedor_id_proveedor`, `talla_id_talla`, `color_id_color`, `categoria_id_categoria`, `marca_id_marca`) VALUES
(1, 30, 'zapatos deportivos', 'no hay', 'Total 90', 1, 1, 1, 2, 2, 2),
(2, 30, 'Plataformas de señorita', 'no hay', 'Elizabeth', 1, 1, 3, 3, 1, 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_con_descuento`
--
DROP VIEW IF EXISTS `productos_con_descuento`;
CREATE TABLE IF NOT EXISTS `productos_con_descuento` (
`Nombre de promoción` varchar(45)
,`Descripción de descuento` varchar(45)
,`Porcentaje de descuento` double
);

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `empresa` varchar(45) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `apellido`, `empresa`, `telefono`, `correo`) VALUES
(1, 'Mario', 'Casas', 'ADOC', 71426985, 'correo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(45) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `cargo`) VALUES
(1, 'usuario'),
(2, 'Administrador'),
(4, 'Pinserta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategoria`
--

DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `categoria_id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_categoria`),
  KEY `fk_subcategoria_categoria1_idx` (`categoria_id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subcategoria`
--

INSERT INTO `subcategoria` (`id_categoria`, `nombre`, `descripcion`, `categoria_id_categoria`) VALUES
(1, 'Sneakers', 'Zapatos deportivos', 1),
(2, 'Sandalias', 'calzado de verano', 1),
(3, 'Sneakers', 'Zapatos deportivos', 2),
(4, 'Botas', 'Botas y botines', 2),
(5, 'Sandalias', 'calzado de verano', 5),
(6, 'Sneakers', 'Zapatos deportivos', 5),
(7, 'Sneakers', 'Zapatos informales', 4),
(8, 'Frogs', 'Para estar en casa', 4),
(9, 'Botas', 'Botas y botines', 3),
(10, 'Formales', 'Zapatos para ocasiones especiales', 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `subcategorias_productos`
--
DROP VIEW IF EXISTS `subcategorias_productos`;
CREATE TABLE IF NOT EXISTS `subcategorias_productos` (
`Categoria` varchar(45)
,`Sub Categoria` varchar(45)
,`Descripción` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `sugerencias`
--
DROP VIEW IF EXISTS `sugerencias`;
CREATE TABLE IF NOT EXISTS `sugerencias` (
`Usuario` varchar(45)
,`Rol en el sistema` varchar(45)
,`Mensajes recibidos` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talla`
--

DROP TABLE IF EXISTS `talla`;
CREATE TABLE IF NOT EXISTS `talla` (
  `id_talla` int(11) NOT NULL AUTO_INCREMENT,
  `medida` double(3,1) NOT NULL,
  PRIMARY KEY (`id_talla`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `talla`
--

INSERT INTO `talla` (`id_talla`, `medida`) VALUES
(1, 8.0),
(3, 6.0),
(9, 7.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta_credito`
--

DROP TABLE IF EXISTS `tarjeta_credito`;
CREATE TABLE IF NOT EXISTS `tarjeta_credito` (
  `id_tdc` int(11) NOT NULL AUTO_INCREMENT,
  `numero_tdc` int(16) NOT NULL,
  `fecha_expiracion` int(4) NOT NULL,
  `CCV2` int(11) NOT NULL,
  `nombre_titular` varchar(45) NOT NULL,
  `forma_pago_id_tipo_pago` int(11) NOT NULL,
  PRIMARY KEY (`id_tdc`),
  KEY `fk_tarjeta_credito_forma_pago1_idx` (`forma_pago_id_tipo_pago`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tarjeta_credito`
--

INSERT INTO `tarjeta_credito` (`id_tdc`, `numero_tdc`, `fecha_expiracion`, `CCV2`, `nombre_titular`, `forma_pago_id_tipo_pago`) VALUES
(1, 10254897, 1228, 123, 'Jorge Rivas', 1),
(3, 288888, 917, 456, 'jose', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_descuento`
--

DROP TABLE IF EXISTS `tipo_descuento`;
CREATE TABLE IF NOT EXISTS `tipo_descuento` (
  `id_tipo_descuento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_descuento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_descuento`
--

INSERT INTO `tipo_descuento` (`id_tipo_descuento`, `descripcion`) VALUES
(1, 'Cupón de descuento'),
(2, 'Código de descuento'),
(3, 'Primera compra'),
(4, 'Segundo a mitad de precio'),
(5, 'Liquidación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  `rol_id_rol` int(11) NOT NULL,
  PRIMARY KEY (`correo`,`rol_id_rol`),
  KEY `fk_usuario_rol1_idx` (`rol_id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`correo`, `contrasena`, `nombre`, `apellido`, `estado`, `rol_id_rol`) VALUES
('aasd@gmail.com', '1234', 'carlos', 'aguilar', 1, 1),
('gtdfh@gmail.com', '1587', 'luis', 'barrera', 1, 1),
('qwerty@gmail.com', '123456', 'Kelly', 'Cortez', 1, 1),
('qwhijk@gmail.com', 'qwerty', 'maria', 'perez', 1, 1),
('sfdryy@gmail.com', '63789', 'ana', 'funes', 1, 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `colores_productos`
--
DROP TABLE IF EXISTS `colores_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `colores_productos`  AS  select `color`.`id_color` AS `Id color`,`color`.`descripcion` AS `color`,`marca`.`marca` AS `Marca`,`producto`.`precio` AS `Precio` from ((`color` join `producto`) join `marca`) where (`producto`.`color_id_color` = `color`.`id_color`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `costo_envio_producto`
--
DROP TABLE IF EXISTS `costo_envio_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `costo_envio_producto`  AS  select `d`.`departamento` AS `Departamento de envío`,`ce`.`costo` AS `Costo en dólares` from (`costo_envio` `ce` join `departamento` `d` on((`ce`.`departamento_id_departamento` = `d`.`id_departamento`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `datos_administrados`
--
DROP TABLE IF EXISTS `datos_administrados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datos_administrados`  AS  select `a`.`nombre` AS `Nombre`,`a`.`apellido` AS `Apellido`,`a`.`correo` AS `email`,`a`.`contraseña` AS `Contraseña`,`a`.`telefono` AS `Teléfono`,`a`.`cargo` AS `Rol en sistema`,`a`.`estado` AS `Estado de usuario`,`r`.`cargo` AS `Cargo en empresa`,`de`.`nombre_empresa` AS `Nombre empresa` from ((`dato_empresa` `de` join `admin` `a` on((`de`.`id_dato` = `a`.`dato_empresa_id_dato`))) join `rol` `r` on((`r`.`id_rol` = `a`.`rol_id_rol`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `datos_usuario`
--
DROP TABLE IF EXISTS `datos_usuario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datos_usuario`  AS  select `usuario`.`correo` AS `email`,`usuario`.`contrasena` AS `Contraseña`,`usuario`.`nombre` AS `Nombre`,`usuario`.`apellido` AS `Apellido`,`usuario`.`estado` AS `Estado de usuario`,`rol`.`cargo` AS `Rol en sistema` from (`rol` join `usuario` on((`rol`.`id_rol` = `usuario`.`rol_id_rol`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `direccion_envio_producto`
--
DROP TABLE IF EXISTS `direccion_envio_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `direccion_envio_producto`  AS  select `u`.`correo` AS `email`,`u`.`nombre` AS `Nombre`,`u`.`apellido` AS `Apellido`,`r`.`cargo` AS `Rol en sistema`,`dr`.`telefono` AS `Teléfono`,`dr`.`codigo_postal` AS `Código postal`,`dr`.`direccion` AS `Dirección`,`d`.`departamento` AS `Departamento` from (((`usuario` `u` join `direccion_envio` `dr` on((`u`.`correo` = `dr`.`usuario_correo`))) join `rol` `r` on((`r`.`id_rol` = `dr`.`usuario_rol_id_rol`))) join `departamento` `d` on((`d`.`id_departamento` = `dr`.`departamento_id_departamento`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `direccion_facturacion_producto`
--
DROP TABLE IF EXISTS `direccion_facturacion_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `direccion_facturacion_producto`  AS  select `df`.`nombre` AS `Nombre`,`df`.`apellido` AS `Apellido`,`df`.`telefono` AS `Teléfono`,`df`.`correo` AS `email`,`df`.`direccion` AS `Direccion`,`d`.`departamento` AS `Departamento`,`u`.`correo` AS `email de usuario registrado`,`r`.`cargo` AS `Rol en el sistema` from (((`direccion_facturacion` `df` join `departamento` `d` on((`df`.`departamento_id_departamento` = `d`.`id_departamento`))) join `usuario` `u` on((`df`.`usuario_correo` = `u`.`correo`))) join `rol` `r` on((`df`.`usuario_rol_id_rol` = `r`.`id_rol`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `existencias_producto`
--
DROP TABLE IF EXISTS `existencias_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `existencias_producto`  AS  select `e`.`cantidad` AS `Cantidad`,`p`.`nombre` AS `Marca` from (`existencia` `e` join `producto` `p` on((`e`.`producto_id_producto` = `p`.`id_producto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `municipios_disponibles`
--
DROP TABLE IF EXISTS `municipios_disponibles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `municipios_disponibles`  AS  select `departamento`.`id_departamento` AS `Id departamento`,`departamento`.`departamento` AS `Departamento`,`municipio`.`municipio` AS `Municipio`,`municipio`.`departamento_id_departamento` AS `Id Municipio` from (`departamento` join `municipio`) where (`departamento`.`id_departamento` = `municipio`.`departamento_id_departamento`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pagos`
--
DROP TABLE IF EXISTS `pagos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pagos`  AS  select `f`.`usuario_correo` AS `Usuario`,`r`.`cargo` AS `Rol en el sistema`,`f`.`tipo_pago` AS `Forma de pago` from (`forma_pago` `f` join `rol` `r` on((`f`.`usuario_rol_id_rol` = `r`.`id_rol`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pagos_paypal`
--
DROP TABLE IF EXISTS `pagos_paypal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pagos_paypal`  AS  select `p`.`correo` AS `Usuario`,`p`.`monto` AS `Monto de pago en dólares`,`f`.`tipo_pago` AS `Tipo pago` from (`paypal` `p` join `forma_pago` `f` on((`p`.`forma_pago_id_tipo_pago` = `f`.`id_tipo_pago`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pago_tarjeta_credito`
--
DROP TABLE IF EXISTS `pago_tarjeta_credito`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pago_tarjeta_credito`  AS  select `t`.`id_tdc` AS `id_tdc`,`t`.`nombre_titular` AS `TITULAR`,`t`.`numero_tdc` AS `TDC`,`t`.`fecha_expiracion` AS `EXPIRACION`,`t`.`CCV2` AS `CCV` from (`tarjeta_credito` `t` join `forma_pago` `f` on((`t`.`forma_pago_id_tipo_pago` = `f`.`id_tipo_pago`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `pedidos`
--
DROP TABLE IF EXISTS `pedidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedidos`  AS  select `o`.`fecha` AS `Fecha de la orden`,`o`.`total` AS `Total en dólares`,`o`.`usuario_correo` AS `Usuario`,`r`.`cargo` AS `Rol en el sistema`,`c`.`costo` AS `Costo unitario` from ((`orden` `o` join `rol` `r` on((`o`.`usuario_rol_id_rol` = `r`.`id_rol`))) join `costo_envio` `c` on((`o`.`costo_envio_id_costo` = `c`.`id_costo`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_con_descuento`
--
DROP TABLE IF EXISTS `productos_con_descuento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_con_descuento`  AS  select `p`.`nombre` AS `Nombre de promoción`,`td`.`descripcion` AS `Descripción de descuento`,`d`.`porcentaje` AS `Porcentaje de descuento` from ((`descuento` `d` join `tipo_descuento` `td` on((`d`.`tipo_descuento_id_tipo_descuento` = `td`.`id_tipo_descuento`))) join `producto` `p` on((`d`.`producto_id_producto` = `p`.`id_producto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_registrados`
--
DROP TABLE IF EXISTS `productos_registrados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_registrados`  AS  select `p`.`nombre` AS `Modelo`,`p`.`imagen` AS `Imagen`,`p`.`precio` AS `Precio unitario`,`p`.`descripción` AS `Descripción`,`po`.`empresa` AS `Proveedor`,`t`.`medida` AS `Talla`,`c`.`descripcion` AS `Color`,`ca`.`nombre` AS `Categoría`,`m`.`marca` AS `Marca` from (((((`producto` `p` join `proveedor` `po` on((`p`.`proveedor_id_proveedor` = `po`.`id_proveedor`))) join `talla` `t` on((`p`.`talla_id_talla` = `t`.`id_talla`))) join `color` `c` on((`p`.`color_id_color` = `c`.`id_color`))) join `categoria` `ca` on((`p`.`categoria_id_categoria` = `ca`.`id_categoria`))) join `marca` `m` on((`p`.`marca_id_marca` = `m`.`id_marca`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `subcategorias_productos`
--
DROP TABLE IF EXISTS `subcategorias_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `subcategorias_productos`  AS  select `c`.`nombre` AS `Categoria`,`s`.`nombre` AS `Sub Categoria`,`s`.`descripcion` AS `Descripción` from (`subcategoria` `s` join `categoria` `c` on((`s`.`categoria_id_categoria` = `c`.`id_categoria`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `sugerencias`
--
DROP TABLE IF EXISTS `sugerencias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sugerencias`  AS  select `m`.`usuario_correo` AS `Usuario`,`r`.`cargo` AS `Rol en el sistema`,`m`.`mensajes` AS `Mensajes recibidos` from (`mensajeria` `m` join `rol` `r` on((`m`.`usuario_rol_id_rol` = `r`.`id_rol`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_dato_empresa1` FOREIGN KEY (`dato_empresa_id_dato`) REFERENCES `dato_empresa` (`id_dato`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_admin_rol1` FOREIGN KEY (`rol_id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_detalle_orden_orden1` FOREIGN KEY (`orden_id_orden`) REFERENCES `orden` (`id_orden`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_orden_producto1` FOREIGN KEY (`producto_id_producto`,`producto_categoria_id_categoria`,`producto_marca_id_marca`) REFERENCES `producto` (`id_producto`, `categoria_id_categoria`, `marca_id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_comentario_producto1` FOREIGN KEY (`producto_id_producto`,`producto_categoria_id_categoria`,`producto_marca_id_marca`) REFERENCES `producto` (`id_producto`, `categoria_id_categoria`, `marca_id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentario_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `costo_envio`
--
ALTER TABLE `costo_envio`
  ADD CONSTRAINT `fk_costo_envio_departamento1` FOREIGN KEY (`departamento_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD CONSTRAINT `fk_descuento_producto1` FOREIGN KEY (`producto_id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_descuento_tipo_descuento1` FOREIGN KEY (`tipo_descuento_id_tipo_descuento`) REFERENCES `tipo_descuento` (`id_tipo_descuento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `fk_devolucion_orden1` FOREIGN KEY (`orden_id_orden`,`orden_usuario_correo`,`orden_usuario_rol_id_rol`) REFERENCES `orden` (`id_orden`, `usuario_correo`, `usuario_rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  ADD CONSTRAINT `fk_direccion_envio_departamento1` FOREIGN KEY (`departamento_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_direccion_envio_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direccion_facturacion`
--
ALTER TABLE `direccion_facturacion`
  ADD CONSTRAINT `fk_direccion_facturacion_departamento1` FOREIGN KEY (`departamento_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_direccion_facturacion_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `existencia`
--
ALTER TABLE `existencia`
  ADD CONSTRAINT `fk_existencia_producto1` FOREIGN KEY (`producto_id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `forma_pago`
--
ALTER TABLE `forma_pago`
  ADD CONSTRAINT `fk_forma_pago_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD CONSTRAINT `fk_mensajeria_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_departamento1` FOREIGN KEY (`departamento_id_departamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `fk_orden_costo_envio1` FOREIGN KEY (`costo_envio_id_costo`) REFERENCES `costo_envio` (`id_costo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_orden_usuario1` FOREIGN KEY (`usuario_correo`,`usuario_rol_id_rol`) REFERENCES `usuario` (`correo`, `rol_id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paypal`
--
ALTER TABLE `paypal`
  ADD CONSTRAINT `fk_PAYPAL_forma_pago1` FOREIGN KEY (`forma_pago_id_tipo_pago`) REFERENCES `forma_pago` (`id_tipo_pago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_color1` FOREIGN KEY (`color_id_color`) REFERENCES `color` (`id_color`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_marca1` FOREIGN KEY (`marca_id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_proveedor1` FOREIGN KEY (`proveedor_id_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_talla1` FOREIGN KEY (`talla_id_talla`) REFERENCES `talla` (`id_talla`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `fk_subcategoria_categoria1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tarjeta_credito`
--
ALTER TABLE `tarjeta_credito`
  ADD CONSTRAINT `fk_tarjeta_credito_forma_pago1` FOREIGN KEY (`forma_pago_id_tipo_pago`) REFERENCES `forma_pago` (`id_tipo_pago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol1` FOREIGN KEY (`rol_id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
