<?php
declare(strict_types=1);

namespace App\Repositories;

/**
 * User Repository for Staff & Approvers
 */
class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function findByEmail(string $email): ?array
    {
        return $this->query()
            ->where('email', strtolower(trim($email)))
            ->first();
    }

    public function getByUnit(string $unitCode): array
    {
        return $this->query()
            ->where('unit', $unitCode)
            ->where('is_active', true)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function getApproversForUnit(string $unitCode): array
    {
        return $this->query()
            ->where('unit', $unitCode)
            ->where('role', 'KETUA_UNIT')
            ->where('is_active', true)
            ->get();
    }

    public function getICTStaff(): array
    {
        return $this->query()
            ->where('role', 'ADMIN')
            ->where('is_active', true)
            ->get();
    }
}
