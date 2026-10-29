<?php
require_once dirname(__DIR__) . '/config/config.php';

$error = $_SESSION['flash_error'] ?? null;
$success = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_error'], $_SESSION['flash_success']);

$isLoggedIn = !empty($_SESSION['user']);
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Calendário & Agenda PHP</title>
    <link rel="stylesheet" href="<?php echo DIRPAGE . 'lib/css/style.css'; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">📅</div>
                <h1>Calendário & Agenda</h1>
                <p>Acesse sua conta para gerenciar eventos e agendamentos</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <span>⚠️</span> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <span>✅</span> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($isLoggedIn): ?>
                <div class="alert alert-info">
                    Você já está autenticado como <strong><?php echo htmlspecialchars($_SESSION['user']['name']); ?></strong>.
                </div>
                <div class="auth-actions">
                    <a href="<?php echo DIRPAGE; ?>" class="btn btn-primary btn-block">Acessar Calendário</a>
                    <a href="<?php echo DIRPAGE . 'controllers/ControllerLogout.php'; ?>" class="btn btn-outline btn-block">Sair da Conta</a>
                </div>
            <?php else: ?>
                <form action="<?php echo DIRPAGE . 'controllers/ControllerLogin.php'; ?>" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="email">E-mail Corporativo</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="admin@agenda.local" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Senha de Acesso</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Entrar no Sistema</button>
                </form>

                <div class="demo-credentials">
                    <div class="demo-title">🔑 Credenciais de Teste / Demonstração</div>
                    <div class="demo-item" onclick="fillCredentials('admin@agenda.local', 'admin123')">
                        <strong>Admin:</strong> <code>admin@agenda.local</code> | <code>admin123</code>
                        <span class="demo-tag">Clique para preencher</span>
                    </div>
                    <div class="demo-item" onclick="fillCredentials('gabriel@agenda.local', 'admin123')">
                        <strong>Gestor:</strong> <code>gabriel@agenda.local</code> | <code>admin123</code>
                        <span class="demo-tag">Clique para preencher</span>
                    </div>
                </div>

                <div class="auth-footer">
                    <a href="<?php echo DIRPAGE; ?>">← Voltar para o Calendário Público</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function fillCredentials(email, pass) {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            if (emailInput && passInput) {
                emailInput.value = email;
                passInput.value = pass;
                emailInput.focus();
            }
        }
    </script>
</body>
</html>
