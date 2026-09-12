<?php
session_start();
require_once 'vendor/autoload.php';

use Controller\UserController;

$userController = new UserController();

$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($userController->login($email, $password)) {
        header('Location: View/home.php');
        exit();
    }

    $loginMessage = 'E-mail ou senha inválidos!';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="templates/css/style.css">
    <title>Receitas | Entrar</title>
</head>

<body>

    <div class="container">
        <h2>Entrar</h2>

        <?php if ($loginMessage): ?>
            <p class="message"><?= $loginMessage ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Entrar</button>
        </form>

        <p class="footer-link">Não tem conta? <a href="View/register.php">Cadastre-se</a></p>
    </div>

</body>

</html>
