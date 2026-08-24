<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\UserRepository;
use App\Services\AuditService;
use App\Services\AuthService;

/**
 * User & Staff Management Controller (Full CRUD)
 */
class UserController extends BaseController
{
    private UserRepository $userRepo;
    private AuthService $authService;
    private AuditService $auditService;

    public function __construct(
        ?UserRepository $userRepo = null,
        ?AuthService $authService = null,
        ?AuditService $auditService = null
    ) {
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->authService = $authService ?? new AuthService();
        $this->auditService = $auditService ?? new AuditService();
    }

    /**
     * User Management Listing with Search & Filter
     */
    public function index(Request $request): void
    {
        $unitFilter = (string) $request->input('unit', '');
        $roleFilter = (string) $request->input('role', '');
        $search = strtolower(trim((string) $request->input('search', '')));

        $allUsers = $this->userRepo->all();

        // Apply filters
        $filtered = array_filter($allUsers, function ($u) use ($unitFilter, $roleFilter, $search) {
            if (!empty($unitFilter) && ($u['unit'] ?? '') !== $unitFilter) {
                return false;
            }
            if (!empty($roleFilter) && ($u['role'] ?? '') !== $roleFilter) {
                return false;
            }
            if (!empty($search)) {
                $haystack = strtolower(($u['name'] ?? '') . ' ' . ($u['email'] ?? '') . ' ' . ($u['position'] ?? ''));
                if (!str_contains($haystack, $search)) {
                    return false;
                }
            }
            return true;
        });

        $this->render('users/index', [
            'pageTitle' => 'Senarai Pengguna - ' . app_config('app.short_name'),
            'users' => array_values($filtered),
            'units' => app_config('units', []),
            'roles' => app_config('roles.roles', []),
            'unitFilter' => $unitFilter,
            'roleFilter' => $roleFilter,
            'search' => $search,
        ]);
    }

    /**
     * Show Create User Form
     */
    public function create(Request $request): void
    {
        $this->render('users/form', [
            'pageTitle' => 'Tambah Pengguna Baru - ' . app_config('app.short_name'),
            'user' => null,
            'units' => app_config('units', []),
            'roles' => app_config('roles.roles', []),
        ]);
    }

    /**
     * Store New User
     */
    public function store(Request $request): void
    {
        $data = $request->all();
        $name = trim((string)($data['name'] ?? ''));
        $email = strtolower(trim((string)($data['email'] ?? '')));
        $password = (string)($data['password'] ?? 'password123');
        $unit = (string)($data['unit'] ?? 'PENTADBIRAN');
        $role = (string)($data['role'] ?? 'STAF');
        $position = trim((string)($data['position'] ?? 'Pegawai'));
        $phone = trim((string)($data['phone'] ?? ''));

        if (empty($name) || empty($email)) {
            Session::flashInput($data);
            $this->redirect('/users/create', 'error', 'Sila lengkapkan nama penuh dan emel rasmi pengguna.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flashInput($data);
            $this->redirect('/users/create', 'error', 'Format emel tidak sah.');
        }

        // Check duplicate email
        $existing = $this->userRepo->findByEmail($email);
        if ($existing) {
            Session::flashInput($data);
            $this->redirect('/users/create', 'error', "Emel '{$email}' telah pun didaftarkan.");
        }

        $newUser = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password ?: 'password123', PASSWORD_DEFAULT),
            'role' => $role,
            'unit' => $unit,
            'position' => $position,
            'phone' => $phone,
            'is_active' => true,
        ];

        $created = $this->userRepo->create($newUser);
        $this->auditService->log(
            'USER_CREATED',
            "Pengguna baru didaftarkan: {$name} ({$email}) bagi Unit {$unit} dengan peranan {$role}"
        );

