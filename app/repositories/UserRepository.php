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
        $term = strtolower(trim($email));
        $user = $this->query()
            ->where('email', $term)
            ->first();

        if (!$user) {
            // Sokong carian melalui username atau alias pentadbir 'admin'
            $all = $this->query()->get();
            foreach ($all as $u) {
                if (strtolower($u['username'] ?? '') === $term || ($term === 'admin' && ($u['role'] ?? '') === 'ADMIN')) {
                    return $u;
                }
            }
        }

        return $user;
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

    /**
     * Search and filter users by keyword and unit
     */
    public function searchUsers(string $search = '', ?string $unitCode = null): array
    {
        $query = $this->query();

        if (!empty($unitCode)) {
            $query->where('unit', $unitCode);
        }

        $results = $query->orderBy('name', 'ASC')->get();

        if (!empty($search)) {
            $search = strtolower(trim($search));
            $results = array_filter($results, function ($user) use ($search) {
                return str_contains(strtolower($user['name'] ?? ''), $search)
                    || str_contains(strtolower($user['email'] ?? ''), $search)
                    || str_contains(strtolower($user['position'] ?? ''), $search)
                    || str_contains(strtolower($user['phone'] ?? ''), $search);
            });
            $results = array_values($results);
        }

        return $results;
    }
}
