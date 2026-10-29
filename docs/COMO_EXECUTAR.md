# Como Executar — Calendário & Agenda PHP

Escolha **um** guia conforme seu ambiente:

| Guia | Quando usar | Requisitos no PC |
| --- | --- | --- |
| **[COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md)** | Executar em qualquer máquina com containers | Docker Desktop |
| **[COMO_EXECUTAR_LOCAL.md](COMO_EXECUTAR_LOCAL.md)** | Desenvolver com Laragon, XAMPP ou PHP built-in | PHP, Composer e MySQL |
| **[ACESSOS_TESTES.md](ACESSOS_TESTES.md)** | Logins, URLs e fluxos de teste | Guia de credenciais |

---

## Início rápido

### Local — Laragon ou XAMPP

Ative o bloco `LOCAL` no `.env` e execute:

```bash
cp .env.example .env
composer install
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sistema CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root sistema < database/schema.sql
php -S 127.0.0.1:8000
```

Aplicação:

http://127.0.0.1:8000

---

### Docker

Ative o bloco `DOCKER` no `.env` e execute:

```bash
cp .env.example .env
docker compose up -d --build
```

Aplicação:

http://localhost:8080

---

## Logins demo

| Perfil | E-mail | Senha |
| --- | --- | --- |
| Administrador | `admin@agenda.local` | `admin123` |
| Desenvolvedor / Gestor | `gabriel@agenda.local` | `admin123` |

---

## URLs principais

| Área | Local | Docker |
| --- | --- | --- |
| Calendário / Home | http://127.0.0.1:8000 | http://localhost:8080 |
| Página de Login | http://127.0.0.1:8000/views/login.php | http://localhost:8080/views/login.php |
| API de Eventos | http://127.0.0.1:8000/controllers/ControllerEvents.php | http://localhost:8080/controllers/ControllerEvents.php |
| PHPMyAdmin | Painel local Laragon / XAMPP | http://localhost:8085 |

---

## Outros documentos

- [ACESSOS_TESTES.md](ACESSOS_TESTES.md) — Credenciais e fluxos de teste

