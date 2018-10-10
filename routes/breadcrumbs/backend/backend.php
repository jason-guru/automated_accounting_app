<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.clients.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.clients.title'), route('admin.clients.index'));
});
Breadcrumbs::for('admin.clients.show', function ($trail, $id) {
    $trail->parent('admin.clients.index');
    $trail->push('View Client', route('admin.clients.show', ['id' => $id]));
});
Breadcrumbs::for('admin.clients.edit', function ($trail, $id) {
    $trail->parent('admin.clients.index');
    $trail->push('Edit Client', route('admin.clients.edit', ['id' => $id]));
});

Breadcrumbs::for('admin.client.search', function ($trail) {
    $trail->parent('admin.clients.index');
    $trail->push('Search', route('admin.client.search'));
});

Breadcrumbs::for('admin.client.search.result', function ($trail) {
    $trail->parent('admin.client.search');
    $trail->push('Details', route('admin.client.search.result'));
});

Breadcrumbs::for('admin.deadlines.information', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.deadlines.information.title'), route('admin.deadlines.information'));
});

Breadcrumbs::for('admin.deadlines.reminders', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.deadlines.reminders.title'), route('admin.deadlines.reminders'));
});

Breadcrumbs::for('admin.deadlines.frequency', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.deadlines.frequency.title'), route('admin.deadlines.frequency'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
