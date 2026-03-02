<?php

return [
    'super_admin' => [
        '*',
    ],
    'secretary' => [
        'members.manage',
        'families.manage',
        'schedules.manage',
        'prayer_requests.manage',
        'reports.view',
        'profile.manage',
        'audit_logs.view',
    ],
    'treasurer' => [
        'transactions.manage',
        'reports.view',
    ],
    'editor' => [
        'announcements.manage',
        'devotionals.manage',
        'gallery.manage',
        'sliders.manage',
    ],
    'user' => [
        // No admin permissions by default.
    ],
    // Permission to manage role & permissions UI
    'roles_manager' => [
        'roles.manage',
    ],
];
