<?php

Breadcrumbs::for('admin.reference-numbers.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Reference Numbers', route('admin.reference-numbers.index'));
});

Breadcrumbs::for('admin.reference-numbers.create', function ($trail) {
    $trail->parent('admin.reference-numbers.index');
    $trail->push('Create New Reference Number', route('admin.reference-numbers.create'));
});
Breadcrumbs::for('admin.reference-numbers.edit', function ($trail, $id) {
    $trail->parent('admin.reference-numbers.index');
    $trail->push('Edit Reference Number', route('admin.reference-numbers.edit', ['id' => $id]));
});
Breadcrumbs::for('admin.reference-numbers.show', function ($trail, $id) {
    $trail->parent('admin.reference-numbers.index');
    $trail->push('View Reference Number', route('admin.reference-numbers.show', ['id' => $id]));
});