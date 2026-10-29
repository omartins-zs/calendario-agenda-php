<?php
# Iniciar Sessão para Login / Autenticação
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Caminhos do Sistema
$projectRoot = dirname(__DIR__) . DIRECTORY_SEPARATOR;
define('DIRREQ', rtrim(str_replace('\\', '/', $projectRoot), '/') . '/');

# Leitura segura de variáveis do arquivo .env
$envFile = DIRREQ . '.env';
$env = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Ignora comentários e linhas vazias
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove aspas simples ou duplas envolventes
            $value = trim($value, "\"'");
            $env[$key] = $value;
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}

# Configurações de URL da Aplicação
$appUrl = $env['APP_URL'] ?? ('http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost:8080'));
$appUrl = rtrim($appUrl, '/') . '/';
define('DIRPAGE', $appUrl);

# Configurações do Banco de Dados
define('DB_HOST', $env['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $env['DB_PORT'] ?? '3306');
define('DB_NAME', $env['DB_DATABASE'] ?? 'sistema');
define('DB_USER', $env['DB_USERNAME'] ?? 'root');
define('DB_PASS', $env['DB_PASSWORD'] ?? '');

# Compatibilidade com constantes legadas do projeto
define('HOST', DB_HOST);
define('DB', DB_NAME);
define('USER', DB_USER);
define('PASS', DB_PASS);

# Autoload do Composer
if (file_exists(DIRREQ . 'vendor/autoload.php')) {
    include_once(DIRREQ . 'vendor/autoload.php');
} elseif (file_exists(DIRREQ . 'lib/composer/vendor/autoload.php')) {
    include_once(DIRREQ . 'lib/composer/vendor/autoload.php');
}

# Autoloader fallback para classes em class/ e models/
spl_autoload_register(function ($class) {
    $classClean = str_replace(['Classes\\', 'Models\\', '\\'], ['', '', DIRECTORY_SEPARATOR], $class);
    $paths = [
        DIRREQ . 'class/' . $classClean . '.php',
        DIRREQ . 'models/' . $classClean . '.php',
        DIRREQ . 'controllers/' . $classClean . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
