--
-- Base de datos: `mambo_db`
--
CREATE DATABASE IF NOT EXISTS `mambo_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mambo_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `idCategory` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`idCategory`, `name`) VALUES
(1, 'Pot'),
(2, 'Mate'),
(3, 'Tea box'),

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `idProduct` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `description` varchar(30) NOT NULL,
  `category` int(11) NOT NULL,
  `stock` int(6) NOT NULL,
  `image` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`idProduct`, `name`, `price`, `description`, `category`, `stock`, `image`) VALUES
(1, 'Yellow flower', 150.00, 'Sizes: 8, 10, 12, 14, 16', 1, 2, 'pot_1.jpg'),
(2, 'Ligthblue flower', 150.00, 'Sizes: 8, 10, 12, 14, 16', 1, 4 , 'pot_2.jpg'),
(3, 'White flower', 150.00, 'Sizes: 8, 10, 12, 14, 16', 1, 3 , 'pot_3.jpg'),
(4, 'Cute cat', 150.00, 'Sizes: 8, 10, 12, 14, 16', 1, 4 , 'pot_4.jpg'),
(5, 'Little rakoon', 150.00, 'Sizes: 8, 10, 12, 14, 16', 1, 4 , 'pot_5.jpg'),
(6, 'Pikachu', 200.00, 'Sizes: 8, 10, 12, 14, 16', 1, 4 , 'pot_6.jpg');

-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` text NOT NULL,
  `activation` text NOT NULL,
  `state` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `users` (`idUser`, `name`, `lastname`, `email`, `pass`, `activation`, `state`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$zYH5CY5M17DYsC0zPCABu.acQphxUEZFBkss/RjUhOu4j8EFlIRV.', '0d3ccb5cb418d3d648bfbc768fabd1b1', 1);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories` ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`idUser`), ADD UNIQUE KEY `email` (`email`);

--
--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories` MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products` MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users` MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`idCategory`) ON DELETE CASCADE ON UPDATE CASCADE;