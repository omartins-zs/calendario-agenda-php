# Como Executar com Docker — Calendário & Agenda PHP

Guia para executar o sistema utilizando Docker Desktop.

---

## Stack e containers

| Container | Função | Porta |
| --- | --- | --- |
| **calendario_nginx** | Servidor Web Nginx com gzip e cache estático | 8080 |
| **calendario_app** | PHP 8.2-FPM otimizado com extensões e opcache | Interna (9000) |
| **calendario_mysql** | Banco de dados MySQL 8.0 com persistência | 3308 |
| **calendario_pma** | Interface web PHPMyAdmin | 8085 |

---

## 1) Preparar ambiente

```bash
cp .env.example .env
```

No PowerShell:

```powershell
Copy-Item .env.example .env
```

Deixe o bloco `DOCKER` ativo e o bloco `LOCAL` comentado:

```env
# LOCAL
# APP_URL=http://127.0.0.1:8000
#
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3307
# DB_DATABASE=sistema
# DB_USERNAME=root
# DB_PASSWORD=

# DOCKER
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sistema
DB_USERNAME=usuario_docker
DB_PASSWORD=senha_docker
DB_ROOT_PASSWORD=root
```

> Dentro do Docker, utilizar `DB_HOST=mysql` e `DB_PORT=3306`. A porta `3308` é somente para acesso pelo computador host.

---

## 2) Subir containers

```bash
docker compose up -d --build
docker compose ps
```

---

## 3) Inicialização e migrations

O banco de dados é inicializado automaticamente na primeira inicialização do container MySQL através do script montado em `/docker-entrypoint-initdb.d/init.sql` (`database/schema.sql`).

Caso deseje recarregar as tabelas e seeds manualmente a qualquer momento:

```bash
docker compose exec mysql mysql -u usuario_docker -psenha_docker sistema < database/schema.sql
```

Para garantir que o autoload do Composer esteja atualizado dentro do container:

```bash
docker compose exec app composer dump-autoload
```

---

## 4) Desenvolvimento e cache

Para reiniciar o PHP-FPM e limpar buffers de opcode/realpath:

```bash
docker compose restart app
```

---

## 5) Acessos

| Recurso | URL |
| --- | --- |
| Aplicação / Calendário | http://localhost:8080 |
| Página de Login | http://localhost:8080/views/login.php |
| PHPMyAdmin | http://localhost:8085 |

### Credenciais de teste

Administrador do Sistema:
- **URL de login:** http://localhost:8080/views/login.php
- **E-mail:** `admin@agenda.local`
- **Senha:** `admin123`

Desenvolvedor / Gestor:
- **URL de login:** http://localhost:8080/views/login.php
- **E-mail:** `gabriel@agenda.local`
- **Senha:** `admin123`

### PHPMyAdmin

- **URL:** http://localhost:8085
- **Servidor:** `mysql`
- **Usuário:** `usuario_docker` (ou `root`)
- **Senha:** `senha_docker` (ou `root`)

---

## 6) Logs e diagnóstico

```bash
# Ver todos os logs em tempo real
docker compose logs -f

# Ver logs apenas da aplicação PHP-FPM
docker compose logs -f app

# Ver logs do servidor Nginx
docker compose logs -f nginx

# Ver logs do MySQL
docker compose logs -f mysql
```

---

## 7) Parar ou reconstruir

Para pausar os containers preservando os dados:

```bash
docker compose down
```

Para subir e recompilar:

```bash
docker compose up -d --build
```

Para apagar também os volumes de dados do banco:

```bash
docker compose down -v
```

> O comando `docker compose down -v` pode apagar os dados do banco de dados persistidos no volume.
