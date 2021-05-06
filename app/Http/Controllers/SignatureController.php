<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function addSignature(Request $request){
        $signature = new Signature;
        $signature->signature = $request->signature;
        $signature->client_id = $request->client_id;
        $signature->name = $request->name;
        $signature->designation = $request->designation;
        $signature->phone = $request->phone;
        $signature->facebook = $request->facebook;
        $signature->address = $request->address;
        $signature->twitter = $request->twitter;
        $signature->instagram = $request->instagram;
        $signature->website = $request->website;
        $signature->save();
        return response()->json($signature,201);
    }
    public function signatureList(){
        $signature = signature::all();
        return response()->json($signature,200);
    }
    public function clientSignature($client_id){
        $signature = signature::where('client_id',$client_id)->first();
        return response()->json($signature,200);
    }
    public function signatureUpdate(Request $request,$client_id){
        $signature = signature::where('client_id',$client_id)->first();
        $signature->signature = $request->signature;
        $signature->client_id = $client_id;
        $signature->name = $request->name;
        $signature->designation = $request->designation;
        $signature->phone = $request->phone;
        $signature->facebook = $request->facebook;
        $signature->address = $request->address;
        $signature->twitter = $request->twitter;
        $signature->instagram = $request->instagram;
        $signature->website = $request->website;
        $signature->save();
        return response()->json($signature,201);
    }
    public function signatureDelete($client_id){
        $signature = signature::where('client_id',$client_id)->first();
        $signature->delete();
        return response()->json($signature,200);
    }
}
