<?php

namespace App\Http\Controllers\ClientApp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentPackage;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function storePayment(Request $request){
       if ($request->type == 'Starter')
       {
        $payment = new Payment;
//        $payment->client_id = session('client_id');
        $payment->client_id = $request->client_id;
        $payment->name = $request->name;
        $payment->address= $request->address;
        $payment->city = $request->city;
        $payment->zip = $request->zip;
        $payment->country = $request->country;
        $payment->card_number = $request->card_number;
        $payment->card_holder_name = $request->card_holder_name;
        $payment->expire_date = Carbon::now()->add(30, 'day');
        $payment->cvv = $request->cvv;
        $payment->type = 'Starter';
        $payment->price = 8;
        $payment->date_of_purchase = Carbon::now();
        $payment->date_of_next_renewal = Carbon::now()->add(29, 'day');
        $payment->save();
        return response()->json($payment,201);
       }
       elseif ($request->type == 'Professional')
       {
        $payment = new Payment;
        $payment->client_id =  $request->client_id;
        $payment->name = $request->name;
        $payment->address= $request->address;
        $payment->city = $request->city;
        $payment->zip = $request->zip;
        $payment->country = $request->country;
        $payment->card_number = $request->card_number;
        $payment->card_holder_name = $request->card_holder_name;
        $payment->expire_date = Carbon::now()->add(30, 'day');
        $payment->cvv = $request->cvv;
        $payment->type = 'Professional';
        $payment->price = 18;
        $payment->date_of_purchase = Carbon::now();
        $payment->date_of_next_renewal = Carbon::now()->add(29, 'day');
        $payment->save();
        return response()->json($payment,201);
       }
//       elseif ($request->type == 'Advanced')
       else
       {
        $payment = new Payment;
        $payment->client_id =  $request->client_id;
        $payment->name = $request->name;
        $payment->address= $request->address;
        $payment->city = $request->city;
        $payment->zip = $request->zip;
        $payment->country = $request->country;
        $payment->card_number = $request->card_number;
        $payment->card_holder_name = $request->card_holder_name;
        $payment->expire_date = Carbon::now()->add(30, 'day');
        $payment->cvv = $request->cvv;
        $payment->type = 'Advanced';
        $payment->price = 48;
        $payment->date_of_purchase = Carbon::now();
        $payment->date_of_next_renewal = Carbon::now()->add(29, 'day');
        $payment->save();
        return response()->json($payment,201);
       }
//       else
//       {
//        $payment = new Payment;
//        $payment->client_id = session('client_id');
//        $payment->name = $request->name;
//        $payment->address= $request->address;
//        $payment->city = $request->city;
//        $payment->zip = $request->zip;
//        $payment->country = $request->country;
//        $payment->card_number = $request->card_number;
//        $payment->card_holder_name = $request->card_holder_name;
//        $payment->expire_date = Carbon::now()->add(30, 'day');
//        $payment->cvv = $request->cvv;
//        $payment->type = 'Free Trial';
//        $payment->price = 0;
//        $payment->date_of_purchase = Carbon::now();
//        $payment->date_of_next_renewal = Carbon::now()->add(29, 'day');
//        $payment->save();
//        return response()->json($payment,201);
//       }
    }
    public function getPaymentById($payment_id){
        $payment = Payment::where('id',$payment_id)->first();
        return response()->json($payment,200);
    }
    public function getClientPayment($client_id){
        $payment = Payment::where('client_id',$client_id)->first();
        return response()->json($payment,200);
    }
    public function getPaymentPackages(){
        $payment = PaymentPackage::all();
        return response()->json($payment,200);
    }
    public function getPaymentPackageByName($name){
        $payment= PaymentPackage::where('package_name',$name)->first();
        return response()->json(['Package'=>$payment,],200);
    }
    public function createPaymentPackages(Request $request)
    {
        $package = new PaymentPackage;
        $package->package_name = $request->package_name;
        $package->short_description = $request->short_description;
        $package->long_description = $request->long_description;
        $package->features = $request->features;
        $package->price = $request->price;
        $package->duration = $request->duration;
        $package->save();
        return response()->json($package,201);
    }
    public function updatePaymentPackage(Request $request, $package_id){

        $package = PaymentPackage::where('id',$package_id)->first();
        $package->package_name = $request->package_name;
        $package->short_description = $request->short_description;
        $package->long_description = $request->long_description;
        $package->features = $request->features;
        $package->price = $request->price;
        $package->duration = $request->duration;
        $package->save();
        return response()->json($package);
    }
    public function destroyPackage($package_id)
    {
        $package = PaymentPackage::where('id',$package_id)->first();
        $package->delete();
        return response()->json($package);
    }


}


