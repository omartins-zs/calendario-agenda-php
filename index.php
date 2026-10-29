<?php 
require_once("config/config.php"); 
$user = $_SESSION['user'] ?? null;
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendário & Agenda com PHP</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo DIRPAGE.'lib/css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo DIRPAGE.'lib/js/FullCalendar/main.min.css'; ?>">
</head>
<body>

    <!-- Barra de Navegação Superior -->
    <header class="app-navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <span class="brand-icon">📅</span>
                <span class="brand-text">Calendário & Agenda <strong>PHP</strong></span>
            </div>
            
            <div class="navbar-actions">
                <button id="btnOpenModal" class="btn btn-primary">
                    <span>➕</span> Novo Evento
                </button>

                <?php if ($user): ?>
                    <div class="user-profile">
                        <span class="user-avatar">👤</span>
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($user['name']); ?></span>
                            <span class="user-role"><?php echo htmlspecialchars($user['role'] ?? 'Membro'); ?></span>
                        </div>
                        <a href="<?php echo DIRPAGE.'controllers/ControllerLogout.php'; ?>" class="btn btn-outline btn-sm">Sair</a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo DIRPAGE.'views/login.php'; ?>" class="btn btn-secondary">
                        <span>🔑</span> Fazer Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Container Principal do Calendário -->
    <main class="main-content">
        <div class="calendar-card">
            <div class="calendar"></div>
        </div>
    </main>

    <!-- Modal para Criação de Eventos -->
    <div id="modalEvent" class="modal-overlay" style="display: none;">
        <div class="modal-card">
            <div class="modal-header">
                <h3>Agendar Novo Evento</h3>
                <button type="button" id="btnCloseModal" class="modal-close">&times;</button>
            </div>
            <form id="formNewEvent" class="modal-body">
                <div class="form-group">
                    <label for="event_title">Título do Evento *</label>
                    <input type="text" id="event_title" class="form-control" placeholder="Ex: Reunião com Cliente" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-half">
                        <label for="event_start">Data / Hora Início *</label>
                        <input type="date" id="event_start" class="form-control" required>
                    </div>
                    <div class="form-group col-half">
                        <label for="event_end">Data / Hora Fim</label>
                        <input type="date" id="event_end" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="event_description">Descrição / Pauta</label>
                    <textarea id="event_description" class="form-control" rows="3" placeholder="Detalhes opcionais do evento..."></textarea>
                </div>

                <div class="form-group">
                    <label for="event_color">Cor do Marcador</label>
                    <select id="event_color" class="form-control">
                        <option value="#2563eb" selected>🔵 Azul (Padrão / Corporativo)</option>
                        <option value="#059669">🟢 Verde (Concluído / Sucesso)</option>
                        <option value="#d97706">🟠 Âmbar (Atenção / Pendente)</option>
                        <option value="#dc2626">🔴 Vermelho (Urgente / Crítico)</option>
                        <option value="#7c3aed">🟣 Roxo (Estratégico / Lançamento)</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnCancelModal" class="btn btn-outline">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Evento</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Passagem de parâmetros PHP para o JS -->
    <script>
        window.APP_CONFIG = {
            dirpage: <?php echo json_encode(DIRPAGE); ?>
        };
    </script>

    <script src="<?php echo DIRPAGE.'lib/js/FullCalendar/main.min.js'; ?>"></script>
    <script src="<?php echo DIRPAGE.'lib/js/javascript.js'; ?>"></script>
</body>
</html>
