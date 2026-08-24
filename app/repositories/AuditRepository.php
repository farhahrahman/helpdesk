<?php
declare(strict_types=1);

namespace App\Repositories;

/**
 * Audit Trail Repository for System Security & Compliance
 */
class AuditRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('audit_logs');
    }

    public function log(string $action, string $description, ?string $ticketId = null, array $metadata = []): array
    {
        $user = current_user();

        $entry = [
            'id' => $this->engine->generateUuid(),
            'action' => $action,
            'description' => $description,
            'ticket_id' => $ticketId,
            'user_id' => $user['id'] ?? 'SYSTEM',
            'user_name' => $user['name'] ?? 'Sistem Automatik',
            'user_email' => $user['email'] ?? 'system@bkp.gov.my',
            'user_role' => $user['role'] ?? 'SYSTEM',
            'user_unit' => $user['unit'] ?? 'SYSTEM',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
            'metadata' => $metadata,
            'created_at' => date('c'),
        ];

        return $this->create($entry);
    }

    public function getByTicket(string $ticketId): array
    {
        return $this->query()
            ->where('ticket_id', $ticketId)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function getRecent(int $limit = 20): array
    {
        return $this->query()
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }
}
