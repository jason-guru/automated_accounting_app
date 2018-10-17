<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Events\Backend\AccountStatus;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('clients', 'ClientController');

Route::get('client/search', 'ClientSearchController@show_search')->name('client.search');
Route::post('client/search/result', 'ClientSearchController@show_search_result')->name('client.search.result');
Route::get('client/search/contact-person', 'ClientSearchController@prep_contact_person_view')->name('client.search.contact_person');
Route::resource('clients', 'ClientController');

Route::get('deadlines/format', 'DeadlineController@format')->name('deadlines.format');
Route::post('deadlines/format/store-update', 'DeadlineController@format_store_update')->name('dealines.format.store_update');
//Route::get('deadlines/reminders', 'DeadlineController@reminders')->name('deadlines.reminders');
Route::get('deadlines/frequency', 'DeadlineController@frequency')->name('deadlines.frequency');
Route::post('deadlines/frequency/store', 'DeadlineController@frequency_store')->name('deadlines.frequency.store');
Route::resource('contact-person', 'ContactPersonController');
Route::get('contact-person/create/{id}', 'ContactPersonController@create_by_client')->name('contact-person.create_by_client');

Route::resource('reminders', 'ReminderController');
Route::resource('message-formats', 'MessageFormatController');
Route::resource('deadlines', 'DeadlineController');

// Test routes
Route::get('deadlines/test', function(){
    event(new AccountStatus());
});
