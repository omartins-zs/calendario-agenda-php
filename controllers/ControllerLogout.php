<?php
require_once dirname(__DIR__) . '/config/config.php';

unset($_SESSION['user']);
$_SESSION['flash_success'] = 'Você saiu da sua conta com segurança.';

header('Location: ' . DIRPAGE . 'views/login.php');
exit;

