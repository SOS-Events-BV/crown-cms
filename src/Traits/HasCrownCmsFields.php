<?php

namespace SOSEventsBV\CrownCms\Traits;

use Filament\Panel;

/**
 * @property bool $is_active
 */
trait HasCrownCmsFields
{
    /**
     * Initialize the trait and add is_active and role to fillable, so they can be changed in the Filament panel.
     *
     * @return void
     */
    protected function initializeHasCrownCmsFields(): void
    {
        $this->mergeFillable(['is_active', 'role']);
    }

    /**
     * Checks if the user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    public function getRoleConfig(): array
    {
        return config('crown-cms.roles.' . $this->role);
    }

    /**
     * Returns if the user is a super admin.
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return in_array($this->getRole(), ['admin', 'super_admin']);
    }

    /**
     * Returns if the user is an Admin.
     * @deprecated since 1.2, will be removed in 2.0. Please use $user->isSuperAdmin() instead.
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array($this->getRole(), ['admin', 'super_admin']);
    }

    /**
     * Returns if the user is an Editor.
     * @deprecated since 1.2, will be removed in 2.0. Please use $user->getRole() or $user->hasPermission() instead.
     * @return bool
     */
    public function isEditor(): bool
    {
        return $this->getRole() == 'editor';
    }

    /**
     * Returns if the user has permission to perform an action on a class.
     * @param string $class
     * @param string $action
     * @return bool
     */
    public function hasPermission(string $class, string $action): bool
    {
        if (empty($this->role)) return false;

        if ($this->getRoleConfig()['super_admin'] ?? false) return true;

        return in_array($action, $this->getRoleConfig()['permissions'][$class] ?? []);
    }

    /**
     * Checks if the user can access the CMS panel.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive();
    }
}
