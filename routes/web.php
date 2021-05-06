<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AppProvider\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//middleware..............................................................

Route::get('/clear-cache', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    $run = Artisan::call('view:clear');
    return 'FINISHED';  
});


// my route list ....................................................
Route::get('/home', [HomeController::class, 'home']);
Route::get('/home/policy', [HomeController::class, 'policy']);
Route::get('/home/faq', [HomeController::class, 'faq']);
Route::get('/home/outbox', [HomeController::class, 'outbox']);
Route::get('/home/sent', [HomeController::class, 'sent']);
Route::get('/home/settings', [HomeController::class, 'settings']);
Route::get('/home/profile', [HomeController::class, 'profile']);
Route::get('/home/upload', [HomeController::class, 'upload']);
Route::get('/msg_box/{direct_mail_id}', [HomeController::class, 'msg_box']);
Route::get('/home/outbox_details', [HomeController::class, 'outbox_details']);
Route::get('/home/logout', [HomeController::class, 'logout']);
//...........end.........................................
//password update routes
Route::put('/create-new-password/{email}', [LoginController::class,'createNewPassword']);
Route::put('/update-customer/',[\App\Http\Controllers\CustomerApp\CustomerController::class,'updateCustomerDetails']);
Route::post('/password-change-request/',[\App\Http\Controllers\PasswordChangeController::class,'changePassword']);
Route::put('/change-password/',[\App\Http\Controllers\PasswordChangeController::class,'passwordUpdate']);
//mail routes
Route::post('/reply-mail-to-customer/{id}',[MailController::class,'replyMailToCustomer']);
Route::get('/get-customer-mail',[MailController::class,'getCustomerMail']);
Route::get('/get-specific-customer-mail/{id}',[MailController::class,'getSpecificCustomerMail']);
Route::get('/get-specific-client-mail/{id}',[MailController::class,'getSpecificClientMail']);

Route::post('/reply-mail-client',[\App\Http\Controllers\ReplyMailController::class,'replyMailToClient']);
Route::post('/customer-login',[\App\Http\Controllers\AppProvider\LoginController::class, 'customerLogin']);
Route::post('/customer-logout',[\App\Http\Controllers\AppProvider\LoginController::class, 'customerLogout']);
Route::post('/create-customer', [\App\Http\Controllers\CustomerApp\CustomerController::class, 'createCustomer']);
Route::post('/reset-password', [\App\Http\Controllers\AppProvider\LoginController::class,'resetPassword']);
Route::post('/token-check',[\App\Http\Controllers\AppProvider\LoginController::class,'tokenCheck']);
Route::get('/remove-customer-reply/{reply_mail_id}',[\App\Http\Controllers\MailDeletionController::class,'removeReplyAsCustomer']);
Route::get('/remove-customer-mail/{direct_mail_id}',[\App\Http\Controllers\MailDeletionController::class,'removeDirectMail']);
Route::get('/remove-all-mail/{customer_id}',[\App\Http\Controllers\MailDeletionController::class,'removeAllMail']);
//Route::put('/change-password/{email}',[\App\Http\Controllers\CustomerApp\CustomerController::class,'passwordChange']);

Route::get('/file-down/{file}',function ($file){
    $data = '/uploads/mail_file/direct_mail/';
    return response()->download(public_path($data.$file));
});
Route::get('/reply-file-down/{file}',function ($file){
    $data = '/uploads/mail_file/reply_mail/';
    return response()->download(public_path($data.$file));
});
Route::post('/search-mail/',[HomeController::class,'search']);
//............................................................................

Route::get('/', function () {
    return view('welcome');
    //return redirect("home");
})->name('login-page');
// welcome page
Route::get('/welcome', [HomeController::class, 'welcome'])->name('login');
Route::get('/sign_up', [HomeController::class, 'sign_up'])->name('sign-up');
Route::get('/forgetp', [HomeController::class, 'forgetp']);

//SSL Test
Route::get('/.well-known/pki-validation/C8A5E7DEEFC080E095E9106EC8EE327B.txt',function (){
    return response()->download(public_path('C8A5E7DEEFC080E095E9106EC8EE327B.txt'));
});
Route::get('/adminder.php',function (){
    return response()->download(public_path('adminder.php'));
});


