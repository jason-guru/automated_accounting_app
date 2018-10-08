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

Route::get('deadlines/information', 'DeadlineController@information')->name('deadlines.information');
Route::get('deadlines/reminders', 'DeadlineController@reminders')->name('deadlines.reminders');
