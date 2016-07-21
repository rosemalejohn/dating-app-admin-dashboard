<?php

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', '/');
});

Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->push('Manage system users', '/users');
});

Breadcrumbs::register('users:show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push($user->name, '/users/' . $user->id);
});

Breadcrumbs::register('users:edit', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users:show', $user);
    $breadcrumbs->push('Edit', '/users/' . $user->id . '/edit');
});

Breadcrumbs::register('websites', function ($breadcrumbs) {
    $breadcrumbs->push('Manage websites', '/websites');
});

Breadcrumbs::register('websites:manage', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('websites');
    $breadcrumbs->push($website->name, '/websites/' . $website->id);
});

Breadcrumbs::register('websites:users', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('websites:manage', $website);
    $breadcrumbs->push('Users', '/websites/' . $website->id . '/users');
});

Breadcrumbs::register('settings', function ($breadcrumbs) {
    $breadcrumbs->push('Settings', '/settings');
});

Breadcrumbs::register('settings:system', function ($breadcrumbs) {
    $breadcrumbs->parent('settings');
    $breadcrumbs->push('System settings', '/settings/system');
});

Breadcrumbs::register('messages', function ($breadcrumbs) {
    $breadcrumbs->push('Messages', '/messages');
});
