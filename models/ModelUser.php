<?php

namespace Models;

use Classes\ClassConexao;
use PDO;

class ModelUser
{
    private ?PDO $db;

    public function __construct()
    {
        $this->db = ClassConexao::getConexao();
    }

    public function findByEmail(string $email): ?array
    {
        if (!$this->db) {
            // Usuários padrão em memória caso o banco ainda esteja iniciando ou sem migração
            $mockUsers = [
                'admin@agenda.local' => [
                    'id' => 1,
                    'name' => 'Administrador do Sistema',
                    'email' => 'admin@agenda.local',
                    // Senha padrão: admin123
                    'password' => '$2y$10$wEkgkY0o.aCjUqY/pT4V/e0VfsmCg7FqB5G4Gf7O1gU2QWqUa4Fk6',
                    'role' => 'Administrador'
                ],
                'gabriel@agenda.local' => [
                    'id' => 2,
                    'name' => 'Gabriel Martins',
                    'email' => 'gabriel@agenda.local',
                    // Senha padrão: admin123
                    'password' => '$2y$10$wEkgkY0o.aCjUqY/pT4V/e0VfsmCg7FqB5G4Gf7O1gU2QWqUa4Fk6',
                    'role' => 'Desenvolvedor / Gestor'
                ]
            ];
            return $mockUsers[strtolower(trim($email))] ?? null;
        }

        try {
            $stmt = $this->db->prepare("SELECT id, name, email, password, role FROM users WHERE LOWER(email) = LOWER(:email) LIMIT 1");
            $stmt->execute([':email' => trim($email)]);
            $user = $stmt->fetch();
            return $user ?: null;
        } catch (\Exception $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }

    public function verifyPassword(string $inputPassword, string $hashPassword): bool
    {
        // Aceita password_verify com bcrypt ou fallback se for senha em texto plano legado
        if (password_verify($inputPassword, $hashPassword)) {
            return true;
        }
        return $inputPassword === $hashPassword;
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        if ($this->verifyPassword($password, $user['password'])) {
            unset($user['password']); // Nunca manter o hash na sessão
            return $user;
        }

        return null;
    }
}

