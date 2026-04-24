<?php

namespace SOSEventsBV\CrownCms\Traits;

use Filament\Panel;
use SOSEventsBV\CrownCms\Enums\UserRole;

/**
 * @property bool $is_active
 * @property UserRole $role
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
        $this->mergeCasts(['role' => UserRole::class]);
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
     * @return UserRole
     */
    public function getRole(): UserRole
    {
        return $this->role;
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
