-- Schema do Banco de Dados para Calendário & Agenda PHP
-- Criação do banco se não existir
CREATE DATABASE IF NOT EXISTS `sistema` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema`;

-- Tabela de Usuários para autenticação (Prompt #10 & #3)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(50) DEFAULT 'admin',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Eventos do Calendário
CREATE TABLE IF NOT EXISTS `events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `title` VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `color` VARCHAR(20) DEFAULT '#3788d8',
    `start` DATETIME NOT NULL,
    `end` DATETIME NULL,
    `all_day` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed inicial de usuários (Credenciais: admin@agenda.local / admin123  e  usuario@agenda.local / user123)
-- Hash gerado via PASSWORD_DEFAULT (bcrypt)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Administrador do Sistema', 'admin@agenda.local', '$2y$10$wEkgkY0o.aCjUqY/pT4V/e0VfsmCg7FqB5G4Gf7O1gU2QWqUa4Fk6', 'Administrador'),
(2, 'Gabriel Martins', 'gabriel@agenda.local', '$2y$10$wEkgkY0o.aCjUqY/pT4V/e0VfsmCg7FqB5G4Gf7O1gU2QWqUa4Fk6', 'Desenvolvedor / Gestor')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- Seed inicial de eventos demonstrativos
INSERT INTO `events` (`id`, `user_id`, `title`, `description`, `color`, `start`, `end`, `all_day`) VALUES
(1, 1, 'Reunião de Alinhamento Semanal', 'Definição de sprints e metas da semana', '#2563eb', DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), 1),
(2, 1, 'Deploy de Infraestrutura Docker', 'Subir novos containers e validação de performance', '#059669', DATE_ADD(CURRENT_DATE, INTERVAL 3 DAY), DATE_ADD(CURRENT_DATE, INTERVAL 3 DAY), 0),
(3, 2, 'Revisão de Código & QA', 'Testes minuciosos nas rotas de login e calendário', '#d97706', DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), 0),
(4, 2, 'Lançamento da Versão Estável', 'Apresentação da agenda com FullCalendar integrada', '#7c3aed', DATE_ADD(CURRENT_DATE, INTERVAL 8 DAY), DATE_ADD(CURRENT_DATE, INTERVAL 8 DAY), 1)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`);
