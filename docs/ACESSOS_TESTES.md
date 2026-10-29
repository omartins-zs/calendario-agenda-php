# 🔐 Acessos e Dados de Teste

Utilize as credenciais abaixo para testar as diferentes visões e permissões do sistema. Todos os usuários e registros foram gerados automaticamente via *Seeders/SQL inicial*.

## 1. Acesso ao Sistema (Usuários de Teste)

| Perfil | E-mail / Usuário | Senha | Permissão / Detalhes |
| --- | --- | --- | --- |
| **Administrador** | `admin@agenda.local` | `admin123` | Acesso total ao calendário, criação, edição e exclusão de eventos |
| **Desenvolvedor / Gestor** | `gabriel@agenda.local` | `admin123` | Gerenciamento de eventos de equipe e acompanhamento técnico |

## 2. URLs Principais

| Ambiente | Aplicação (Home / Calendário) | Login / Autenticação | PHPMyAdmin |
| --- | --- | --- | --- |
| **Docker** | `http://localhost:8080` | `http://localhost:8080/views/login.php` | `http://localhost:8085` |
| **Local** (`php -S` ou Apache) | `http://127.0.0.1:8000` | `http://127.0.0.1:8000/views/login.php` | Painel local Laragon / XAMPP |

## 3. Vitrine Pública / Páginas para Clientes

| Item | Link (Exemplo Docker) | Descrição |
| --- | --- | --- |
| **Calendário Interativo** | `http://localhost:8080/` | Visualização mensal, semanal e diária da agenda |
| **API de Eventos (JSON)** | `http://localhost:8080/controllers/ControllerEvents.php` | Endpoint consumido pelo FullCalendar |
| **Página de Login** | `http://localhost:8080/views/login.php` | Painel de autenticação de usuários |

## 4. Validação do Acesso

Validação da saúde da aplicação no ambiente de desenvolvimento:

| Verificação | Resultado Esperado |
| --- | --- |
| Containers (`calendario_app`, `calendario_nginx`, `calendario_mysql`, `calendario_pma`) | Saudáveis / Rodando |
| Tela inicial com calendário | HTTP `200` com carregamento do FullCalendar |
| API de eventos (`/controllers/ControllerEvents.php`) | HTTP `200` retornando array JSON de eventos |
| Tela de login principal | HTTP `200` com formulário responsivo |
| Login com credencial de teste (`admin@agenda.local`) | Redirecionamento para a página inicial com perfil ativo |

## 5. Carregar Dados de Teste

Caso o banco de dados seja apagado ou precise ser resetado, utilize os comandos abaixo para recriar as credenciais e eventos iniciais.

**Com Docker:**
```bash
docker compose exec mysql mysql -u usuario_docker -psenha_docker sistema < database/schema.sql
```

Ou simplesmente recrie o volume do banco:
```bash
docker compose down -v
docker compose up -d --build
```

**Rodando Localmente (Sem Docker):**
```bash
mysql -u root -p sistema < database/schema.sql
```

---

### 📝 Observações:
- O banco de dados é alimentado com eventos demonstrativos e credenciais pré-configuradas para agilizar testes.
- Use estas credenciais **apenas** em ambiente local ou Docker de desenvolvimento.

