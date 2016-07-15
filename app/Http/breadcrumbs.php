<?php

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', '/');
});

Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->push('Manage users', '/users');
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
