<?php
session_start();
require_once '../vendor/autoload.php';

use Controller\RecipeController;
use Controller\UserController;

$recipeController = new RecipeController();
$userController = new UserController();

if (!$userController->isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['id'];
$userInfo = $userController->getUserData($user_id);

$formMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $prep_time = (int) $_POST['prep_time'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $validation = $recipeController->validateData($title, $ingredients, $instructions);

    if ($validation !== null) {
        $formMessage = $validation['message'];
    } else {
        $recipeController->saveRecipe($title, $category, $prep_time, $ingredients, $instructions, $user_id);
        header('Location: home.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/css/style.css">
    <title>Receitas | Nova Receita</title>
</head>

<body>

    <header>
        <span><?= htmlspecialchars($userInfo['name']) ?></span>
        <nav>
            <a href="home.php">Nova Receita</a>
            <a href="recipes.php">Minhas Receitas</a>
            <a href="../index.php">Sair</a>
        </nav>
    </header>

    <div class="container wide">
        <h2>Cadastrar Receita</h2>

        <?php if ($formMessage): ?>
            <p class="message"><?= $formMessage ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" required>

            <label for="category">Categoria</label>
            <input type="text" name="category" id="category">

            <label for="prep_time">Tempo de Preparo (min)</label>
            <input type="number" name="prep_time" id="prep_time">

            <label for="ingredients">Ingredientes</label>
            <textarea name="ingredients" id="ingredients" rows="4" required></textarea>

            <label for="instructions">Modo de Preparo</label>
            <textarea name="instructions" id="instructions" rows="4" required></textarea>

            <button type="submit">Salvar Receita</button>
        </form>
    </div>

</body>

</html>
