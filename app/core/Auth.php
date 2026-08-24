<?php
declare(strict_types=1);

namespace App\Core;

use App\Repositories\UserRepository;

/**
 * Enterprise Authentication & RBAC Guard
 */
class Auth
{
    private const SESSION_USER_KEY = '_auth_user';

    /**
     * Get authenticated user array (always synchronized with latest storage data)
     */
    public static function user(): ?array
    {
        $cached = Session::get(self::SESSION_USER_KEY);
        if (!$cached || !isset($cached['id'])) {
            return null;
        }

        // Live synchronisation with database/JSON storage
        try {
            $userRepo = new UserRepository();
            $fresh = $userRepo->find($cached['id']);
            if ($fresh && ($fresh['is_active'] ?? true)) {
                unset($fresh['password']);
                Session::set(self::SESSION_USER_KEY, $fresh);
                return $fresh;
            }
        } catch (\Throwable $e) {
            // Fallback to cached session if storage is unavailable
        }

        return $cached;
    }

    /**
     * Get current user ID
     */
    public static function id(): ?string
    {
        $user = self::user();
        return $user['id'] ?? null;
    }

    /**
     * Check if user is logged in
     */
    public static function check(): bool
    {
        return self::user() !== null;
    }

    /**
     * Check if user has specific permission
     */
    public static function can(string $permission): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        $role = $user['role'] ?? 'STAF';
        $rolesConfig = app_config('roles.roles', []);
        $permissions = $rolesConfig[$role]['permissions'] ?? [];

        return in_array($permission, $permissions, true);
    }

    /**
     * Check if user is Admin
     */
    public static function isAdmin(): bool
    {
        $user = self::user();
        return ($user['role'] ?? '') === 'ADMIN';
    }

    /**
     * Check if user is Ketua Unit
     */
    public static function isKetuaUnit(): bool
    {
        $user = self::user();
        return ($user['role'] ?? '') === 'KETUA_UNIT';
    }

    /**
     * Check if user is ordinary Staf
     */
    public static function isStaf(): bool
    {
        $user = self::user();
        return ($user['role'] ?? '') === 'STAF';
    }

    /**
     * Get current user's unit code
     */
    public static function unit(): ?string
    {
        $user = self::user();
        return $user['unit'] ?? null;
    }

    /**
     * Log in a user
     */
    public static function login(array $user): void
    {
        // Never store raw password in session
        unset($user['password']);
        Session::set(self::SESSION_USER_KEY, $user);
    }

    /**
     * Log out current user
     */
    public static function logout(): void
    {
        Session::remove(self::SESSION_USER_KEY);
        Session::destroy();
    }
}
