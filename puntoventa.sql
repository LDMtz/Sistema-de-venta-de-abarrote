-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2023 a las 15:56:21
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `puntoventa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `IdCaja` int(11) NOT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `MontoActual` double DEFAULT 0,
  `FechaHoraApertura` datetime DEFAULT current_timestamp(),
  `EmpleadoApertura` int(11) DEFAULT NULL,
  `MontoApertura` double DEFAULT 0,
  `FechaHoraCierre` datetime DEFAULT NULL,
  `EmpleadoCierre` int(11) DEFAULT NULL,
  `MontoCierre` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`IdCaja`, `Estado`, `MontoActual`, `FechaHoraApertura`, `EmpleadoApertura`, `MontoApertura`, `FechaHoraCierre`, `EmpleadoCierre`, `MontoCierre`) VALUES
(1, 0, 0, '2023-11-17 23:40:00', 58, 200, '2023-11-19 05:13:17', 58, 4344.45),
(8, 0, 0, '2023-11-19 01:32:19', 62, 1200.34, '2023-11-19 18:34:28', 62, 4334.34),
(9, 0, 0, '2023-11-19 01:47:56', 58, 500, '2023-11-19 02:39:33', 58, 4535.34),
(11, 0, 0, '2023-11-19 19:05:40', 62, 300.43, '2023-11-19 19:37:37', 62, 300.43),
(12, 0, 0, '2023-11-19 19:42:47', 63, 340.34, '2023-11-25 00:49:29', 58, 0),
(16, 0, 0, '2023-11-25 00:50:01', 58, 123.42, '2023-11-25 23:03:01', 62, 123.42),
(17, 0, 0, '2023-11-25 23:03:13', 62, 432.43, '2023-11-28 07:45:11', 58, 468.43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IdCategoria` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `FechaRegistro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategoria`, `Nombre`, `FechaRegistro`) VALUES
(1, 'LACTEOS', '2023-10-22'),
(2, 'REFRESCOS', '2023-10-22'),
(3, 'ALIMENTOS ENLATADOS', '2023-10-22'),
(4, 'SABRITAS', '2023-10-22'),
(5, 'GALLETAS', '2023-10-22'),
(6, 'HIGIENE Y LIMPIEZA', '2023-10-22'),
(9, 'BEBIDAS ALCOHOLICAS', '2023-10-22'),
(10, 'AGUA', '2023-10-22'),
(11, 'DULCES', '2023-10-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `IdCliente` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Telefono` varchar(10) DEFAULT NULL,
  `FechaRegistro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`IdCliente`, `Nombre`, `Correo`, `Telefono`, `FechaRegistro`) VALUES
(1, 'Manuel Camacho', 'manuel@gmail.com', '1234567890', '2023-10-20'),
(2, 'Daniela Angulo', 'daniela@gmail.com', '1234567890', '2023-10-20'),
(15, 'Martin Romero', 'martinr@gmail.com', '1234567890', '2023-11-10'),
(16, 'Yahir Dominguez', 'yhr@gmail.com', '1234567890', '2023-11-10'),
(17, 'Jairo Gonzalez', 'jairo@gmail.com', '1234567890', '2023-11-10'),
(18, 'Fidel Lopez', 'fidel@gmail.com', '1234567890', '2023-11-10'),
(19, 'Rosa Gonzalez', 'rosa@gmail.com', '1234567890', '2023-11-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `IdDetalleVenta` int(11) NOT NULL,
  `IdVenta` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioUnitario` double NOT NULL,
  `DescuentoUnitario` double DEFAULT 0,
  `Subtotal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `IdEmpleado` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Clave` varchar(50) NOT NULL,
  `Foto` varchar(255) NOT NULL,
  `IdRol` int(11) NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `FechaRegistro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`IdEmpleado`, `Nombre`, `Correo`, `Telefono`, `Clave`, `Foto`, `IdRol`, `Estado`, `FechaRegistro`) VALUES
(58, 'Leoncio Martinez', 'leomtz@gmail.com', '1234567890', '123', '1697624197_default-user.png', 1, 1, '2023-10-12'),
(62, 'Javier Zamudio', 'javier123@gmail.com', '6674093426', '123', '1697436190_foto5.jpg', 2, 1, '2023-10-12'),
(63, 'Raul Lopez', 'raulillo@gmail.com', '6671985689', '123', '1697436594_foto6.jpg', 1, 0, '2023-10-12'),
(110, 'Juan Gonzalez', 'juanito@gmail.com', '1234567890', '1', '1697715090_foto3.jpg', 2, 1, '2023-10-19'),
(111, 'Maria Rodriguez', 'mr@gmail.com', '1234567890', '1', '1697715120_foto4.jpg', 2, 1, '2023-10-19'),
(116, 'Manuel Torres', 'manuel@gmail.com', '1234567890', '1', '1699665778_defaultCopy.png', 2, 0, '2023-11-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_caja`
--

CREATE TABLE `movimiento_caja` (
  `IdMov` int(11) NOT NULL,
  `IdCaja` int(11) DEFAULT NULL,
  `TipoMov` int(11) DEFAULT NULL,
  `MontoMov` double NOT NULL,
  `FechaHoraMov` datetime DEFAULT current_timestamp(),
  `EmpleadoMov` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `IdProducto` int(11) NOT NULL,
  `CodigoBarras` varchar(50) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(250) DEFAULT NULL,
  `Existencias` int(11) DEFAULT 0,
  `PrecioCompra` double DEFAULT 0,
  `PrecioVenta` double DEFAULT 0,
  `IdCategoria` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `Estado` tinyint(1) DEFAULT NULL,
  `Foto` varchar(255) DEFAULT NULL,
  `FechaRegistro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`IdProducto`, `CodigoBarras`, `Nombre`, `Descripcion`, `Existencias`, `PrecioCompra`, `PrecioVenta`, `IdCategoria`, `IdProveedor`, `Estado`, `Foto`, `FechaRegistro`) VALUES
(1, '7501000153107', 'Gansito', '50g', 26, 15, 18.99, 5, 8, 1, '1700133996_Gansito.png', '2023-10-24'),
(2, '0757528040246', 'Takis Fuego', '200gr', 21, 13.4, 15.36, 4, 1, 1, '1698178481_takis_fuego.png', '2023-10-24'),
(3, '7501055320639', 'Coca Cola', '600 ml', 20, 14.5, 18, 2, 4, 1, '1698301690_coca600.png', '2023-10-25'),
(6, '7501000626489', 'Emperador Chocolate', '150 gr', 25, 13.3, 18.4, 5, 2, 1, '1698469982_emperador.png', '2023-10-27'),
(7, '7501055304721', 'Agua Ciel', '1 lt', 20, 11, 18.99, 10, 4, 1, '1700135476_aguaciel.png', '2023-10-27'),
(10, '0724869007139', 'Mazapán', '28 gr', 26, 5.99, 10, 11, 9, 0, '1698474111_mazapan.png', '2023-10-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_descuento`
--

CREATE TABLE `producto_descuento` (
  `IdDescuento` int(11) NOT NULL,
  `IdProducto` int(11) DEFAULT NULL,
  `Descuento` double NOT NULL,
  `FechaInicio` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_descuento`
--

INSERT INTO `producto_descuento` (`IdDescuento`, `IdProducto`, `Descuento`, `FechaInicio`) VALUES
(24, 1, 1.9, '2023-11-04'),
(28, 2, 1.54, '2023-11-12'),
(29, 7, 3, '2023-11-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `IdProveedor` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Telefono` varchar(10) DEFAULT NULL,
  `FechaRegistro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`IdProveedor`, `Nombre`, `Correo`, `Telefono`, `FechaRegistro`) VALUES
(1, 'Barcel', 'barcel@gmail.com', '1234567890', '2023-10-21'),
(2, 'Gamesa', 'gamesa@gmail.com', '1234567890', '2023-10-21'),
(3, 'Chata', 'chata@gmail.com', '1234567890', '2023-10-21'),
(4, 'Coca Cola', 'coca@gmail.com', '1234567890', '2023-10-21'),
(8, 'Marinela', 'marinela@gmail.com', '1234567890', '2023-10-24'),
(9, 'De la Rosa', 'dlrosa@gmail.com', '1234567890', '2023-10-27'),
(17, 'Bimbo', 'bimbo@gmail.com', '1234567890', '2023-11-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(11) NOT NULL,
  `NombreRol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IdRol`, `NombreRol`) VALUES
(1, 'Administrador'),
(2, 'Cajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mov_caja`
--

CREATE TABLE `tipo_mov_caja` (
  `IdTipoMov` int(11) NOT NULL,
  `NombreTipoMov` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_mov_caja`
--

INSERT INTO `tipo_mov_caja` (`IdTipoMov`, `NombreTipoMov`) VALUES
(1, 'Apertura de caja'),
(2, 'Cierre de caja'),
(3, 'Venta'),
(4, 'Compra'),
(5, 'Arqueo'),
(6, 'Gastos en efectivo'),
(7, 'Deposito a caja'),
(8, 'Retiro a la caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `IdVenta` int(11) NOT NULL,
  `TipoDoc` varchar(20) NOT NULL,
  `Folio` varchar(40) NOT NULL,
  `IdEmpleado` int(11) NOT NULL,
  `IdCaja` int(11) NOT NULL,
  `IdCliente` int(11) DEFAULT NULL,
  `MontoPago` double NOT NULL,
  `FechaHoraRegistro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`IdCaja`),
  ADD KEY `EmpleadoApertura` (`EmpleadoApertura`),
  ADD KEY `EmpleadoCierre` (`EmpleadoCierre`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`IdCliente`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`IdDetalleVenta`),
  ADD KEY `IdVenta` (`IdVenta`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`IdEmpleado`),
  ADD KEY `IdRol` (`IdRol`);

--
-- Indices de la tabla `movimiento_caja`
--
ALTER TABLE `movimiento_caja`
  ADD PRIMARY KEY (`IdMov`),
  ADD KEY `IdCaja` (`IdCaja`),
  ADD KEY `TipoMov` (`TipoMov`),
  ADD KEY `EmpleadoMov` (`EmpleadoMov`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`IdProducto`),
  ADD KEY `IdCategoria` (`IdCategoria`),
  ADD KEY `IdProveedor` (`IdProveedor`);

--
-- Indices de la tabla `producto_descuento`
--
ALTER TABLE `producto_descuento`
  ADD PRIMARY KEY (`IdDescuento`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `tipo_mov_caja`
--
ALTER TABLE `tipo_mov_caja`
  ADD PRIMARY KEY (`IdTipoMov`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`IdVenta`),
  ADD KEY `IdEmpleado` (`IdEmpleado`),
  ADD KEY `IdCaja` (`IdCaja`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `IdCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `IdDetalleVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `IdEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT de la tabla `movimiento_caja`
--
ALTER TABLE `movimiento_caja`
  MODIFY `IdMov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `IdProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `producto_descuento`
--
ALTER TABLE `producto_descuento`
  MODIFY `IdDescuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `IdProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `IdRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_mov_caja`
--
ALTER TABLE `tipo_mov_caja`
  MODIFY `IdTipoMov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `IdVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`EmpleadoApertura`) REFERENCES `empleados` (`IdEmpleado`),
  ADD CONSTRAINT `caja_ibfk_2` FOREIGN KEY (`EmpleadoCierre`) REFERENCES `empleados` (`IdEmpleado`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`IdVenta`) REFERENCES `ventas` (`IdVenta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `movimiento_caja`
--
ALTER TABLE `movimiento_caja`
  ADD CONSTRAINT `movimiento_caja_ibfk_1` FOREIGN KEY (`IdCaja`) REFERENCES `caja` (`IdCaja`),
  ADD CONSTRAINT `movimiento_caja_ibfk_2` FOREIGN KEY (`TipoMov`) REFERENCES `tipo_mov_caja` (`IdTipoMov`),
  ADD CONSTRAINT `movimiento_caja_ibfk_3` FOREIGN KEY (`EmpleadoMov`) REFERENCES `empleados` (`IdEmpleado`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categorias` (`IdCategoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`IdProveedor`) REFERENCES `proveedores` (`IdProveedor`);

--
-- Filtros para la tabla `producto_descuento`
--
ALTER TABLE `producto_descuento`
  ADD CONSTRAINT `producto_descuento_ibfk_1` FOREIGN KEY (`IdProducto`) REFERENCES `productos` (`IdProducto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleados` (`IdEmpleado`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`IdCaja`) REFERENCES `caja` (`IdCaja`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`IdCliente`) REFERENCES `clientes` (`IdCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
