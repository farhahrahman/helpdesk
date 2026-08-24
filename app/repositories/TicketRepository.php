<?php
declare(strict_types=1);

namespace App\Repositories;

/**
 * Ticket Repository for Equipment Loans & Service Requests
 */
class TicketRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('tickets');
    }

    /**
     * Find ticket by reference number or ID with smart matching (exact or suffix / short code)
     */
    public function findByReference(string $refNo): ?array
    {
        $cleanRef = strtoupper(trim($refNo));
        if ($cleanRef === '') {
            return null;
        }

        $all = $this->all();
        foreach ($all as $item) {
            $itemRef = strtoupper($item['reference_no'] ?? '');
            $itemId = strtoupper($item['id'] ?? '');

            if (
                $itemRef === $cleanRef ||
                $itemId === $cleanRef ||
                str_ends_with($itemRef, '/' . $cleanRef) ||
                str_ends_with($itemRef, $cleanRef)
            ) {
                return $item;
            }
        }
        return null;
    }

    public function getByApplicant(string $userId): array
    {
        return $this->query()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getByUnit(string $unitCode): array
    {
        return $this->query()
            ->where('unit', $unitCode)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getPendingUnitApprovals(string $unitCode): array
    {
        return $this->query()
            ->where('unit', $unitCode)
            ->where('status', 'MENUNGGU_SOKONGAN_UNIT')
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function getPendingICTApprovals(): array
    {
        return $this->query()
            ->where('status', 'MENUNGGU_KELULUSAN_ICT')
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function getActiveLoans(): array
    {
        return $this->query()
            ->whereIn('status', ['DILULUSKAN', 'SEDANG_BERLANGSUNG'])
            ->orderBy('start_date', 'ASC')
            ->get();
    }

    public function getFilteredTickets(array $filters = [], int $page = 1, int $perPage = 15): array
    {
        $q = $this->query();

        if (!empty($filters['unit'])) {
            $q->where('unit', $filters['unit']);
        }

        if (!empty($filters['category'])) {
            $q->where('category', $filters['category']);
        }

        if (!empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        if (!empty($filters['user_id'])) {
            $q->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $search = strtolower(trim($filters['search']));
            // Perform custom filter on matching fields
            $all = $this->engine->read($this->collection);
            $filtered = array_filter($all, function ($item) use ($search, $filters) {
                if (!empty($filters['unit']) && ($item['unit'] ?? '') !== $filters['unit']) return false;
                if (!empty($filters['category']) && ($item['category'] ?? '') !== $filters['category']) return false;
                if (!empty($filters['status']) && ($item['status'] ?? '') !== $filters['status']) return false;
                if (!empty($filters['user_id']) && ($item['user_id'] ?? '') !== $filters['user_id']) return false;

                $haystack = strtolower(
                    ($item['reference_no'] ?? '') . ' ' .
                    ($item['applicant_name'] ?? '') . ' ' .
                    ($item['title'] ?? '') . ' ' .
                    ($item['purpose'] ?? '') . ' ' .
                    ($item['unit_name'] ?? '')
                );
                return str_contains($haystack, $search);
            });

            // Sort desc
            usort($filtered, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

            $total = count($filtered);
            $offset = ($page - 1) * $perPage;
            $items = array_slice($filtered, $offset, $perPage);
            $lastPage = (int) ceil($total / $perPage) ?: 1;

            return [
                'data' => $items,
                'total' => $total,
                'current_page' => $page,
                'per_page' => $perPage,
                'last_page' => $lastPage,
                'from' => $total === 0 ? 0 : $offset + 1,
                'to' => min($offset + $perPage, $total),
            ];
        }

        $q->orderBy('created_at', 'DESC');
        return $q->paginate($page, $perPage);
    }
}
