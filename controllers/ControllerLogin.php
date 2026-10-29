<?php
require_once dirname(__DIR__) . '/config/config.php';

use Models\ModelUser;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . DIRPAGE . 'views/login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    $_SESSION['flash_error'] = 'Por favor, preencha todos os campos.';
    header('Location: ' . DIRPAGE . 'views/login.php');
    exit;
}

$modelUser = new ModelUser();
$user = $modelUser->authenticate($email, $password);

if ($user) {
    // Autenticado com sucesso
    $_SESSION['user'] = $user;
    $_SESSION['flash_success'] = 'Bem-vindo de volta, ' . htmlspecialchars($user['name']) . '!';
    header('Location: ' . DIRPAGE);
    exit;
} else {
    $_SESSION['flash_error'] = 'E-mail ou senha incorretos. Tente novamente.';
    header('Location: ' . DIRPAGE . 'views/login.php');
    exit;
}
