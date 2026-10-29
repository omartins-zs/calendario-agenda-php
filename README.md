<div align="center">

# 📅 Calendário & Agenda PHP

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Nginx-1.25-009639?style=for-the-badge&logo=nginx&logoColor=white" alt="Nginx" />
  <img src="https://img.shields.io/badge/Docker-Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
  <img src="https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/FullCalendar-v5-3788D8?style=for-the-badge&logo=googlecalendar&logoColor=white" alt="FullCalendar" />
</p>

<p align="center">
  <strong>Sistema moderno de agendamento e gerenciamento de eventos corporativos com FullCalendar, PHP e MySQL em ambiente containerizado de alta performance.</strong>
</p>

<cite>Solução robusta e responsiva para controle de compromissos, agendamentos e reuniões com suporte nativo a Docker e execução local.</cite>

</div>

---

<h4 align="center"> ✅ Calendário & Agenda PHP 🚀 Concluído ⚙️ </h4>

---

## 🏗️ Arquitetura do Projeto

- **🧱 Monólito MVC:** O backend em PHP e a interface visual com JavaScript/CSS/FullCalendar operam integrados em arquitetura limpa com separação de responsabilidades (Models, Views, Controllers e Classes de Infraestrutura).
- **🐳 Híbrido & Containerizado:** Totalmente pronto para execução em container isolado (Nginx + PHP 8.2-FPM + MySQL 8.0 + PHPMyAdmin) ou em servidor local tradicional (Laragon, XAMPP, `php -S`).

---

## 🔥 Pré-requisitos

Para executar este projeto, certifique-se de possuir:

- **PHP 8.0+** (Recomendado 8.2+)
- **Composer 2.x**
- **MySQL 8.0+**
- **Docker & Docker Compose** (caso opte pela execução em containers)

Extensões PHP necessárias: `pdo_mysql`, `mbstring`, `intl`, `zip`, `opcache`.

---

## 🚀 Tecnologias Utilizadas

- **Linguagem:** PHP 8.2+
- **Frontend / Componentes:** FullCalendar 5, JavaScript Vanilla (ES6+), CSS3 Flexbox/Grid
- **Banco de Dados:** MySQL 8.0
- **Servidor Web:** Nginx Alpine
- **Containerização:** Docker & Docker Compose
- **Padrões de Projeto:** MVC (Model-View-Controller), Singleton (Database Connection), RESTful JSON Endpoints

---

## 🔨 Funcionalidades

- 📆 **Calendário Interativo:** Visualização em grade mensal, semanal e diária com navegação intuitiva.
- ➕ **Agendamento Dinâmico:** Modal com formulário para cadastro ágil de eventos com datas, horários, pauta e cores.
- 🔄 **Arrastar e Soltar (Drag & Drop):** Reposicionamento e redimensionamento de eventos no calendário com atualização assíncrona.
- 🗑️ **Gestão Completa de Eventos:** Exibição de detalhes de compromissos e opção de exclusão.
- 🔐 **Autenticação de Usuários:** Fluxo completo de login e logout com hash de senhas (`password_verify` / bcrypt) e controle de sessão seguro.
- ⚡ **API RESTful Interna:** Endpoint `/controllers/ControllerEvents.php` para consumo do FullCalendar e integração externa.
- 🐳 **Ambiente Otimizado:** Dockerfile multi-stage com PHP-FPM tunado, Opcache ativado e buffers configurados para Docker Desktop no Windows.

---

## 🎯 Sobre o Projeto

Sistema desenvolvido demonstrando boas práticas de desenvolvimento, arquitetura limpa e organização de código, com foco em escalabilidade e manutenção.

---

## 📸 Preview do Projeto

🚧 Preview não disponível no projeto.

---

## 📁 Documentação do Projeto

O projeto conta com documentação completa em diretório próprio:

- 📖 **[COMO_EXECUTAR.md](docs/COMO_EXECUTAR.md):** Guia mestre de execução e visão geral de rotas.
- 🐳 **[COMO_EXECUTAR_DOCKER.md](docs/COMO_EXECUTAR_DOCKER.md):** Instruções passo a passo para execução com Docker Compose.
- 💻 **[COMO_EXECUTAR_LOCAL.md](docs/COMO_EXECUTAR_LOCAL.md):** Instruções para execução local com Laragon / XAMPP.
- 🔑 **[ACESSOS_TESTES.md](docs/ACESSOS_TESTES.md):** Credenciais padrão e dados de teste.

---

## 💻 Comandos

### Modo Docker (Recomendado)

```bash
# 1. Copiar as variáveis de ambiente e ativar o bloco DOCKER
cp .env.example .env

# 2. Subir a stack completa (Nginx, App, MySQL, PHPMyAdmin)
docker compose up -d --build

# 3. Acessar a aplicação no navegador
# http://localhost:8080
# PHPMyAdmin: http://localhost:8085
```

### Modo Local (Laragon / XAMPP / PHP Server)

```bash
# 1. Copiar variáveis de ambiente e manter o bloco LOCAL ativo
cp .env.example .env

# 2. Instalar dependências
composer install

# 3. Importar banco de dados
mysql -u root -p sistema < database/schema.sql

# 4. Iniciar servidor embutido
php -S 127.0.0.1:8000
```

---

## ⚠️ IMPORTANTE

> ⚠️ Estes são comandos básicos. Verifique no projeto arquivos como:
> README.md, COMO_EXECUTAR.md ou docs/ para instruções completas.

---

## 🧱 Estrutura do Projeto

```text
calendario-agenda-php/
├── class/                     # Classes de infraestrutura (ClassConexao)
├── config/                    # Configurações globais e carregamento do .env
├── controllers/               # Controladores (Events, Login, Logout)
├── database/                  # Scripts SQL e carga de dados inicial (schema.sql)
├── docker/                    # Arquivos de customização de infraestrutura
│   ├── nginx/                 # Configuração otimizada do Nginx
│   ├── php/                   # local.ini e fpm-performance.conf
│   └── scripts/               # Script de inicialização do container (start-app.sh)
├── docs/                      # Manuais e documentações de execução
│   ├── ACESSOS_TESTES.md
│   ├── COMO_EXECUTAR.md
│   ├── COMO_EXECUTAR_DOCKER.md
│   └── COMO_EXECUTAR_LOCAL.md
├── lib/                       # Assets estáticos (CSS, JS, FullCalendar, Composer)
│   ├── css/
│   ├── js/
│   └── composer/
├── models/                    # Modelos de dados (ModelEvents, ModelUser)
├── views/                     # Visões do sistema (login.php)
├── .dockerignore              # Arquivos ignorados pelo build Docker
├── .env.example               # Template de variáveis de ambiente híbridas
├── .gitignore                 # Arquivos ignorados pelo Git
├── composer.json              # Mapeamento PSR-4 e dependências
├── docker-compose.yml         # Orquestração dos containers
├── Dockerfile                 # Construção da imagem PHP-FPM
└── index.php                  # Página principal e montagem da agenda
```

---

## 📝 Melhorias Futuras

- [ ] Implementar exportação de eventos para formato iCal / Google Calendar
- [ ] Adicionar filtros por categoria e status no calendário
- [ ] Implementar notificações de compromissos por e-mail via Mailpit / SMTP
- [ ] Suporte a múltiplos calendários simultâneos

---

## 📄 Finalização

<div align="center">

Feito com ❤️ por Gabriel Martins 🚀

</div>
