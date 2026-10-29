<?php

namespace Models;

use Classes\ClassConexao;
use PDO;

class ModelEvents
{
    private ?PDO $db;

    public function __construct()
    {
        $this->db = ClassConexao::getConexao();
    }

    public function getAllEvents(): array
    {
        if (!$this->db) {
            return $this->getFallbackEvents();
        }

        try {
            $stmt = $this->db->query("SELECT id, title, description, color, start, end, all_day FROM events ORDER BY start ASC");
            $rows = $stmt->fetchAll();

            if (empty($rows)) {
                return $this->getFallbackEvents();
            }

            $events = [];
            foreach ($rows as $row) {
                $events[] = [
                    'id' => (int)$row['id'],
                    'title' => $row['title'],
                    'description' => $row['description'] ?? '',
                    'color' => $row['color'] ?? '#3788d8',
                    'start' => $row['start'],
                    'end' => $row['end'] ?? $row['start'],
                    'allDay' => (bool)$row['all_day']
                ];
            }
            return $events;
        } catch (\Exception $e) {
            error_log("Erro ao buscar eventos: " . $e->getMessage());
            return $this->getFallbackEvents();
        }
    }

    public function createEvent(string $title, string $start, ?string $end = null, ?string $description = '', ?string $color = '#3788d8', int $allDay = 0, ?int $userId = null): bool
    {
        if (!$this->db) {
            return false;
        }

        try {
            $sql = "INSERT INTO events (title, description, color, start, end, all_day, user_id) 
                    VALUES (:title, :description, :color, :start, :end, :all_day, :user_id)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':color' => $color,
                ':start' => $start,
                ':end' => $end ?: $start,
                ':all_day' => $allDay,
                ':user_id' => $userId
            ]);
        } catch (\Exception $e) {
            error_log("Erro ao criar evento: " . $e->getMessage());
            return false;
        }
    }

    public function updateEventDates(int $id, string $start, ?string $end = null): bool
    {
        if (!$this->db) {
            return false;
        }

        try {
            $sql = "UPDATE events SET start = :start, end = :end WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':start' => $start,
                ':end' => $end ?: $start,
                ':id' => $id
            ]);
        } catch (\Exception $e) {
            error_log("Erro ao atualizar evento: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEvent(int $id): bool
    {
        if (!$this->db) {
            return false;
        }

        try {
            $sql = "DELETE FROM events WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (\Exception $e) {
            error_log("Erro ao deletar evento: " . $e->getMessage());
            return false;
        }
    }

    private function getFallbackEvents(): array
    {
        $today = date('Y-m-d');
        return [
            [
                'id' => 1,
                'title' => 'Reunião de Alinhamento Semanal',
                'description' => 'Definição de metas e backlog',
                'color' => '#2563eb',
                'start' => date('Y-m-d', strtotime($today . ' +1 day')),
                'end' => date('Y-m-d', strtotime($today . ' +1 day')),
                'allDay' => true
            ],
            [
                'id' => 2,
                'title' => 'Deploy de Infraestrutura Docker',
                'description' => 'Containerização do sistema com Nginx e PHP-FPM',
                'color' => '#059669',
                'start' => date('Y-m-d', strtotime($today . ' +3 days')),
                'end' => date('Y-m-d', strtotime($today . ' +3 days')),
                'allDay' => true
            ],
            [
                'id' => 3,
                'title' => 'Revisão de Código & QA',
                'description' => 'Validação dos fluxos de calendário e autenticação',
                'color' => '#d97706',
                'start' => date('Y-m-d', strtotime($today . ' +5 days')),
                'end' => date('Y-m-d', strtotime($today . ' +5 days')),
                'allDay' => true
            ]
        ];
    }
}

