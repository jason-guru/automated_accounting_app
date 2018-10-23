<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.clients.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.clients.title'), route('admin.clients.index'));
});

Breadcrumbs::for('admin.clients.create', function ($trail) {
    $trail->parent('admin.clients.index');
    $trail->push('Create Client', route('admin.clients.create'));
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

Breadcrumbs::for('admin.contact-person.create_by_client', function ($trail, $id) {
    $trail->parent('admin.clients.index');
    $trail->push('Edit Contact Person', route('admin.contact-person.create_by_client', ['id' => $id]));
});

Breadcrumbs::for('admin.contact-person.edit', function ($trail, $id) {
    $trail->parent('admin.clients.index');
    $trail->push('Edit Contact Person', route('admin.contact-person.edit', ['id' => $id]));
});
Breadcrumbs::for('admin.contact-person.show', function ($trail, $id) {
    $trail->parent('admin.clients.index');
    $trail->push('Show Contact Person', route('admin.contact-person.show', ['id' => $id]));
});

Breadcrumbs::for('admin.deadlines.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push("Manage Deadlines", route('admin.deadlines.index'));
});

Breadcrumbs::for('admin.deadlines.create', function ($trail) {
    $trail->parent('admin.deadlines.index');
    $trail->push("Create Deadline", route('admin.deadlines.create'));
});
Breadcrumbs::for('admin.deadlines.edit', function ($trail, $id) {
    $trail->parent('admin.deadlines.index');
    $trail->push("Edit Deadline", route('admin.deadlines.edit', ['id' => $id]));
});
Breadcrumbs::for('admin.deadlines.show', function ($trail, $id) {
    $trail->parent('admin.deadlines.index');
    $trail->push("View Deadline", route('admin.deadlines.show', ['id' => $id]));
});

Breadcrumbs::for('admin.reminders.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.deadlines.reminders.title'), route('admin.reminders.index'));
});

Breadcrumbs::for('admin.reminders.create', function ($trail) {
    $trail->parent('admin.reminders.index');
    $trail->push('Create Reminder', route('admin.reminders.create'));
});

Breadcrumbs::for('admin.reminders.show', function ($trail, $id) {
    $trail->parent('admin.reminders.index');
    $trail->push('Create Reminder', route('admin.reminders.show', ['id' => $id]));
});

Breadcrumbs::for('admin.reminders.edit', function ($trail, $id) {
    $trail->parent('admin.reminders.index');
    $trail->push('Edit Reminder', route('admin.reminders.edit', ['id' => $id]));
});

Breadcrumbs::for('admin.deadlines.frequency', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('strings.backend.deadlines.frequency.title'), route('admin.deadlines.frequency'));
});

Breadcrumbs::for('admin.message-formats.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Message Formats', route('admin.message-formats.index'));
});

Breadcrumbs::for('admin.message-formats.create', function ($trail) {
    $trail->parent('admin.message-formats.index');
    $trail->push('Create New format', route('admin.message-formats.create'));
});
Breadcrumbs::for('admin.message-formats.edit', function ($trail, $id) {
    $trail->parent('admin.message-formats.index');
    $trail->push('Edit New format', route('admin.message-formats.edit', ['id' => $id]));
});
Breadcrumbs::for('admin.message-formats.show', function ($trail, $id) {
    $trail->parent('admin.message-formats.index');
    $trail->push('View Format', route('admin.message-formats.show', ['id' => $id]));
});
Breadcrumbs::for('admin.sms-config.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('SMS Configuration', route('admin.sms-config.index'));
});


require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
