<?php

use App\Http\Controllers\AppProvider\AdminController;
use App\Http\Controllers\AppProvider\ClientController;
use App\Http\Controllers\AppProvider\LoginController;
use App\Http\Controllers\AppProvider\TicketController;
use App\Http\Controllers\ClientApp\PaymentController;
use App\Http\Controllers\CustomerApp\CustomerController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMailController;
use App\Http\Controllers\TagController;
use \App\Http\Controllers\MailDeletionController;
use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//--------CORS POLICY-------------//
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT, POST, PATCH, DELETE, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Accept, Authorization, Content-Type, Origin, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
    header('Access-Control-Request-Headers: Accept, Authorization, Content-Type, Origin, X-Request-With');
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
Route::get('/run', function() {
    $exitCode = \Illuminate\Support\Facades\Artisan::call('config:cache');
    if (isset($exitCode)){
        return response()->json('cache clear',200);
    }
    else{
        return response()->json('error',200);
    }
});

Route::get('/test-api/{email}',function ($email){
    $data = strtolower($email);
    \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\InviteCustomer());
    return response()->json('Mail sent to '.$data,200);
});
Route::post('/test-csv/',function (Request $request) {
    if ($request->hasFile('csv_file')){
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 1);
        $allMail = [];
        foreach ($csv_data as $key => $d) {
            $oneEmail = implode(" ", $d);
            $allMail[] = $oneEmail;
        }
        \Illuminate\Support\Facades\Mail::send('invite_customer_mail', [], function($message) use ($allMail) {
            $message->to($allMail)->subject('CSV test');
        });
        return response()->json($allMail,200);
    }
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('mail-data',[\App\Http\Controllers\HomeController::class,'testClient']);
//Admin API.....................................................................................
Route::post('/admin-login',[LoginController::class,'adminLogin']);
Route::post('/admin-logout',[LoginController::class,'adminLogout']);
Route::post('/admin-create',[AdminController::class,'createAdmin']);
Route::get('/all-admin',[AdminController::class,'getAllAdmins']);
Route::get('/admin-view/{admin_id}',[AdminController::class,'getAdmin']);
Route::delete('/admin-remove/{admin_id}',[AdminController::class,'removeAdmin']);
Route::delete('/client-admin-remove/{admin_id}', [AdminController::class, 'deleteClientAdmin']);
Route::put('/customer-password-approval/{customer_id}',[\App\Http\Controllers\PasswordChangeController::class,'adminApprovalYes']);
Route::put('/customer-password-decline/{customer_id}',[\App\Http\Controllers\PasswordChangeController::class,'adminApprovalNo']);
Route::get('/action-required/',[MailController::class,'requiredAction']);
Route::post('/admin-reset-password/',[LoginController::class,'adminResetPassword']);
Route::get('/all-clients-admin/{client_id}',[AdminController::class,'getClientsAdmin']);
Route::post('/client-create-admin/',[AdminController::class,'clientCreateAdmin']);
//CustomerAuth API.................................................................................
Route::post('/customer-login',[LoginController::class, 'customerLoginApi']);
Route::post('/customer-logout',[LoginController::class, 'customerLogoutApi']);
Route::post('/create-customer', [CustomerController::class, 'createCustomerApi']);
Route::get('/specific-customer/{customer_id}',[CustomerController::class,'specificCustomer']);
Route::get('/customers/',[CustomerController::class,'getAllCustomer']);
Route::put('/change-status/{customer_id}',[CustomerController::class,'changeStatus']);
Route::delete('/customer-delete/{customer_id}',[CustomerController::class,'removeCustomer']);
Route::put('/update-customer/{customer_id}',[CustomerController::class,'updateCustomerDetailsApi']);
//Route::put('change-password/{id}',[CustomerController::class,'passwordChange']);
Route::get('/get-token',[CustomerController::class,'getToken']);
Route::put('/create-new-password/{email}', [LoginController::class,'createNewPassword']);

Route::post('/reply-mail-to-client/',[\App\Http\Controllers\ReplyMailController::class,'replyMailToClientApi']);
Route::get('/get-customer-mail/{customer_id}',[MailController::class,'getCustomerMail']);
Route::get('/get-specific-customer-mail/{direct_mail_id}',[MailController::class,'getSpecificCustomerMail']);
Route::post('/password-change-request/{customer_id}',[\App\Http\Controllers\PasswordChangeController::class,'changePasswordApi']);
Route::put('/change-password/{customer_id}',[\App\Http\Controllers\PasswordChangeController::class,'passwordUpdateApi']);
Route::delete('/customer-trash/{customer}',[CustomerController::class,'trashCustomer']);
Route::post('/reset-password', [LoginController::class,'resetPasswordApi']);
Route::post('/token-check',[LoginController::class,'tokenCheckApi']);
Route::put('/create-new-password/{email}', [LoginController::class,'createNewPasswordApi']);
Route::get('/restore-customer/{customer_id}',[CustomerController::class,'restoreCustomer']);
Route::delete('/remove-customer-reply/{reply_mail_id}',[MailDeletionController::class,'removeReplyAsCustomerApi']);
Route::delete('/remove-customer-mail/{direct_mail_id}',[MailDeletionController::class,'removeDirectMailApi']);
Route::delete('/remove-all-customer-mail/{customer_id}',[MailDeletionController::class,'removeAllCustomerMailApi']);
Route::get('/customerlist/',[CustomerController::class,'customerlist']); //with trashed customer
Route::put('/customer-pass-change/{customer_id}',[CustomerController::class,'passwordChangeApi']); //api

//Client API...................................................................................
Route::post('/client-login',[LoginController::class, 'clientLogin']);
Route::post('/client-logout',[LoginController::class, 'clientLogout']);
Route::get('/clients',[ClientController::class,'getAllClients']);
Route::post('/client-create', [ClientController::class, 'createClient']);
Route::post('/client-update/{client_id}',[ClientController::class,'updateClient']);
Route::get('/specific-client/{client_id}',[ClientController::class,'specificClient']);
Route::delete('/client-delete/{client_id}',[ClientController::class,'removeClient']);
Route::post('/client-generate-bill',[ClientController::class, 'generateBill']);
Route::get('/client-billing/{id}',[ClientController::class, 'getBillingData']);
Route::get('/client-shipping/{id}',[ClientController::class, 'getShippingData']);
Route::post('/send-mail-customer',[MailController::class,'sendMailToCustomer']);
Route::post('/reply-mail-to-customer/',[\App\Http\Controllers\ReplyMailController::class,'replyMailToCustomer']);
Route::get('/get-specific-client-mail/{client_mail_id}/{group_mail_id}',[MailController::class,'getSpecificClientMail']);
Route::get('/count-total-reply/{direct_mail_id}',[MailController::class,'countReplyMail']);
Route::get('/count-total-client-mail/{client_id}',[MailController::class,'countSpecificClientMail']);
Route::get('/count-direct-mail/',[MailController::class,'countDirectMail']);
Route::get('/count-total-customer-mail/{customer_id}',[MailController::class,'countSpecificCustomerMail']);
Route::delete('/remove-all-client-mail/{client_id}',[MailDeletionController::class,'removeClientMail']);
Route::delete('/remove-client-mail/{client_mail_id}/{group_mail_id}',[MailDeletionController::class,'removeOneClientMail']);
Route::delete('/remove-client-reply/{reply_mail_id}',[MailDeletionController::class,'removeClientReply']);
Route::get('/client-all-mail/{client_id}',[MailController::class,'getAllClientMail']);
Route::get('/calender-client-all-mail/{client_id}',[MailController::class,'getCalanderAllClientMail']);
Route::get('/client-all-mail-count/{client_id}',[MailController::class,'clientMailCount']);
Route::get('/count-total-client-reply/{client_mail_id}',[MailController::class,'countClientReplyMail']);
//client forgot password------------------------------//
Route::post('/client-password-change-request/',[\App\Http\Controllers\PasswordChangeController::class,'sendChangeRequest']);
Route::put('/client-password-approval/{client_id}',[\App\Http\Controllers\PasswordChangeController::class,'adminApprovalToClient']);
Route::get('/client-remove-pass-request/{client_id}',[\App\Http\Controllers\PasswordChangeController::class,'adminDeclinePassChange']);
Route::post('/client-change-password/',[\App\Http\Controllers\PasswordChangeController::class,'passwordUpdateApiClient']);
Route::get('/clients-pass-change-request/',[\App\Http\Controllers\PasswordChangeController::class,'clientRequest']);

Route::put('/client-info-change/{client_id}',[ClientController::class,'updateClientAsAdmin']);
Route::put('/client-pass-change/{client_id}',[ClientController::class,'passwordChangeClientApi']);
Route::get('/search-quick-reply/{client_id}',[MailController::class,'searchQuickReply']);
Route::get('/search-no-reply/{client_id}',[MailController::class,'searchNoReply']);
Route::get('/search-reminder/{client_id}',[MailController::class,'searchReminder']);
Route::put('/close-mail/{group_mail_id}',[MailController::class,'closeMail']);
Route::post('/close-mail-with-comment/{group_mail_id}',[MailController::class,'closeMailWithComment']);
Route::get('/responded-client-mail/{client_mail_id}',[MailController::class,'respondedClientMail']);
Route::get('/total-open-mail/{client_mail_id}',[MailController::class,'totalOpen']);
Route::post('/client-generate-password/',[LoginController::class,'clientResetPassword']);
Route::delete('/delete-specific-group-mail/{group_mail_id}',[MailDeletionController::class,'removeGroupMail']);
Route::post('/search-mail-date-wise/{client_id}',[MailController::class,'searchDateWise']);
Route::post('/invite-customer/',[ClientController::class,'inviteCustomer']);
Route::get('/get-contact-list/{client_id}',[ClientController::class,'getInvitedContactList']);
Route::delete('/delete-contact/{contact_id}',[ClientController::class,'removeInvitedContact']);
Route::post('/remove-group-member/',[GroupController::class,'removeMultipleData']);
//Ticket
Route::get('/all-ticket',[TicketController::class,'getTicket']);
Route::post('/create-ticket',[TicketController::class,'createTicket']);
Route::put('/change-ticket-status/{ticket_id}',[TicketController::class,'changeTicketStatus']);
Route::put('/comment-ticket/{ticket_id}',[TicketController::class,'commentTicket']);
Route::get('/clients-ticket/{client_id}',[TicketController::class,'clientsTicket']);
//payment
Route::post('/store-payment',[PaymentController::class,'storePayment']);
Route::get('/get-payment/{payment_id}',[PaymentController::class,'getPaymentById']);
Route::get('/get-client-payment/{client_id}',[PaymentController::class,'getPaymentById']);
Route::get('/get-payment-package',[PaymentController::class,'getPaymentPackages']);
Route::get('/get-payment-package/{name}',[PaymentController::class,'getPaymentPackageByName']);
Route::post('/store-payment-package',[PaymentController::class,'createPaymentPackages']);
Route::put('/update-payment-package/{package_id}',[PaymentController::class,'updatePaymentPackage']);
Route::delete('/delete-payment-package/{package_id}',[PaymentController::class,'destroyPackage']);

//invoice
Route::get('/invoice-table/{client_id}',[ClientController::class,'invoiceTableData']);
Route::get('/invoice-view/{payment_id}',[ClientController::class,'invoiceViewData']);
// Route::get('/all-invoice',[ClientController::class,'allInvoice']);
Route::get('/invoice-all',[ClientController::class,'invoiceAllData']); //invoice all data get

//group
Route::post('/create-group',[GroupController::class,'createGroup']);
Route::get('/all-group',[GroupController::class,'getAllGroups']);
Route::Put('/group-update/{group_id}',[GroupController::class,'updateGroup']);
Route::delete('/group-delete/{group_id}',[GroupController::class,'removeGroup']);
Route::get('/group/{group_id}',[GroupController::class,'getGroup']);
Route::get('/client-all-group/{client_id}',[GroupController::class,'getClientsGroup']);
Route::get('/client-all-group-mail/{client_id}',[GroupMailController::class,'getGroupMailByClient']);
Route::get('/specific-group-mail/{group_mail_id}',[GroupMailController::class,'specificGroupMail']);

//Tag
Route::post('/create-tag',[TagController::class,'addTag']);
Route::get('/tag-all',[TagController::class,'tagList']);
Route::Put('/tag-update/{tagname}',[TagController::class,'tagUpdate']);
Route::delete('/tag-delete/{tagname}',[TagController::class,'tagDelete']);
Route::get('/tag-edit/{tagname}',[TagController::class,'tagEdit']);

//Signature
Route::post('/create-signature',[\App\Http\Controllers\SignatureController::class,'addSignature']);
Route::get('/all-signature',[\App\Http\Controllers\SignatureController::class,'signatureList']);
Route::get('/clientSignature/{client_id}',[\App\Http\Controllers\SignatureController::class,'signatureEdit']);
Route::Put('/update-signature/{client_id}',[\App\Http\Controllers\SignatureController::class,'signatureUpdate']);
Route::delete('/delete-signature/{client_id}',[\App\Http\Controllers\SignatureController::class,'signatureDelete']);

//company
Route::post('/create-company',[\App\Http\Controllers\CompanyController::class,'createCompany']);
Route::get('/all-company',[\App\Http\Controllers\CompanyController::class,'getAllCompany']);
Route::put('/update-company/{company_id}',[CompanyController::class,'updateCompany']);
Route::delete('/delete-company/{company_id}',[CompanyController::class,'deleteCompany']);
Route::get('/test-company/{company_id}',[\App\Http\Controllers\CompanyController::class,'testCompany']);

//Schedule mail update
Route::get('/update-schedule/{schedule_mail_id}',[MailController::class,'scheduleUpdate']);
Route::get('/all-schedule-mail/',[MailController::class,'allScheduleMail']);
Route::get('/clients-schedule-mail/{client_id}',[MailController::class,'clientsSchedule']);
Route::get('/clients-all-filter-mail/{client_id}',[MailController::class,'clientsAllFilterData']);
Route::get('/specific-schedule-mail/{schedule_mail_id}', [MailController::class,'scheduleMailInfo']);
//testclient
Route::get('mail-data',[\App\Http\Controllers\HomeController::class,'testClient']);

//getreplyremainder
Route::get('/reply-remainder/{id}',[\App\Http\Controllers\HomeController::class,'getRemainderReply']);

//search by name
Route::get('/search/{name}',[\App\Http\Controllers\HomeController::class,'search']);

//Read Status Update
Route::put('/read-status-update/{direct_mail_id}',[MailController::class,'readStatusUpdateApi']);

Route::get('/top-customer/',function (){
    return response()->json(topCustomer(),200);
});
Route::get('/count-mail-data/',[MailController::class,'countInfo']);
// Route::get('/count-client-mail-data/{client_id}',[MailController::class,'countInfo']);
Route::get('/count-client-mail-data/{client_id}',[MailController::class,'countInfoClient']);
//Group Mail-----------------------------------------------------------------------------------
Route::get('/group-mail/{group_id}',[\App\Http\Controllers\GroupMailController::class,'groupMailTest']);
Route::get('/group-report/{group_mail_id}',[MailController::class,'reportGroupMail']);

//File Download API----------------------------------------------------------------------------
Route::get('/group-mail-file-down/{file_name}',function ($file_name){
    $data = '/uploads/mail_file/group_mail/';
    return response()->download(public_path($data.$file_name));
});
Route::get('/file-down/{file_name}',function ($file_name){
    $data = '/uploads/mail_file/direct_mail/';
    return response()->download(public_path($data.$file_name));
});
Route::get('/reply-file-down/{file_name}',function ($file_name){
    $data = '/uploads/mail_file/reply_mail/';
    return response()->download(public_path($data.$file_name));
});
Route::get('/customer-nid-down/{nid}',function ($nid){
    $data = '/uploads/nid/';
    return response()->download(public_path($data.$nid));
});

//Admin forgot password------------------------------//
Route::post('/admin-password-change-request/',[\App\Http\Controllers\AppProvider\AdminController::class,'AdminSendChangeRequest']);
Route::put('/admin-password-approval/{admin_id}',[\App\Http\Controllers\AppProvider\AdminController::class,'adminApproval']);
Route::get('/admin-remove-pass-request/{admin_id}',[\App\Http\Controllers\AppProvider\AdminController::class,'adminDecline']);
Route::post('/admin-change-password/',[\App\Http\Controllers\AppProvider\AdminController::class,'passwordUpdateApiAdmin']);
Route::get('/admins-pass-change-request/',[\App\Http\Controllers\AppProvider\AdminController::class,'AdminRequest']);





