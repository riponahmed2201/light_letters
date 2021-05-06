<?php
namespace App\Http\Controllers\AppProvider;
use App\Mail\ClientRegConfirm;
use App\Mail\ClientResetPassword;
use App\Mail\InviteCustomer;
use App\Models\ClientBilling;
use App\Models\ClientShipping;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentPackage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Faker\Provider\sr_RS\Payment as Sr_RSPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function getAllClients(){

        $clientData = allClient();
        return response()->json($clientData,200);
    }
    public function specificClient($client_id){
        $clientData = oneClient($client_id);
        return response()->json($clientData,200);
    }

    public function createClient(Request $request){

        $validatedData = $request->validate([
            'email' => 'required | unique:clients',
            'name' => 'required',
            'password'=> 'required'
        ]);
        $email = strtolower($request->email);
        $password = strtolower($request->password);
        $client = new Client;
        $client->name = $request->name;
        $client->email= $email;
        $client->phone = $request->phone;
        $client->password = Hash::make($password);
        $client->status= $request->status;
        $client->company= $request->company;
        $client->activation_status = 'activate';
        $client->role = $request->role;
        $client->company_address = $request->company_address;
        $client->company_reg_no = $request->company_reg_no;
        $client->company_bit_no = $request->company_bit_no;
        $client->company_contact_person = $request->company_contact_person;
        $client->contact_person_designation = $request->contact_person_designation;
        $client->number_of_employee = $request->number_of_employee;
        $client->save();
        Mail::to($client->email)->send(new ClientRegConfirm($client,$password));
        return response()->json(['status'=>'Created New Client','about-client'=>$client,'temporary-password' => $password],201);
    }
    public function updateClient(Request $request,$client_id){
        // $validatedData = $request->validate([
        //     'name' => 'required',
        // ]);
        $client = oneClient($client_id);
//        $client->name = $request->name;
//        $client->save();
        if ($request->hasFile('profile_picture')) {
            if($client->profile_picture == 'default_client.png'){
                $proPic = $request->file('profile_picture');
                $proPicName = $client_id.'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/client_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
            else{
                unlink(public_path('/uploads/client_pro_pic/'.$client->profile_picture));
                $proPic = $request->file('profile_picture');
                $proPicName = $client_id.'.'.$request->profile_picture->getClientOriginalExtension();
                $proPicPath = '/uploads/client_pro_pic/';
                $proPic->move(public_path($proPicPath), $proPicName);
            }
            Client::where('id', $client_id)->update([
                'profile_picture'=>$proPicName,
            ]);
            // return response()->json(['status'=>'Updated Client\'s Info','about-client'=>$client],201);
        }
        return response()->json(['status'=>'Updated Client\'s Info','about-client'=>$client],201);
    }
    public function updateClientAsAdmin(Request $request,$client_id){
        $validatedData = $request->validate([
            'company' => 'required',
            'name' => 'required',
        ]);
            $client = oneClient($client_id);
            $client->status = $request->status;
            $client->name = $request->name;
            $client->company = $request->company;
            $client->activation_status = $request->activation_status;
            $client->role = $request->role;
            $client->company_address = $request->company_address;
            $client->company_reg_no = $request->company_reg_no;
            $client->company_bit_no = $request->company_bit_no;
            $client->company_contact_person = $request->company_contact_person;
            $client->contact_person_designation = $request->contact_person_designation;
            $client->number_of_employee = $request->number_of_employee;
            $client->save();
            if(isset($client)){
                return response()->json(['status'=>'Updated Client\'s Info'],201);
            }
            else{
                return response()->json(['status'=>'Update Failed Client\'s Info'],400);
            }
    }
    public function removeClient($client_id)
    {
        $client = oneClient($client_id);
        $client->delete();
        return response()->json(['status'=>'Removed Client','about-client'=>$client],200);
    }
    //this feature is desabled.................................
    public function generateBill(Request $request){
        $shippingData = new ClientShipping;
        $shippingData->id = $request->id;
        $shippingData->billing_id = sprintf('B%05d', $request->id);
        $shippingData->s_name = $request->s_name;
        $shippingData->s_address = $request->s_address;
        $shippingData->s_city = $request->s_city;
        $shippingData->s_phone = $request->s_phone;
        $shippingData->s_country = $request->s_country;
        $shippingData->save();
        $billingData = new ClientBilling;
        $billingData->id = sprintf('B%05d', $request->id);
        $billingData->client_id = session('client_id');
        // $billingData->client_id = $request->client_id;
        $billingData->b_name = $request->b_name;
        $billingData->b_address = $request->b_address;
        $billingData->b_city = $request->b_city;
        $billingData->b_phone = $request->b_phone;
        $billingData->b_country = $request->b_country;
        $billingData->package = $request->package;
        $billingData->description = $request->description;
        $billingData->save();
        return response()->json(['billing info'=>$billingData,'shipping info'=>$shippingData],201);
    }
    public function getBillingData($id){
        $billingData = ClientBilling::where('id',$id)->first();
        return response()->json(['billing info'=>$billingData],200);
    }
    public function getShippingData($id){
        $shippingData = ClientShipping::where('id',$id)->first();
        return response()->json(['shipping info'=>$shippingData],200);
    }
    public function invoiceTableData($client_id){
        $data = oneClient($client_id);
        $billingData = ClientBilling::where('client_id',$client_id)->first();
        $paymentData = Payment::where('client_id',$client_id)->first();
        $dataArray = [
          'name' => $data->name,
            'email'=>$data->email,
            'description'=>$billingData->description,
            'date_of_purchase'=>$paymentData->date_of_purchase,
            'date_of_next_renewal'=>$paymentData->date_of_next_renewal,
        ];
        return response()->json($dataArray,200);
    }
    public function invoiceViewData($payment_id){
       // $data = Client::find($id);
        // $billingData = ClientBilling::where('client_id',$id)->first();
        // $shippingData = ClientShipping::where('billing_id',$billingData->id)->first();
        // $paymentData = Payment::where('client_id',$id)->first();
        $paymentData = Payment::where('id',$payment_id)->first();
        $description = PaymentPackage::where('package_name',$paymentData->type)->first();
        // $description = $paymentData->packagePayment()->where('package_name',$paymentData->type)->first();  =>its working
        $company = DB::table('companies')
        // ->join('clientbilling','clientbilling.client_id','=','clients.id')
        ->join('payments','payments.client_id','=','companies.client_id')
        ->select('companies.*')->where('companies.client_id','=',$paymentData->client_id)->first();
        $dataArray = [
            'payment_id' => $paymentData->id,
            'order_date'=>$paymentData->date_of_purchase,
            // 'shipping_address'=>$shippingData,
            'payment_address'=>$paymentData->address,
            'description'=>$description->short_description,
            'date_of_purchase'=>$paymentData->date_of_purchase,
            'date_of_next_renewal'=>$paymentData->date_of_next_renewal,
            'price'=>$paymentData->price,
            'company'=>$company
        ];
        return response()->json($dataArray,200);
    }
    public function invoiceAllData(){
        $data = DB::table('clients')
        // ->join('clientbilling','clientbilling.client_id','=','clients.id')
        ->join('payments','payments.client_id','=','clients.id')
        ->join('payment_packages','payment_packages.package_name','=','payments.type')
        ->select('payments.id','payments.name','clients.email','payment_packages.short_description','payments.date_of_purchase','payments.date_of_next_renewal')->get();
        return response()->json($data,200);
    }

    public function passwordChangeClientApi(Request $request,$client_id){
        $validatedData = $request->validate([
            'password'=> 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $client = oneClient($client_id);
        if(Hash::check($request->password, $client->password))
        {
            if ($request->new_password == $request->confirm_password){
                $client->update([
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
    public function inviteCustomer(Request $request){
        $error_msg = [];
        if ($request->email){  
            $receiver = json_decode(json_encode($request->email),true);
            foreach ($receiver as $rcv){
                if ($check = Customer::where('email',$rcv)->first()){
                    $error_msg[] = $rcv.' is exist as customer';
                }
                elseif ($chk = Contact::where('email',$rcv)->where('client_id','=',$request->client_id)->first()){
                   // Mail::to($rcv)->send(new InviteCustomer());
                    $error_msg[] = $rcv.' is already invited';
                }
                elseif ($chk = Contact::where('email',$rcv)->where('client_id','!=',$request->client_id)->first()){
                    //Mail::to($rcv)->send(new InviteCustomer());
                    $error_msg[] = 'invitation sent again to '.$rcv;
                    $inviteCust = new Contact();
                    $inviteCust->client_id = $request->client_id;
                    $inviteCust->email = $rcv;
                    $inviteCust->status = 'Invited';
                    $inviteCust->save();
                }
                else{
                    //Mail::to($rcv)->send(new InviteCustomer());
                    $inviteCust = new Contact();
                    $inviteCust->client_id = $request->client_id;
                    $inviteCust->email = $rcv;
                    $inviteCust->status = 'Invited';
                    $inviteCust->save();
                }
            }
        }
        if ($request->hasFile('csv_file')){
            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $csv_data = array_slice($data, 1);
            $allMail = [];
            foreach ($csv_data as $key => $d) {
                $oneEmail = implode(" ", $d);
                //---------------------------------
                if ($check = Customer::where('email',$oneEmail)->first()){
                    $error_msg[] = $oneEmail.' is exist as customer';
                }
                elseif ($chk = Contact::where('email',$oneEmail)->where('client_id','=',$request->client_id)->first()){
                    $allMail[] = $oneEmail;
                    $error_msg[] = $oneEmail.' is already invited';
                }
                elseif ($chk = Contact::where('email',$oneEmail)->where('client_id','!=',$request->client_id)->first()){
                    $allMail[] = $oneEmail;
                    $error_msg[] = 'invitation sent again to '.$oneEmail;
                    $inviteCust = new Contact();
                    $inviteCust->client_id = $request->client_id;
                    $inviteCust->email = $oneEmail;
                    $inviteCust->status = 'Invited';
                    $inviteCust->save();
                }
                else{
                    $allMail[] = $oneEmail;
                    $inviteCust = new Contact();
                    $inviteCust->client_id = $request->client_id;
                    $inviteCust->email = $oneEmail;
                    $inviteCust->status = 'Invited';
                    $inviteCust->save();
                }
            }
            \Illuminate\Support\Facades\Mail::send('invite_customer_mail', [], function($message) use ($allMail) {
                $message->to($allMail)->subject('Invitation From Light-Letter');
            });
        }
        return response()->json([
            'status'=>'Invited customer',
            'error_log' => $error_msg,
            ],201);
    }
    public function getInvitedContactList($client_id){
        $data = Contact::where('client_id',$client_id)->get();
        foreach ($data as $em){
            $custCheck = Customer::where('email',$em->email)->first();
            if ($custCheck != null){
                Contact::where('email',$em->email)->update([
                    'status' => 'Pending'
                ]);
            }
        }
        $dataNew = Contact::where('client_id', $client_id)->get();
        $customer = Customer::all();
        $all = $dataNew->merge($customer);
        $all = json_decode($all,true);
        usort($all, function($a, $b) {
                        $t1 = strtotime($a['created_at']);
                        $t2 = strtotime($b['created_at']);
                        return $t2 - $t1;                    
                    });
        return response()->json($all,200);
    }
    public function removeInvitedContact($contact_id){
        Contact::where('id',$contact_id)->delete();
        return response()->json('Contact Deleted',200);
    }
}
