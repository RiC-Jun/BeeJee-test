CREATE DATABASE IF NOT EXISTS `beejee`;

CREATE TABLE `beejee`.`tasks` (
    `id` SERIAL NOT NULL,
    `username` VARCHAR(100) NOT NULL COMMENT 'Имя автора задачи',
    `email` VARCHAR(100) NOT NULL COMMENT 'Почта автора задачи',
    `description` TEXT NOT NULL COMMENT 'Описание задачи',
    `checked` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Проверено администратором',
    `edited` TINYINT(1) NOT NULL COMMENT 'Отредактировано администратором',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `beejee`.`users` (
    `id` SERIAL NOT NULL,
    `login` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `beejee`.`users` (login, password)
	VALUES ('admin', '$2y$10$bcdK4Iknk9/ws4mLtJ0P2.ibQOOX/PyruK0na1/CZnAK17yL6ct7C');