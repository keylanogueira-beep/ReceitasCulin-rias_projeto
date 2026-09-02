<?php
namespace Model;

use Config\Config;
use PDO;

class Receita {
    private $db;

    public function __construct() {
        $this->db = Config::getConnection();
    }

    public function buscarPorTermo(string $termo): array {
        $stmt = $this->db->prepare(
            "SELECT id, titulo, categoria 
             FROM receitas 
             WHERE titulo LIKE :termo OR categoria LIKE :termo"
        );
        $stmt->execute(['termo' => '%' . $termo . '%']);
        return $stmt->fetchAll();
    }

    public function listarTodas(): array {
        $stmt = $this->db->query("SELECT id, titulo, categoria FROM receitas");
        return $stmt->fetchAll();
    }
}