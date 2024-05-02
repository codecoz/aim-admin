<?php

namespace CodeCoz\AimAdmin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\AttachmentUploadTrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

class AimAdminUser extends Authenticatable
{
    use Notifiable, HelperTrait, APITrait, AttachmentUploadTrait;

    protected $fillable = [
        'id',
        'user_name',
        'full_name',
        'email',
        'mobile_number',
        'is_active',
    ];

    public function hasRole($role): bool
    {

        $roles = [];
        $userRole = $this->roles();
        foreach ($userRole as $useRole) {
            $roles[] = $useRole['name'];
        }

        if (is_string($role)) {
            $role = explode('|', $role);
        }

        // Check if the input is not an array or a string, throw an exception or handle it accordingly
        if (!is_array($role)) {
            throw new \InvalidArgumentException("Role must be a string or an array.");
        }

        return !empty(array_intersect($role, $roles));
    }

    public function isSuperAdmin(): bool
    {
        $isAdmin = false;
        $userRole = $this->roles();
        foreach ($userRole as $role) {
            if ($role['name'] == "super-admin") {
                $isAdmin = true;
            }
        }
        return $isAdmin;
    }

    public function userImage(): ?string
    {
        return "";
    }

    public function roles(): array
    {
        return $this->setToArray($this->sessionCheck('role'));
    }

    /**
     * @throws NotFoundException
     */
    public function hasPermission(string $permission): bool
    {
        if (in_array($permission, $this->getPermissions())) {
            return true;
        }
        return false;
    }

    /**
     * @throws NotFoundException
     */
    public function permissions(): array
    {
        return $this->getPermissions();
    }

    public function roleHasUsers(array $roles = []): array
    {
        $roleUsers = $this->roleHasUserList();
        if (!empty($roles)) {
            return array_intersect_key($roleUsers, array_flip($roles));
        }
        return $roleUsers; // Return all users if no specific roles are provided
    }

}
