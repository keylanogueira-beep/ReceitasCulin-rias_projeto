<?php

namespace Model;

use Model\Connection;
use PDO;
use PDOException;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function registerUser(string $name, string $email, string $password): bool
    {
        try {
            $sql = "INSERT INTO users(name, email, password, created_at) VALUES (:name, :email, :password, NOW())";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao registrar usuário: " . $error->getMessage());
            return false;
        }
    }

    public function getUserByEmail(string $email): array|bool
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log("Erro ao buscar usuário: " . $error->getMessage());
            return false;
        }
    }

    public function getUserInfo(int $id): array|bool
    {
        try {
            $sql = "SELECT name, email FROM users WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log("Erro ao obter informações: " . $error->getMessage());
            return false;
        }
    }
}
