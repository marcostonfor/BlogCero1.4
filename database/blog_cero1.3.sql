-- BlogCero: Esquema corregido
SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- Tabla users
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- Tabla social_media
CREATE TABLE IF NOT EXISTS `social_media` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(45) NULL,
    `clase` VARCHAR(45) NULL,
    `unicode` VARCHAR(45) NULL,
    `publicado` TINYINT NULL,
    `user_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `nombre_UNIQUE` (`nombre`),
    INDEX `fk_social_media_user_idx` (`user_id`),
    CONSTRAINT `fk_social_media_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Tabla site_config
CREATE TABLE IF NOT EXISTS `site_config` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `config_key` VARCHAR(45) NOT NULL,
    `config_value` VARCHAR(255) NULL,
    `user_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_site_config_user_idx` (`user_id`),
    CONSTRAINT `fk_site_config_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Tabla articulos_de_post
CREATE TABLE IF NOT EXISTS `articulos_de_post` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(100) NULL,
    `contenido` LONGTEXT NULL,
    `autor_id` INT NOT NULL,
    `fecha` DATETIME NULL,
    `estado` TINYINT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_articulos_autor_idx` (`autor_id`),
    CONSTRAINT `fk_articulos_autor` FOREIGN KEY (`autor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Tabla paginas
CREATE TABLE IF NOT EXISTS `paginas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NULL,
    `ruta_url` VARCHAR(250) NULL,
    `subida_por_user_id` INT NOT NULL,
    `fecha_subida` DATETIME NULL,
    `publicada` TINYINT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_paginas_user_idx` (`subida_por_user_id`),
    CONSTRAINT `fk_paginas_user` FOREIGN KEY (`subida_por_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Restaurar valores anteriores
SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
