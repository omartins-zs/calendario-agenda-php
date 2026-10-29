<?php

namespace Classes;

use PDO;
use PDOException;

class ClassConexao
{
    private static ?PDO $instance = null;

    public static function getConexao(): ?PDO
    {
        if (self::$instance === null) {
            try {
                $host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
                $port = defined('DB_PORT') ? DB_PORT : '3306';
                $dbname = defined('DB_NAME') ? DB_NAME : 'sistema';
                $user = defined('DB_USER') ? DB_USER : 'root';
                $pass = defined('DB_PASS') ? DB_PASS : '';

                $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Log do erro e fallback controlado
                error_log("Erro de conexão com o banco de dados: " . $e->getMessage());
                return null;
            }
        }
        return self::$instance;
    }

    // Método de compatibilidade
    public function conectaDB(): ?PDO
    {
        return self::getConexao();
    }
}

