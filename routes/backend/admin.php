<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Events\Backend\ReminderEvent;
use Carbon\Carbon;
/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resources([
    'clients' => 'ClientController',
    'deadlines' => 'DeadlineController',
    'contact-person' => 'ContactPersonController',
    'reminders' => 'ReminderController',
    'reference-numbers' => 'ReferenceNumberController',
    'message-formats' => 'MessageFormatController'
]);

//Client Routes 
Route::get('client/search', 'ClientSearchController@show_search')->name('client.search');
Route::post('client/search/result', 'ClientSearchController@show_search_result')->name('client.search.result');
Route::get('client/search/contact-person', 'ClientSearchController@prep_contact_person_view')->name('client.search.contact_person');

//Deadline Routes
Route::put('deadlines/switch/update/{id}', 'DeadlineController@switch_update')->name('deadlines.switch.update');

//Contact Routes
Route::get('contact-person/create/{id}', 'ContactPersonController@create_by_client')->name('contact-person.create_by_client');

//Reminder Routes
Route::get('reminders/send/now', function(){
    event(new ReminderEvent());
    return back();
})->name('reminders.send.now');

//Environment Routes
Route::get('app-settings', 'AppSettingsController');

//Cache Routes
Route::get('/config-cache', function(){
	Artisan::call('config:cache');
});