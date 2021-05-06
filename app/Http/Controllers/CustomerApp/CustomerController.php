<?php

namespace App\Http\Controllers\CustomerApp;
use App\Mail\CustomerRegConfirm;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DirectMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CustomerController extends Controller
{
    public function createCustomer(Request $request){
        $validatedData = $request->validate([
            'email' => 'required | unique:customers',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = new Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = strtolower($request->email);
        if ($request->password == $request->confirm_password){
            $customer->password = Hash::make($request->password);
        }
        $customer->status = 'Pending';
        $customer->save();
        if (Contact::where('email',$customer->email)->first()){
            Contact::where('email',$customer->email)->delete();
        }
        Mail::to($customer->email)->send(new CustomerRegConfirm($customer));
        $session = session([
            'customer_id' => $customer->id,
            'first_name'=>$customer->first_name,
            'last_name' =>$customer->last_name,
            'email'=> strtolower($request->email),
            'status'=> 'Pending',
            'profile_picture' => 'default_customer.png'
        ]);
        // return view('home.profile',compact('session'));
        return redirect('/home/profile')->with(['session' => $session]);
    }
    public function updateCustomerDetails(Request $request){

        // dd($request->all());

        $validatedData = $request->validate([
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        //Profile Picture Update Start------------------------------------------------------------------------------
        if ($request->hasFile('profile_picture')) {
            $data = oneCustomer(session('customer_id'));
            if($data->profile_picture == 'default_customer.png'){
                $proPic = $request->file('profile_picture');
                $proPicName = session('customer_id').'_0'.'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/customer_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
            else{
                unlink(public_path('/uploads/customer_pro_pic/'.$data->profile_picture));
                $proPic = $request->file('profile_picture');
                $proPicName = session('customer_id').'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/customer_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
//            $data->profile_picture= $proPicName;
//            $data->save();
            // dd($proPicName);
            Customer::where('id', session('customer_id'))->update([
                'profile_picture'=>$proPicName,
            ]);
            //        return response()->json(['status'=>'Its updated'],201);
        }
        //Profile Picture Update End--------------------------------------------------------------------------------
        //NID section
        if ($request->hasFile('nid')) {
            $cust = oneCustomer(session('customer_id'));
            if ($cust->nid == 'no_data'){
                $file = $request->file('nid');
                $fileName = session('customer_id').'.'.$request->nid->getClientOriginalExtension();
                $path = '/uploads/nid/';
                $file->move(public_path($path), $fileName);
                Customer::where('id', session('customer_id'))->update([
                    'nid'=>$fileName,
                    'id_type'=>$request->id_type,
                ]);
            }
            else{
                return back()->with('nid-error','You already submitted your NID');
            }
        }
        //R.A. file section
        if ($request->hasFile('ra_file')) {
            $cust = oneCustomer(session('customer_id'));
            if ($cust->ra_file == 'no_data'){
                $file = $request->file('ra_file');
                $fileName = session('customer_id').'.'.$request->ra_file->getClientOriginalExtension();
                $path = '/uploads/ra_file/';
                $file->move(public_path($path), $fileName);
                Customer::where('id', session('customer_id'))->update([
                    'ra_file'=>$fileName,
                    'ra_type'=>$request->ra_type,
                ]);
            }
            else{
                return back()->with('ra-file-error','You already submitted your residential address proof');
            }
        }
        $cust = oneCustomer(session('customer_id'));
        $cust->first_name = $request->first_name;
        $cust->last_name = $request->last_name;
        $cust->email = $request->email;
        $cust->road = $request->road;
        $cust->house = $request->house;
        $cust->city = $request->city;
        $cust->zip = $request->zip;
        $cust->country = $request->country;
        $cust->phone = $request->phone;

        if($request->check_customer_status == 'Verified'){
            $cust->status = "Pending";
        }
        $cust->save();
//        Customer::where('id', session('customer_id'))->update([
//            'first_name'=> $request->first_name,
//            'last_name'=> $request->last_name,
//            'email'=>$request->email,
//            'address'=>$request->address,
//            'phone'=>$request->phone,
//        ]);
//        return response()->json(['status'=>'Its updated'],201);
        return back()->with('update-notify','Your profile updated!');
    }
    // this feature had desabled .......................................................
    public function passwordChange(Request $request,$id){
        $validatedData = $request->validate([
            'password'=> 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = Customer::find($id);
        if(Hash::check($request->password, $customer->password))
        {
            if ($request->new_password == $request->confirm_password){
                $customer->update([
                    'password'=> Hash::make($request->new_password),
                ]);
//                return response()->json(['message'=>'Password Changed'],201);
                return back()->with('change-done-notify','Password changed successfully');
            }
//            return response()->json(['message'=>'Both password does not match'],400);
            return back()->with('both-not-match-notify','Both password does not match');
        }
        else{
//            return response()->json(['message'=>'Old password does not match'],400);
            return back()->with('old-not-match-notify','Old password does not match');
        }
    }//.............................................................................................................//
    //...............................................API Methods...................................................//
    //.............................................................................................................//
    public function getAllCustomer(){
        $customer = allCustomer();
        return response()->json($customer,200);
    }
    public function specificCustomer($customer_id){
        $customer = oneCustomer($customer_id);
        return response()->json($customer,200);
    }
    public function createCustomerApi(Request $request){
        $validatedData = $request->validate([
            'email' => 'required | unique:customers',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = new Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = strtolower($request->email);
        if ($request->password == $request->confirm_password){
            $customer->password =  Hash::make($request->password);
        }
        $customer->status = 'Pending';
        $customer->save();
        Mail::to($customer->email)->send(new CustomerRegConfirm($customer));
        $session = session([
            'customer_id' => $customer->id,
            'first_name'=>$customer->first_name,
            'last_name' =>$customer->last_name,
            'email'=> strtolower($request->email),
            'status'=> 'Pending',
            'profile_picture' => 'default_customer.png'
        ]);
        return response()->json([
            'customer_info' => $customer,
            'session'=>$session
        ],201);
    }
    public function updateCustomerDetailsApi(Request $request,$customer_id){
         $validatedData = $request->validate([
             'email' => 'required',
             'first_name' => 'required',
             'last_name' => 'required',
         ]);
        //Profile Picture Update Start------------------------------------------------------------------------------
        if ($request->hasFile('profile_picture')) {
            $data = oneCustomer($customer_id);
            if($data->profile_picture == 'default_customer.png'){
                $proPic = $request->file('profile_picture');
                $proPicName = $customer_id.'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/customer_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
            else{
                unlink(public_path('/uploads/customer_pro_pic/'.$data->profile_picture));
                $proPic = $request->file('profile_picture');
                $proPicName = $customer_id.'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/customer_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
            Customer::where('id', $customer_id)->update([
                'profile_picture'=>$proPicName,
            ]);

        }
        //Profile Picture Update End--------------------------------------------------------------------------------
        //NID section
        if ($request->hasFile('nid')) {
            $cust = oneCustomer(session('customer_id'));
            if ($cust->nid == 'no_data'){
                $file = $request->file('nid');
                $fileName = session('customer_id').'.'.$request->nid->getClientOriginalExtension();
                $path = '/uploads/nid/';
                $file->move(public_path($path), $fileName);
                Customer::where('id', session('customer_id'))->update([
                    'nid'=>$fileName,
                    'id_type'=>$request->id_type,
                ]);
            }
            else{
                return back()->with('nid-error','You already submitted your NID');
            }
        }
        //R.A. file section
        if ($request->hasFile('ra_file')) {
            $cust = oneCustomer(session('customer_id'));
            if ($cust->ra_file == 'no_data'){
                $file = $request->file('ra_file');
                $fileName = session('customer_id').'.'.$request->ra_file->getClientOriginalExtension();
                $path = '/uploads/ra_file/';
                $file->move(public_path($path), $fileName);
                Customer::where('id', session('customer_id'))->update([
                    'ra_file'=>$fileName,
                    'ra_type'=>$request->ra_type,
                ]);
            }
            else{
                return back()->with('ra-file-error','You already submitted your residential address proof');
            }
        }
        Customer::where('id', $customer_id)->update([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=>$request->email,
            'road'=>$request->road,
            'house'=>$request->house,
            'city'=>$request->city,
            'zip'=>$request->zip,
            'country'=>$request->country,
            'phone'=>$request->phone,
        ]);
        return response()->json(['status'=>'Profile updated'],201);
    }
    public function changeStatus(Request $request,$customer_id)
    {
        $customer = oneCustomer($customer_id);
        $customer->status = $request->status;
        $customer->comment = $request->comment;
        $customer->save();
        return response()->json($customer,201);
    }
    public function removeCustomer($customer_id){
        $customer = oneCustomer($customer_id);
        $customer->delete();
        return response()->json(['status'=>'Customer deleted'],200);
    }
    public function trashCustomer(Customer $customer)
    {
        $customer->delete();
        return response()->json(['status'=>'Customer '.$customer->email.' is going to trashed'],200);
    }

    public function restoreCustomer($customer_id)
    {
        $customer =Customer::withTrashed()
            ->where('id',$customer_id )
            ->restore();

        return response()->json(['status'=>'Customer is restored'],200);
    }

    public function customerlist()
    {
        $customer = Customer::withTrashed()->get();
        return response()->json($customer,200);
    }

    public function topCustomer()
    {
        // $data = DirectMail::select('receiver')
        // ->groupBy('receiver')
        // ->orderByRaw('COUNT(*) DESC')
        // ->first();
        $data = DB::table('directmail')
        ->select('receiver', DB::raw('count(*) as total'))
        ->groupBy('receiver')
        ->orderBy('total', 'desc')
        ->take(1)
        ->first();
        return response()->json($data, 200);
    }

    public function passwordChangeApi(Request $request,$customer_id){
        $validatedData = $request->validate([
            'password'=> 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $customer = oneCustomer($customer_id);
        if(Hash::check($request->password, $customer->password))
        {
            if ($request->new_password == $request->confirm_password){
                $customer->update([
                    'password'=> Hash::make($request->new_password),
                ]);
               return response()->json(['message'=>'Password Changed'],201);
                // return back()->with('change-done-notify','Password changed successfully');
            }
           return response()->json(['message'=>'Both password does not match'],400);
            // return back()->with('both-not-match-notify','Both password does not match');
        }
        else{
           return response()->json(['message'=>'Old password does not match'],400);
            // return back()->with('old-not-match-notify','Old password does not match');
        }
    }
}
