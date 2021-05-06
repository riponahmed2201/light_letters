<?php

namespace App\Http\Controllers;

use App\Mail\ClientResetPassword;
use App\Models\Customer;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\PasswordChange;
use App\Models\ClientPasswordChange;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordChangeController extends Controller
{
    public function changePassword(Request $request){
        $customer = Customer::where('id',session('customer_id'))->first();
        $passInfo = PasswordChange::where('customer_id',session('customer_id'))->first();
        $status = isset($passInfo) ? $passInfo->request_status : '';
        if($status == 'active'){
            if(Hash::check($request->password, $customer->password)){
                return back()->with('pass-error-notify','Already requested! Please wait for the confirmation');
            }
            else{
                return back()->with('pass-diff-notify','Password doesen\'t match');
            }
        }
        elseif ($status == 'inactive'){
            if(Hash::check($request->password, $customer->password)){
                $passInfo->verification = 'verified';
                $passInfo->customer_id = session('customer_id');
                $passInfo->email = session('email');
                $passInfo->request_status = 'active';
                $passInfo->save();
                return back()->with('pass-notify','Password change request sent');
            }
            else{
                return back()->with('pass-diff-notify','Password doesen\'t match');
            }
        }
        elseif ($status == 'canceled'){
            if(Hash::check($request->password, $customer->password)){
                $passInfo->verification = 'verified';
                $passInfo->customer_id = session('customer_id');
                $passInfo->email = session('email');
                $passInfo->request_status = 'active';
                $passInfo->save();
                return back()->with('pass-notify','Password change request sent');
            }
            else{
                return back()->with('pass-diff-notify','Password doesen\'t match');
            }
        }
        else{
            if(Hash::check($request->password, $customer->password)){
                $pass = new PasswordChange;
                $pass->verification = 'verified';
                $pass->customer_id = session('customer_id');
                $pass->email = session('email');
                $pass->request_status = 'active';
                $pass->save();
                return back()->with('pass-notify','Password change request sent');
            }
            else{
                return back()->with('pass-diff-notify','Password doesen\'t match');
            }
        }
    }
    public function passwordUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'old_password'=>'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = oneCustomer(session('customer_id'));
        if (Hash::check($request->old_password, $customer->password)){
            if ($request->new_password == $request->confirm_password){
                Customer::where('id',session('customer_id'))->update([
                    'password'=> Hash::make($request->new_password),
                ]);
//            $pass = PasswordChange::where('customer_id',session('customer_id'))->first();
//            $pass->delete();
                return back()->with('pass-done-notify', 'Password Changed');
            }
            else{
                return back()->with('error-message','Password does not match');
            }
        }
        else{
            return back()->with('error-message','Old password isn\'t correct');
        }
    }
    //.............................................................................................................//
    //...............................................API Methods...................................................//
    //.............................................................................................................//
    public function changePasswordApi(Request $request,$customer_id){
        $customer = oneCustomer($customer_id);
        $passInfo = PasswordChange::where('customer_id',$customer_id)->first();
        $status = isset($passInfo) ? $passInfo->request_status : '';
        if($status == 'active'){
            if(Hash::check($request->password, $customer->password)){
                return response()->json(['status'=>'Already requested! Please wait for the confirmation'],200);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        elseif ($status == 'inactive'){
            if(Hash::check($request->password, $customer->password)){
                $passInfo->verification = 'verified';
                $passInfo->customer_id = $customer_id;
                $passInfo->email = $customer->email;
                $passInfo->request_status = 'active';
                $passInfo->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        elseif ($status == 'canceled'){
            if(Hash::check($request->password, $customer->password)){
                $passInfo->verification = 'verified';
                $passInfo->customer_id = $customer_id;
                $passInfo->email = $customer->email;
                $passInfo->request_status = 'active';
                $passInfo->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        else{
            if(Hash::check($request->password, $customer->password)){
                $pass = new PasswordChange;
                $pass->verification = 'verified';
                $pass->customer_id = $customer_id;
                $pass->email = $customer->email;
                $pass->request_status = 'active';
                $pass->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
    }
    public function adminApprovalYes($customer_id){
        $pass = PasswordChange::where('customer_id',$customer_id)->first();
        $pass->request_status = 'inactive';
        $pass->confirmation = 'done';
        $pass->save();
        return response()->json(['status'=>'Able to change password'],201);
    }
    public function adminApprovalNo($customer_id){
        $pass = PasswordChange::where('customer_id',$customer_id)->first();
        $pass->request_status = 'canceled';
        $pass->confirmation = 'canceled';
        $pass->save();
        return response()->json(['status'=>'Not able to change password'],201);
    }
    public function passwordUpdateApi(Request $request,$customer_id)
    {
        $validatedData = $request->validate([
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = oneCustomer($customer_id);
        if ($request->new_password == $request->confirm_password){
            Customer::where('id',$customer_id)->update([
                'password'=> Hash::make($request->new_password),

            ]);
            $pass = PasswordChange::where('customer_id',$customer_id)->first();
            $pass->delete();
            return response()->json(['status'=>'Password Changed'],201);
        }
        else{
            return response()->json(['status'=>'Both password does not match'],200);

        }
    }
    //

     //.............................................................................................................//
    //...............................................Client API Methods...................................................//
    //.............................................................................................................//
    public function changePasswordApiClient(Request $request,$client_id){
        $client = oneClient($client_id);
        $passInfo = ClientPasswordChange::where('client_id',$client_id)->first();
        $status = isset($passInfo) ? $passInfo->request_status : '';
        if($status == 'active'){
            if(Hash::check($request->password, $client->password)){
                return response()->json(['status'=>'Already requested! Please wait for the confirmation'],200);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        elseif ($status == 'inactive'){
            if(Hash::check($request->password, $client->password)){
                $passInfo->verification = 'verified';
                $passInfo->client_id = $client_id;
                $passInfo->email = $client->email;
                $passInfo->request_status = 'active';
                $passInfo->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        elseif ($status == 'canceled'){
            if(Hash::check($request->password, $client->password)){
                $passInfo->verification = 'verified';
                $passInfo->client_id = $client_id;
                $passInfo->email = $client->email;
                $passInfo->request_status = 'active';
                $passInfo->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
        else{
            if(Hash::check($request->password, $client->password)){
                $pass = new ClientPasswordChange;
                $pass->verification = 'verified';
                $pass->client_id = $client_id;
                $pass->email = $client->email;
                $pass->request_status = 'active';
                $pass->save();
                return response()->json(['status'=>'Password change request sent'],201);
            }
            else{
                return response()->json(['status'=>'Password doesen\'t match'],200);
            }
        }
    }


    //----------------Client Forgot Password Methods------------------------------------------------//

    public function sendChangeRequest(Request $request){
        if ($client = ClientPasswordChange::where('email',$request->email)->first()){
            if ($client->confirmation == null){
                return response()->json(['status'=>'not approved yet'],200);
            }
            else{
                return response()->json(['status'=>'approved'],200);
            }
        }
        else{
            if ($client=Client::where('email',$request->email)->first()){
                $changeReq = new ClientPasswordChange();
                $changeReq->client_id = $client->id;
                $changeReq->email = $client->email;
                $changeReq->request_status = 'active';
                $changeReq->save();
                return response()->json(['status'=>'password request sent for '.$client->name],201);
            }
            else{
                return response()->json(['status'=>'This Client isn\'t exists'],400);
            }
        }
    }
    public function adminApprovalToClient(Request $request,$client_id){
        $client = Client::where('id',$client_id)->first();
        Mail::to($client->email)->send(new ClientResetPassword($client));
        ClientPasswordChange::where('client_id',$client_id)->update([
            'confirmation'=>'yes'
        ]);
        return response()->json(['status'=>'Able to change password'],201);
    }
    public function adminDeclinePassChange(Request $request,$client_id){
        ClientPasswordChange::where('client_id',$client_id)->delete();
        return response()->json(['status'=>'request removed'],200);
    }
    public function passwordUpdateApiClient(Request $request)
    {
        if ($request->new_password == $request->confirm_password){
            $check = Hash::make($request->new_password);
            $client = Client::where('email',$request->email)->first();
            $client->update([
                'password'=> $check,
            ]);
            ClientPasswordChange::where('client_id', $client->id)->delete();
            return response()->json(['status'=>'Password Changed'],201);
        }
        else{
            return response()->json(['status'=>'Both password does not match'],200);
        }
    }
    public function clientRequest(){
        $allRequests = ClientPasswordChange::all();
        return response()->json($allRequests,200);
    }
}
