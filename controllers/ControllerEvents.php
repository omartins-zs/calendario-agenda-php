<?php
require_once dirname(__DIR__) . '/config/config.php';

use Models\ModelEvents;

header('Content-Type: application/json; charset=utf-8');

$modelEvents = new ModelEvents();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $events = $modelEvents->getAllEvents();
    echo json_encode($events, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

if ($method === 'POST') {
    // Recebe dados via JSON ou form-data
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $action = $input['action'] ?? 'create';

    if ($action === 'create') {
        $title = trim($input['title'] ?? '');
        $start = trim($input['start'] ?? '');
        $end = !empty($input['end']) ? trim($input['end']) : $start;
        $description = trim($input['description'] ?? '');
        $color = trim($input['color'] ?? '#2563eb');
        $allDay = !empty($input['allDay']) ? 1 : 0;
        $userId = $_SESSION['user']['id'] ?? null;

        if (empty($title) || empty($start)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Título e data de início são obrigatórios.']);
            exit;
        }

        $success = $modelEvents->createEvent($title, $start, $end, $description, $color, $allDay, $userId);
        echo json_encode(['success' => $success]);
        exit;
    }

    if ($action === 'update_dates') {
        $id = (int)($input['id'] ?? 0);
        $start = trim($input['start'] ?? '');
        $end = !empty($input['end']) ? trim($input['end']) : $start;

        if (!$id || empty($start)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID e data de início são obrigatórios.']);
            exit;
        }

        $success = $modelEvents->updateEventDates($id, $start, $end);
        echo json_encode(['success' => $success]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($input['id'] ?? 0);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID obrigatório.']);
            exit;
        }

        $success = $modelEvents->deleteEvent($id);
        echo json_encode(['success' => $success]);
        exit;
    }
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Método não permitido']);
