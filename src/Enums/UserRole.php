<?php

namespace SOSEventsBV\CrownCms\Enums;

/**
 * @deprecated since 1.2, will be removed in 2.0. Roles are defined in config('crown-cms.roles'),
 * use $user->getRole() or $user->hasPermission() instead.
 * 
 * In version 2.0, roles will be defined in the database and can be managed through the admin panel.
 */
enum UserRole: string {
    case Admin = 'admin';
    case Editor = 'editor';
}
