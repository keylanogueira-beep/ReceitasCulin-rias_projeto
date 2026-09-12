<?php
require_once '../vendor/autoload.php';

use Controller\UserController;

$userController = new UserController();

$registerMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($userController->checkUserByEmail($email)) {
        $registerMessage = 'E-mail já cadastrado.';
    } elseif ($userController->createUser($name, $email, $password)) {
        header('Location: ../index.php');
        exit();
    } else {
        $registerMessage = 'Não foi possível concluir o cadastro. Verifique os dados informados.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../templates/css/style.css">
    <title>Receitas | Cadastro</title>
</head>

<body>

    <div class="container">
        <h2>Criar Conta</h2>

        <?php if ($registerMessage): ?>
            <p class="message"><?= $registerMessage ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Cadastrar</button>
        </form>

        <p class="footer-link">Já tem conta? <a href="../index.php">Entrar</a></p>
    </div>

</body>

</html>
