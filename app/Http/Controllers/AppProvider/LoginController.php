<?php
namespace App\Http\Controllers\AppProvider;
use App\Mail\ClientResetPassword;
use App\Models\Admin;
use App\Models\DirectMail;
use App\Models\Customer;
use App\Models\PasswordChange;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    //Client Login Activity..................................................................
    public function clientLogin(Request $request){

        if ($client = Client::where('email',$request->email)->first()) {
            if(Hash::check($request->password, $client->password)) {
                if ($client->activation_status == 'activate'){
                    if($clt = Admin::where('email',$request->email)->first()){
                        return response()->json([
                            "login_status" => "success",
                            'client_id'=>$client->id,
                            'client_name'=> $client->name,
                            'client_email'=> $client->email,
                            'client_status'=> $client->status,
                            'client_picture'=> $client->profile_picture,
                            'role'=> $client->role,
                            'admin_status'=> true
                        ], 200);
                    }
                    else{
                        return response()->json([
                            "login_status" => "success",
                            'client_id'=>$client->id,
                            'client_name'=> $client->name,
                            'client_email'=> $client->email,
                            'client_status'=> $client->status,
                            'client_picture'=> $client->profile_picture,
                            'role'=> $client->role,
                            'admin_status'=> false
                        ], 200);
                    }
                }
                if ($client->activation_status == 'deactivate'){
                    return response()->json([
                        "login_status" => "deactivated",
                        'client_id'=>$client->id,
                        'client_name'=> $client->name,
                        'client_email'=> $client->email,
                        'client_status'=> $client->status,
                        'client_picture'=> $client->profile_picture,
                    ], 200);
                }
            }
            else {
                return response()->json([
                    'message','Wrong Password'], 200);
            }
        }
        else {
            return response()->json([
                'message','Please give the valid information'], 200);
        }
    }
    //Client LogOut Activity.................................................................
    public function clientLogout(){
        session()->forget(['client_id','client_name']);
        return response()->json([
            "message" => "logout success"], 200);
    }
    //Admin Login Activity...................................................................
    public function adminLogin(Request $request){
        if ($admin = Admin::where('email',$request->email)->first()) {
            if(Hash::check($request->password, $admin->password)) {
                // $session = session(['admin_id' => $admin->id,'admin_name'=> $admin->name]);
                return response()->json([
                    "status" => "Login Success",
                    'admin_id'=>$admin->id,
                    'admin_name'=> $admin->name,
                    'admin_email'=> $admin->email,
                    'admin_picture'=> $admin->profile_picture,
                    'admin_role'=> $admin->role,
                    ], 200);
            }
            else {
                return response()->json([
                    'message','Wrong Password'], 200);
            }
        }
        else {
            return response()->json([
                'message','Please give the valid information'], 200);
        }
    }
    //Admin Logout Activity...................................................................
    public function adminLogout(){
        session()->forget(['admin_id','admin_name']);
        return response()->json([
            "message" => "logout success"], 200);
    }
    //CustomerAuth Login Activity..................................................................
    public function customerLogin(Request $request){

        $email = strtolower($request->email);
        if ($customer = Customer::where('email',$email)->first()) {
//            $passInfo = PasswordChange::where('customer_id',$customer->id)->first();
//            $confirm = isset($passInfo) ? $passInfo->confirmation : '';
            if(Hash::check($request->password, $customer->password)) {
                $session = session([
                    'customer_id' => $customer->id,
//                    'pass_confirm'=>$confirm,
                    'email'=> $email,
                ]);
                return view('home.dashboard');
            }
            else {
                return back()->with('message_pass','Wrong Password');
            }
        }
        else {
            return back()->with('message_email','Please give the valid email');
        }
    }
    public function customerLoginApi(Request $request){
        $email = strtolower($request->email);
        if ($customer = Customer::where('email',$email)->first()) {
//            $passInfo = PasswordChange::where('customer_id',$customer->id)->first();
//            $confirm = isset($passInfo) ? $passInfo->confirmation : '';
            if(Hash::check($request->password, $customer->password)) {
                $session = session([
                    'customer_id' => $customer->id,
//                    'pass_confirm'=>$confirm,
                    'email'=> $email,
                ]);
                    return response()->json([
                        'status'=>'login success',
                        'customer_id' => $customer->id,
                        "session" => $session,
//                        'pass_confirm'=>$confirm,
                        'email'=> $email
                     ], 200);
            }
            else {
                return response()->json([
                    'message','Wrong Password'], 400);

            }
        }
        else {
            return response()->json([
                'message','Please give the valid email'], 200);
        }
    }
    //CustomerAuth LogOut Activity..............................................................
    public function customerLogout(){
        session()->forget([
            'customer_id',
            'pass_confirm',
            'email'
        ]);
        return redirect('/');
    }
    public function customerLogoutApi(){
        session()->forget([
            'customer_id',
            'pass_confirm',
            'email'
        ]);
        return response()->json([
            "message" => "logout success"], 200);
//        return redirect('/');
    }
    // Reset/Forget Password.................................................................

    public function generateToken(){
        $token = Str::random(6);
        return $token;
    }
    //--for customer app---------------------
    public function resetPassword(Request $request){
        $customer = Customer::where('email',$request->email)->first();
        if($customer->email == $request->email){
            $token = $this->generateToken();
            session(['token'=>$token]);
            Mail::to($request->email)->send(new ResetPassword($token));
            $email = $request->email;
            return view('token_check',compact('email'));
        }
        else{
            return back()->with('error-message','This email isn\'t valid.');
        }
    }
    //--for customer mobile app---------------------
    public function resetPasswordApi(Request $request){
        $customer = Customer::where('email',$request->email)->first();
        if($customer->email == $request->email){
            $token = $this->generateToken();
            session(['token'=>$token]);
            Mail::to($request->email)->send(new ResetPassword($token));
            $email = $request->email;
//            view('token_check',compact('email'));
            return response()->json([
                'status'=>'Token Sent To Given Email',
                'Email'=>$email,
                'Token'=>$token
            ],200);
        }
        else{
            return response()->json(['error-message'=>'This email isn\'t valid.'],400);
        }
    }
    //----for admin management app-----------------
    public function adminResetPassword(Request $request){
        $client = Admin::where('email',$request->email)->first();
        if($client->email == $request->email){
            $token = $this->generateToken();
            session(['token'=>$token]);
            Mail::to($request->email)->send(new ClientResetPassword($token));
            $email = $request->email;
//            view('token_check',compact('email'));
            Admin::where('email',$email)->update([
                'password'=> Hash::make($token),
            ]);
            return response()->json([
                'status'=>'Token Sent To Given Email',
                'Email'=>$email,
                'new_password'=>$token
            ],200);
        }
        else{
            return response()->json(['error-message'=>'This email isn\'t valid.'],400);
        }
    }
    //--for client app---------------------
    public function clientResetPassword(Request $request){
        $client = Client::where('email',$request->email)->first();
        if($client->email == $request->email){
            $token = $this->generateToken();
            session(['token'=>$token]);
            Mail::to($request->email)->send(new ClientResetPassword($token));
            $email = $request->email;
//            view('token_check',compact('email'));
            Client::where('email',$email)->update([
                'password'=> Hash::make($token),
            ]);
            return response()->json([
                'status'=>'Token Sent To Given Email',
                'Email'=>$email,
                'new_password'=>$token
            ],200);
        }
        else{
            return response()->json(['error-message'=>'This email isn\'t valid.'],400);
        }
    }
    // for customer app------------------------
    public function tokenCheck(Request $request){
        $tokenold = session('token');
        $token = $request->token;
        $email = $request->email;
        if($token == $request->token){
            return view('create_password',compact('email'));
        }
        else{
            return back()->with('error-message','Token is not correct');
        }
    }
    // for customer mobile app------------------------
    public function tokenCheckApi(Request $request){
        $tokenold = session('token');
        $token = $request->token;
        $email = $request->email;
        if($token == $request->token){
            return response()->json([
                'status'=>'Token Matched',
                'Token'=>$token,
                'Email'=>$email
            ],200);
        }
        else{
            return response()->json(['error-message'=>'This token isn\'t correct.'],400);
        }
    }
    public function createNewPassword(Request $request,$email)
    {
        $validatedData = $request->validate([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = Customer::where('email', $email)->first();
            if ($request->password == $request->confirm_password){
                Customer::where('email',$email)->update([
                    'password'=> Hash::make($request->password),
                ]);
                return redirect('/');
            }
            else{
                return back()->with('error-message','password does not match');
        }
    }
    public function createNewPasswordApi(Request $request,$email)
    {
        $validatedData = $request->validate([
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = Customer::where('email', $email)->first();
        if ($request->password == $request->confirm_password){
            Customer::where('email',$email)->update([
                'password'=> Hash::make($request->password),
            ]);
             return response()->json(['message'=>'Password Changed'],201);
        }
        else{
             return response()->json(['message'=>'Both password does not match'],400);
        }
    }

}
