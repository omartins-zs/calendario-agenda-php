# Como Executar Localmente — Calendário & Agenda PHP

Guia para rodar **sem Docker**, no **Laragon**, **XAMPP** ou com o servidor embutido do PHP (`php -S`).

> **Não quer instalar PHP, Composer ou MySQL?** Use [COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md) — basta Docker Desktop, em qualquer Windows, Mac ou Linux.

---

## Requisitos

Para rodar localmente, você **não precisa** de uma versão específica do Laragon.

O essencial é **Composer** + **PHP** compatível.

Laragon, XAMPP ou `php -S` são apenas formas de subir o ambiente.

| Ferramenta | Obrigatório? | Versão mínima |
| --- | --- | --- |
| **Composer** | Sim | 2.x |
| **PHP** | Sim | 8.0+ |
| **MySQL** | Sim | 8.0+ |

Extensões PHP necessárias: `pdo_mysql`, `mbstring`, `intl`, `zip`.

### Ambiente de referência (máquina de desenvolvimento)

Stack usada na elaboração deste projeto — **não é requisito fixo**, só referência do que já foi testado:

| Ferramenta | Versão |
| --- | --- |
| **Laragon** | **6.0.0** |
| PHP (via Laragon) | 8.4.6 |
| Composer | 2.8.12 |
| Laravel (no projeto) | 13.15.0 |
| **Node.js** | **22.14.0+** |
| **NPM** | **11.4.2+** |

Para conferir no seu computador:

```bash
php -v
composer --version
mysql --version
```

---

## 1) Preparar ambiente

### 1.1 Clonar ou acessar o projeto

```bash
cd c:/laragon/www/calendario-agenda-php
```

### 1.2 Copiar variáveis de ambiente

```bash
cp .env.example .env
```

No PowerShell:

```powershell
Copy-Item .env.example .env
```

### 1.3 Ativar o ambiente local

Deixe o bloco `LOCAL` ativo e o bloco `DOCKER` comentado no `.env`:

```env
# LOCAL
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=sistema
DB_USERNAME=root
DB_PASSWORD=

# DOCKER
# APP_URL=http://localhost:8080
#
# DB_CONNECTION=mysql
# DB_HOST=mysql
# DB_PORT=3306
# DB_DATABASE=sistema
# DB_USERNAME=usuario_docker
# DB_PASSWORD=senha_docker
# DB_ROOT_PASSWORD=root
```

### 1.4 Criar o banco de dados

Crie o banco pelo HeidiSQL, PHPMyAdmin ou execute:

```sql
CREATE DATABASE sistema
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

> No ambiente local, utilizar MySQL na porta **3307**, usuário `root` e senha vazia.

---

## 2) Instalar dependências

```bash
composer install
```

---

## 3) Inicialização e dados

Importe a estrutura de tabelas e registros iniciais:

```bash
mysql -h 127.0.0.1 -P 3307 -u root sistema < database/schema.sql
```

---

## 4) Rodar aplicação

Caso utilize Laragon ou XAMPP, acesse diretamente pelo virtual host ou execute o servidor embutido do PHP:

```bash
php -S 127.0.0.1:8000
```

Aplicação:

http://127.0.0.1:8000

---

## 5) Filas e workers

Este projeto opera de forma síncrona com processamento direto em banco de dados e requisições assíncronas via fetch/AJAX para o FullCalendar. Não exige serviço de filas em segundo plano.

---

## 6) Acessos

| Recurso | URL |
| --- | --- |
| Calendário / Home | http://127.0.0.1:8000 |
| Página de Login | http://127.0.0.1:8000/views/login.php |
| API de Eventos | http://127.0.0.1:8000/controllers/ControllerEvents.php |

### Credenciais de teste

Administrador do Sistema:
- **URL de login:** http://127.0.0.1:8000/views/login.php
- **E-mail:** `admin@agenda.local`
- **Senha:** `admin123`

Desenvolvedor / Gestor:
- **URL de login:** http://127.0.0.1:8000/views/login.php
- **E-mail:** `gabriel@agenda.local`
- **Senha:** `admin123`

---

## 7) Comandos úteis

```bash
composer dump-autoload
php -S 127.0.0.1:8000
```

---

## 8) Problemas comuns

### Banco não conecta

Verifique se a porta no `.env` coincide com o seu MySQL local (ex: Laragon utiliza `3307` por padrão ou `3306`):

```env
DB_HOST=127.0.0.1
DB_PORT=3307
```

### Alterações do `.env` não foram aplicadas

Reinicie o servidor local (`Ctrl + C` e suba novamente com `php -S 127.0.0.1:8000`).

### Tabelas não encontradas

Importe o arquivo SQL:

```bash
mysql -h 127.0.0.1 -P 3307 -u root sistema < database/schema.sql
```

---

## Próximo passo

Para ambiente containerizado, consulte [COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md).

