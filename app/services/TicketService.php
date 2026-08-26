<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Storage\JsonStorageEngine;

/**
 * Ticket & Service Request Management Service
 */
class TicketService
{
    private TicketRepository $ticketRepo;
    private UserRepository $userRepo;
    private AuditService $audit;
    private JsonStorageEngine $engine;

    public function __construct(
        ?TicketRepository $ticketRepo = null,
        ?UserRepository $userRepo = null,
        ?AuditService $audit = null,
        ?JsonStorageEngine $engine = null
    ) {
        $this->ticketRepo = $ticketRepo ?? new TicketRepository();
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->audit = $audit ?? new AuditService();
        $this->engine = $engine ?? JsonStorageEngine::getInstance();
    }

    /**
     * Create a new ticket
     */
    public function createTicket(array $data, array $user): array
    {
        $category = $data['category'] ?? 'PEMINJAMAN_ASET';
        $refNo = $this->engine->nextReferenceNumber('ICTBKP');

        $unitsConfig = app_config('units', []);
        $unitCode = $user['unit'] ?? 'PENTADBIRAN';
        $unitName = $unitsConfig[$unitCode]['name'] ?? $unitCode;

        // Base ticket data
        $ticket = [
            'id' => $this->engine->generateUuid(),
            'reference_no' => $refNo,
            'category' => $category,
            'title' => trim($data['title'] ?? 'Permohonan Perkhidmatan ICT'),
            'purpose' => trim($data['purpose'] ?? ''),
            'user_id' => $user['id'],
            'applicant_name' => $user['name'],
            'applicant_email' => $user['email'],
            'applicant_phone' => $data['applicant_phone'] ?? $user['phone'] ?? '',
            'applicant_position' => $user['position'] ?? 'Pegawai',
            'unit' => $unitCode,
            'unit_name' => $unitName,
            'status' => 'MENUNGGU_SOKONGAN_UNIT',
            'start_date' => $data['start_date'] ?? date('Y-m-d'),
            'end_date' => $data['end_date'] ?? $data['start_date'] ?? date('Y-m-d'),
            'start_time' => $data['start_time'] ?? '09:00',
            'end_time' => $data['end_time'] ?? '17:00',
            'location' => trim($data['location'] ?? 'Bilik Mesyuarat BKP'),
            
            // Category-specific details
            'requested_equipment_types' => (array)($data['requested_equipment_types'] ?? []),
            'assigned_asset_ids' => [],
            
            'meeting_type' => $data['meeting_type'] ?? null,
            'meeting_platform' => $data['meeting_platform'] ?? null,
            'meeting_link' => $data['meeting_link'] ?? null,
            'meeting_passcode' => $data['meeting_passcode'] ?? null,
            'vip_attendees' => trim($data['vip_attendees'] ?? ''),

            'media_scope' => $data['media_scope'] ?? null,
            'event_agenda' => trim($data['event_agenda'] ?? ''),

            // Approval details
            'unit_approval' => [
                'status' => 'PENDING',
                'approved_by' => null,
                'approver_name' => null,
                'notes' => null,
                'action_at' => null,
            ],
            'ict_approval' => [
                'status' => 'PENDING',
                'approved_by' => null,
                'approver_name' => null,
                'assigned_technician_id' => null,
                'assigned_technician_name' => null,
                'notes' => null,
                'action_at' => null,
            ],

            'remarks' => trim($data['remarks'] ?? ''),
            'created_at' => date('c'),
            'updated_at' => date('c'),
        ];

        // If applicant is Ketua Unit or Admin, automatically pre-support at unit level
        if (($user['role'] ?? '') === 'KETUA_UNIT' || ($user['role'] ?? '') === 'ADMIN') {
            $ticket['unit_approval'] = [
                'status' => 'APPROVED',
                'approved_by' => $user['id'],
                'approver_name' => $user['name'] . ' (Auto-Perakuan Ketua Unit)',
                'notes' => 'Permohonan dibuat terus oleh Ketua Unit / Pentadbir',
                'action_at' => date('c'),
            ];
            $ticket['status'] = 'MENUNGGU_KELULUSAN_ICT';
        }

        $created = $this->ticketRepo->create($ticket);

        $this->audit->log(
            'TICKET_CREATED',
            "Permohonan baru {$refNo} dicipta oleh {$user['name']} ({$unitName})",
            $created['id'],
            ['reference_no' => $refNo, 'category' => $category]
        );

        return $created;
    }

    public function getTicket(string $id): ?array
    {
        return $this->ticketRepo->find($id);
    }

    public function getTicketByRef(string $refNo): ?array
    {
        return $this->ticketRepo->findByReference($refNo);
    }

    /**
     * Cancel ticket by applicant
     */
    public function cancelTicket(string $id, string $reason, array $user): bool
    {
        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            return false;
        }

        // Only allow cancel if pending or own ticket (or admin)
        if ($ticket['user_id'] !== $user['id'] && ($user['role'] ?? '') !== 'ADMIN') {
            return false;
        }

        if (in_array($ticket['status'], ['SELESAI', 'DIBATALKAN'])) {
            return false;
        }

        $this->ticketRepo->update($id, [
            'status' => 'DIBATALKAN',
            'cancellation_reason' => $reason,
            'cancelled_by' => $user['id'],
            'cancelled_at' => date('c'),
        ]);

        $this->audit->log(
            'TICKET_CANCELLED',
            "Permohonan {$ticket['reference_no']} telah dibatalkan oleh {$user['name']}. Sebab: {$reason}",
            $id
        );

        return true;
    }

    /**
     * Delete ticket permanently (Khusus farhah@johor.gov.my sahaja)
     */
    public function deleteTicket(string $id, array $user): bool
    {
        if (($user['email'] ?? '') !== 'farhah@johor.gov.my') {
            return false;
        }

        $ticket = $this->ticketRepo->find($id);
        if (!$ticket) {
            return false;
        }

        // Release any assigned assets back to TERSEDIA
        if (!empty($ticket['assigned_asset_ids'])) {
            foreach ($ticket['assigned_asset_ids'] as $assetId) {
                $this->engine->update('assets', $assetId, [
                    'status' => 'TERSEDIA',
                    'current_ticket_id' => null,
                    'current_holder_id' => null,
                    'current_holder_name' => null,
                ]);
            }
        }

        $deleted = $this->ticketRepo->delete($id);

        if ($deleted) {
            $this->audit->log(
                'TICKET_DELETED',
                "Permohonan {$ticket['reference_no']} telah dipadam secara kekal oleh {$user['name']} ({$user['email']})",
                $id,
                ['reference_no' => $ticket['reference_no'], 'deleted_by' => $user['email']]
            );
        }

        return $deleted;
    }
}
