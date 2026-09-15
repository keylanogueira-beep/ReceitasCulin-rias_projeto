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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $recipeController->deleteRecipe((int) $_POST['delete_id']);
    header('Location: recipes.php');
    exit();
}

$recipes = $recipeController->getRecipes($user_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/css/style.css">
    <title>Receitas | Minhas Receitas</title>
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
        <h2>Minhas Receitas</h2>

        <?php if (!$recipes): ?>
            <p class="message">Nenhuma receita cadastrada ainda.</p>
        <?php else: ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe">
                    <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
                    <p><strong>Tempo de Preparo:</strong> <?= htmlspecialchars($recipe['prep_time']) ?> min</p>
                    <p><strong>Ingredientes:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
                    <p><strong>Modo de Preparo:</strong> <?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?= $recipe['id'] ?>">
                        <button type="submit" class="delete">Excluir</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>

</html>
