<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Events\Backend\ReminderEvent;
use App\Mail\Backend\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon;

/*
 * All route names are prefixed with 'admin.'.
 */
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('clients', 'ClientController');

Route::get('client/search', 'ClientSearchController@show_search')->name('client.search');
Route::post('client/search/result', 'ClientSearchController@show_search_result')->name('client.search.result');
Route::get('client/search/contact-person', 'ClientSearchController@prep_contact_person_view')->name('client.search.contact_person');

Route::get('deadlines/format', 'DeadlineController@format')->name('deadlines.format');
Route::post('deadlines/format/store-update', 'DeadlineController@format_store_update')->name('dealines.format.store_update');
//Route::get('deadlines/reminders', 'DeadlineController@reminders')->name('deadlines.reminders');
Route::get('deadlines/frequency', 'DeadlineController@frequency')->name('deadlines.frequency');
Route::post('deadlines/frequency/store', 'DeadlineController@frequency_store')->name('deadlines.frequency.store');
Route::put('deadlines/switch/update/{id}', 'DeadlineController@switch_update')->name('deadlines.switch.update');

Route::resource('contact-person', 'ContactPersonController');
Route::get('contact-person/create/{id}', 'ContactPersonController@create_by_client')->name('contact-person.create_by_client');

Route::resource('reminders', 'ReminderController');
Route::resource('message-formats', 'MessageFormatController');
Route::resource('deadlines', 'DeadlineController');
Route::get('app-settings', 'AppSettingsController');

// Test routes
Route::get('reminders/send/now', function(){
    $email_body = [
        'format' => "test test",
        'client_company_name' => "Oxmonk",
        'client_next_account' => "10-12-2019"
    ];
    Mail::to('jason@cobigent.com')->send(new ReminderMail($email_body));
    //return back()->withFlashSuccess('Reminders sent successfully');
})->name('reminders.send.now');

Route::get('/config-cache', function(){
	Artisan::call('config:cache');
});