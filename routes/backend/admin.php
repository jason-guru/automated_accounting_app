<?php

use App\Http\Controllers\Backend\DashboardController;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('clients', 'ClientController');

Route::get('client/search', 'ClientSearchController@show_search')->name('client.search');
Route::post('client/search/result', 'ClientSearchController@show_search_result')->name('client.search.result');
Route::resource('clients', 'ClientController');

Route::get('deadlines/format', 'DeadlineController@format')->name('deadlines.format');
Route::post('deadlines/format/store-update', 'DeadlineController@format_store_update')->name('dealines.format.store_update');
Route::get('deadlines/reminders', 'DeadlineController@reminders')->name('deadlines.reminders');
Route::get('deadlines/frequency', 'DeadlineController@frequency')->name('deadlines.frequency');
Route::post('deadlines/frequency/store', 'DeadlineController@frequency_store')->name('deadlines.frequency.store');

// Test routes
Route::get('deadlines/test', 'DeadlineController@reminder_manager');
