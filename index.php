<?php
require_once __DIR__ . '/vendor/autoload.php';

use Controller\ReceitaController;

$controller = new ReceitaController();
$termo = $_GET['busca'] ?? '';

if (!empty($termo)) {
    $controller->buscar($termo);
} else {
    $controller->index();
}