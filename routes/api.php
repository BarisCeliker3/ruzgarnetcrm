<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;



/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/



// API Routes

Route::post('applicationFaults', [App\Http\Controllers\APIController::class, 'applicationFaults'])->name('applicationFaults');



Route::post('checker/timing', [App\Http\Controllers\APIController::class, 'check_customer'])->name('check.customer');

Route::post('checker/timing/ariza', [App\Http\Controllers\APIController::class, 'check_customer_ariza'])->name('check.customer.ariza');

Route::post('payment/get', [App\Http\Controllers\APIController::class, 'get_payment_list'])->name('get.payment.list');

Route::post('payment/pay', [App\Http\Controllers\APIController::class, 'pay'])->name('payment.pay');

Route::post('login', [App\Http\Controllers\APIController::class, 'login'])->name('api.login');

Route::post('add_decont', [App\Http\Controllers\APIController::class, 'add_decont'])->name('api.add.decont');
Route::post('/fcm-pong', [\App\Http\Controllers\Admin\FcmPongController::class, 'pong']);
Route::post('/send-message-notification', [\App\Http\Controllers\Admin\AppMessageController::class, 'sendMessageNotification']);

Route::post('/fcm/send', [\App\Http\Controllers\Admin\FcmManualController::class, 'send']);

Route::post('/send-alert', [\App\Http\Controllers\Admin\AlarmController::class, 'sendalert']);


Route::post('add_fault', [App\Http\Controllers\APIController::class, 'add_fault'])->name('api.add.fault');

Route::post('get_reference_code', [App\Http\Controllers\APIController::class, 'get_reference_code'])->name('api.get.reference_code');
Route::post('live-broadcaster', [\App\Http\Controllers\Admin\LivebroadcastController::class, 'sendAgoraCall'])->name('api.live-broadcaster');


Route::post('get_faults', [App\Http\Controllers\APIController::class, 'get_faults'])->name('api.get.faults');

Route::post('get_fault', [App\Http\Controllers\APIController::class, 'get_fault'])->name('api.get.fault');

Route::post('edit_fault', [App\Http\Controllers\APIController::class, 'edit_fault'])->name('api.edit.fault');

Route::post('search_fault', [App\Http\Controllers\APIController::class, 'search_fault'])->name('api.search.fault');

Route::post('add_application', [App\Http\Controllers\APIController::class, 'add_application'])->name('api.add.application');

Route::post('get_fault_with_serial_number', [App\Http\Controllers\APIController::class, 'get_fault_with_serial_number'])->name('api.get.fault_with_serial_number');

Route::post('send_sms', [App\Http\Controllers\APIController::class, 'send_sms'])->name('api.send_sms');



Route::post('loginapp', [App\Http\Controllers\APIController::class, 'loginapp'])->name('loginapp');

Route::post('filtercheck', [App\Http\Controllers\APIController::class, 'filtercheck'])->name('filtercheck');

Route::post('changePassword', [App\Http\Controllers\APIController::class, 'changePassword'])->name('changePassword');



Route::post('reset-password-with-code', [App\Http\Controllers\APIController::class, 'resetWithCode'])->name('resetWithCode');

Route::post('send-reset-code', [App\Http\Controllers\APIController::class, 'sendResetCode'])->name('sendResetCode');

Route::post('appnotis', [App\Http\Controllers\APIController::class, 'appnotis'])->name('appnotis');

Route::post('appstorecustomer', [App\Http\Controllers\APIController::class, 'appstorecustomer'])->name('appstorecustomer');


Route::post('customercheck', [App\Http\Controllers\APIController::class, 'customercheck'])->name('customercheck');

Route::post('wifi-status', [App\Http\Controllers\Admin\WifiStatusController::class, 'index']);




Route::post('contents', [App\Http\Controllers\APIController::class, 'getcontents'])->name('customercheck');



// API Routes End



// API Routes End

