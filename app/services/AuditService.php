<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuditRepository;

/**
 * Audit Logging Service
 */
class AuditService
{
    private AuditRepository $auditRepo;

    public function __construct(?AuditRepository $auditRepo = null)
    {
        $this->auditRepo = $auditRepo ?? new AuditRepository();
    }

    public function log(string $action, string $description, ?string $ticketId = null, array $metadata = []): array
    {
        return $this->auditRepo->log($action, $description, $ticketId, $metadata);
    }

    public function getTrailForTicket(string $ticketId): array
    {
        return $this->auditRepo->getByTicket($ticketId);
    }

    public function getRecentLogs(int $limit = 20): array
    {
        return $this->auditRepo->getRecent($limit);
    }
}
