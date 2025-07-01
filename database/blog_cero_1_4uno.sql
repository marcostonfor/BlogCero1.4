-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Temps de generació: 26-06-2025 a les 18:00:43
-- Versió del servidor: 8.0.42-0ubuntu0.24.04.1
-- Versió de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de dades: `blog_cero_1.4uno`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `articulos_de_post`
--

CREATE TABLE `articulos_de_post` (
    `id` int NOT NULL,
    `titulo` varchar(100) DEFAULT NULL,
    `contenido` longtext,
    `autor_id` int NOT NULL,
    `fecha` datetime DEFAULT NULL,
    `estado` tinyint DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `paginas`
--

CREATE TABLE `paginas` (
    `id` int NOT NULL,
    `nombre` varchar(100) DEFAULT NULL,
    `ruta_url` varchar(250) DEFAULT NULL,
    `subida_por_user_id` int NOT NULL,
    `fecha_subida` datetime DEFAULT NULL,
    `publicada` tinyint DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `site_config`
--

CREATE TABLE `site_config` (
    `id` int NOT NULL,
    `config_key` varchar(45) NOT NULL,
    `config_value` varchar(255) DEFAULT NULL,
    `user_id` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `social_media`
--

CREATE TABLE `social_media` (
    `id` int NOT NULL,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `clase` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
    `publicado` tinyint(1) NOT NULL DEFAULT '0',
    `user_id` int DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `users`
--

CREATE TABLE `users` (
    `id` int NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `articulos_de_post`
--
ALTER TABLE `articulos_de_post`
ADD PRIMARY KEY (`id`),
ADD KEY `fk_articulos_autor_idx` (`autor_id`);

--
-- Índexs per a la taula `paginas`
--
ALTER TABLE `paginas`
ADD PRIMARY KEY (`id`),
ADD KEY `fk_paginas_user_idx` (`subida_por_user_id`);

--
-- Índexs per a la taula `site_config`
--
ALTER TABLE `site_config`
ADD PRIMARY KEY (`id`),
ADD KEY `fk_site_config_user_idx` (`user_id`);

--
-- Índexs per a la taula `social_media`
--
ALTER TABLE `social_media`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `nombre` (`user_id`, `nombre`);

--
-- Índexs per a la taula `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `articulos_de_post`
--
ALTER TABLE `articulos_de_post`
MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `paginas`
--
ALTER TABLE `paginas` MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `site_config`
--
ALTER TABLE `site_config`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 21;

--
-- AUTO_INCREMENT per la taula `social_media`
--
ALTER TABLE `social_media`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 52;

--
-- AUTO_INCREMENT per la taula `users`
--
ALTER TABLE `users`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 3;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `articulos_de_post`
--
ALTER TABLE `articulos_de_post`
ADD CONSTRAINT `fk_articulos_autor` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `paginas`
--
ALTER TABLE `paginas`
ADD CONSTRAINT `fk_paginas_user` FOREIGN KEY (`subida_por_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restriccions per a la taula `site_config`
--
ALTER TABLE `site_config`
ADD CONSTRAINT `fk_site_config_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;