        $this->redirect('/users', 'success', "Pengguna {$name} telah berjaya didaftarkan.");
    }

    /**
     * Show Edit User Form
     */
    public function edit(Request $request, string $id): void
    {
        $userToEdit = $this->userRepo->find($id);
        if (!$userToEdit) {
            $this->abort(404, 'Pengguna tidak dijumpai.');
        }

        $this->render('users/form', [
            'pageTitle' => "Kemaskini Pengguna: {$userToEdit['name']} - " . app_config('app.short_name'),
            'user' => $userToEdit,
            'units' => app_config('units', []),
            'roles' => app_config('roles.roles', []),
        ]);
    }

    /**
     * Update Existing User
     */
    public function update(Request $request, string $id): void
    {
        $userToEdit = $this->userRepo->find($id);
        if (!$userToEdit) {
            $this->abort(404, 'Pengguna tidak dijumpai.');
        }

        $data = $request->all();
        $name = trim((string)($data['name'] ?? $userToEdit['name']));
        $email = strtolower(trim((string)($data['email'] ?? $userToEdit['email'])));
        $unit = (string)($data['unit'] ?? $userToEdit['unit']);
        $role = (string)($data['role'] ?? $userToEdit['role']);
        $position = trim((string)($data['position'] ?? $userToEdit['position']));
        $phone = trim((string)($data['phone'] ?? $userToEdit['phone']));
        $isActive = isset($data['is_active']) ? (bool)$data['is_active'] : ($userToEdit['is_active'] ?? true);

        if (empty($name) || empty($email)) {
            $this->redirect("/users/{$id}/edit", 'error', 'Sila lengkapkan nama dan emel.');
        }

        // Check if email changed and if new email already belongs to another user
        if ($email !== strtolower($userToEdit['email'])) {
            $checkEmail = $this->userRepo->findByEmail($email);
            if ($checkEmail && $checkEmail['id'] !== $id) {
                $this->redirect("/users/{$id}/edit", 'error', "Emel '{$email}' telah digunakan oleh pengguna lain.");
            }
        }

        $updatePayload = [
            'name' => $name,
            'email' => $email,
            'unit' => $unit,
            'role' => $role,
            'position' => $position,
            'phone' => $phone,
            'is_active' => $isActive,
        ];

        // If password is provided
        if (!empty($data['password'])) {
            $updatePayload['password'] = password_hash((string)$data['password'], PASSWORD_DEFAULT);
        }

        $updated = $this->userRepo->update($id, $updatePayload);
        $this->auditService->log(
            'USER_UPDATED',
            "Maklumat pengguna dikemaskini: {$name} ({$email})"
        );

        $this->redirect('/users', 'success', "Maklumat pengguna {$name} telah dikemaskini.");
    }

    /**
     * Delete User
     */
    public function delete(Request $request, string $id): void
    {
        $currentUser = Auth::user();
        if ($currentUser['id'] === $id) {
            $this->redirect('/users', 'error', 'Anda tidak boleh memadamkan akaun anda sendiri yang sedang log masuk.');
        }

        $userToDelete = $this->userRepo->find($id);
        if (!$userToDelete) {
            $this->redirect('/users', 'error', 'Pengguna tidak dijumpai.');
        }

        $this->userRepo->delete($id);
        $this->auditService->log(
            'USER_DELETED',
            "Pengguna dipadamkan: {$userToDelete['name']} ({$userToDelete['email']})"
        );

        $this->redirect('/users', 'success', "Pengguna {$userToDelete['name']} telah dipadamkan daripada sistem.");
    }

    /**
     * Toggle User Active Status
     */
    public function toggleStatus(Request $request, string $id): void
    {
        $currentUser = Auth::user();
        if ($currentUser['id'] === $id) {
            $this->redirect('/users', 'error', 'Anda tidak boleh menyahaktifkan akaun sendiri.');
        }

        $user = $this->userRepo->find($id);
        if (!$user) {
            $this->redirect('/users', 'error', 'Pengguna tidak dijumpai.');
        }

        $newStatus = !($user['is_active'] ?? true);
        $this->userRepo->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinyahaktifkan';
        $this->auditService->log(
            'USER_STATUS_TOGGLED',
            "Status pengguna {$user['name']} ditukar kepada {$statusText}"
        );

        $this->redirect('/users', 'info', "Status pengguna {$user['name']} telah {$statusText}.");
    }

    /**
     * Reset User Password to Default
     */
    public function resetPassword(Request $request, string $id): void
    {
        $user = $this->userRepo->find($id);
        if (!$user) {
            $this->redirect('/users', 'error', 'Pengguna tidak dijumpai.');
        }

        $newPass = (string) $request->input('new_password', 'password123');
        $this->userRepo->update($id, [
            'password' => password_hash($newPass, PASSWORD_DEFAULT),
        ]);

        $this->auditService->log(
            'USER_PASSWORD_RESET',
            "Kata laluan bagi pengguna {$user['name']} telah diset semula oleh pentadbir"
        );

        $this->redirect('/users', 'success', "Kata laluan bagi {$user['name']} telah diset semula kepada '{$newPass}'.");
    }

    /**
     * User Profile View
     */
    public function profile(Request $request): void
    {
        $user = Auth::user();

        $this->render('users/profile', [
            'pageTitle' => 'Profil Pengguna - ' . app_config('app.short_name'),
            'user' => $user,
            'units' => app_config('units', []),
        ]);
    }

    /**
     * Update Self Profile
     */
    public function updateProfile(Request $request): void
    {
        $user = Auth::user();
        $data = $request->all();

        $this->authService->updateProfile($user['id'], $data);
        $this->redirect('/profile', 'success', 'Maklumat profil anda telah berjaya dikemaskini.');
    }
}
