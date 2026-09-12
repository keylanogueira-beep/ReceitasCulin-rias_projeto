<?php

namespace Model;

use Model\Connection;
use PDO;
use PDOException;

class Recipe
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function createRecipe(string $title, string $category, int $prep_time, string $ingredients, string $instructions, int $id_user): bool
    {
        try {
            $sql = "INSERT INTO recipes(title, category, prep_time, ingredients, instructions, created_at, id_user) VALUES (:title, :category, :prep_time, :ingredients, :instructions, NOW(), :id_user)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->bindParam(":prep_time", $prep_time, PDO::PARAM_INT);
            $stmt->bindParam(":ingredients", $ingredients, PDO::PARAM_STR);
            $stmt->bindParam(":instructions", $instructions, PDO::PARAM_STR);
            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao criar receita: " . $error->getMessage());
            return false;
        }
    }

    public function getRecipes(int $id_user): array|bool
    {
        try {
            $sql = "SELECT * FROM recipes WHERE id_user = :id_user ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            error_log("Erro ao buscar receitas: " . $error->getMessage());
            return false;
        }
    }

    public function deleteRecipe(int $id): bool
    {
        try {
            $sql = "DELETE FROM recipes WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao excluir receita: " . $error->getMessage());
            return false;
        }
    }
}
