<?php

namespace App\Http\Controllers\AppProvider;
use App\Http\Controllers\Controller;
use App\Mail\AdminRegConfirm;
use App\Mail\AdminResetPassword;
use App\Mail\ClientAdminCreate;
use App\Mail\ClientResetPassword;
use App\Models\Admin;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminPasswordChange;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function createAdmin(Request $request){
        $validatedData = $request->validate([
            'email' => 'required | unique:admins',
            'name' => 'required',
            'password' => 'required',
        ]);
        $email = strtolower($request->email);
        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email= $email;
        $admin->password = Hash::make($request->password);
        $admin->role = $request->role;
        $admin->save();
        Mail::to($request->email)->send(new AdminRegConfirm($admin));
        return response()->json($admin,201);
    }
    public function clientCreateAdmin(Request $request){
        if (Client::where('email',$request->email)->first()){
            Client::where('email',$request->email)->update([
                'role'=> $request->role,
                'status'=> $request->status,
            ]);
            $info = Client::where('email',$request->email)->first();
            Mail::to($request->email)->send(new ClientAdminCreate($info));
            return response()->json('Added as admin',201);
        }
        else{
            $asClient = new Client;
            $asClient->name = $request->name;
            $asClient->email= strtolower($request->email);
            $asClient->password = Hash::make($request->password);
            $asClient->status= $request->status;
            $asClient->activation_status = $request->activation_status;
            $asClient->role = 'admin';
            $asClient->admin_id = null;
            $asClient->save();
            Mail::to($request->email)->send(new ClientAdminCreate($asClient));
            return response()->json($asClient,201);
        }
    }
    public function getAllAdmins(){
        $admin = allAdmins();
        return response()->json($admin,200);
    }
    public function getClientsAdmin($client_id){
        $admins = Client::where('id',$client_id)->where('role','admin')->orWhere('status', 'As Admin')->get();
        return response()->json($admins,200);
    }
    public function deleteClientAdmin($admin_id){
        $admin = Client::where('id', $admin_id)->delete();
        return response()->json($admin,200);
    }
    public function getAdmin($admin_id){
        $admin = oneAdmin($admin_id);
        return response()->json($admin,200);
    }
    public function removeAdmin($admin_id){
        $admin = Admin::where('id',$admin_id)->delete();
        return response()->json(['status'=>'Admin removed','about-admin'=>$admin],200);
    }

    //Admin forget password

    public function AdminSendChangeRequest(Request $request){
        if ($admin = AdminPasswordChange::where('email',$request->email)->first()){
            if ($admin->confirmation == null){
                return response()->json(['status'=>'not approved yet'],200);
            }
            else{
                return response()->json(['status'=>'approved'],200);
            }
        }
        else{
            if ($admin=Admin::where('email',$request->email)->first()){
                $changeReq = new AdminPasswordChange();
                $changeReq->admin_id = $admin->id;
                $changeReq->email = $admin->email;
                $changeReq->request_status = 'active';
                $changeReq->save();
                return response()->json(['status'=>'password request sent for '.$admin->name],201);
            }
            else{
                return response()->json(['status'=>'This Admin isn\'t exists'],400);
            }
        }
    }
    public function adminApproval(Request $request,$admin_id){
        $admin = Admin::where('id',$admin_id)->first();
        Mail::to($admin->email)->send(new AdminResetPassword($admin));
        AdminPasswordChange::where('admin_id',$admin_id)->update([
            'confirmation'=>'yes'
        ]);
        return response()->json(['status'=>'Able to change password'],201);
    }
    public function adminDecline(Request $request,$admin_id){
        AdminPasswordChange::where('admin_id',$admin_id)->delete();
        return response()->json(['status'=>'request removed'],200);
    }
    public function passwordUpdateApiAdmin(Request $request)
    {
        if ($request->new_password == $request->confirm_password){
            $check = Hash::make($request->new_password);
            $admin = Admin::where('email',$request->email)->first();
            $admin->update([
                'password'=> $check,
            ]);
            AdminPasswordChange::where('admin_id', $admin->id)->delete();
            return response()->json(['status'=>'Password Changed'],201);
        }
        else{
            return response()->json(['status'=>'Both password does not match'],200);
        }
    }
    public function AdminRequest(){
        $allRequests = AdminPasswordChange::all();
        return response()->json($allRequests,200);
    }
}
