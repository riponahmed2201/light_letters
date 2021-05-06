<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
class GroupController extends Controller
{
    public function getAllGroups(){
        $group = Group::all();
        return response()->json($group,200);
    }
    public function createGroup(Request $request){
        $group = new Group;
        $group->group_name = $request->group_name;
        $group->client_id = $request->client_id;
        $group->customer_email = $request->customer_email;
        $group->description = $request->description;
        $custMails = $request->customer_email;
        foreach ($custMails as $mails){
            $custData = Customer::where('email',$mails)->first();
            $name = $custData->first_name.' '.$custData->last_name;
            $nm [] = $name;
            $group->customer_name = $nm;
        }
        $group->save();
        return response()->json($group,201);
    }
    public function getGroup($group_id){
        $group = Group::where('id',$group_id)->first();
        return response()->json($group,200);
    }
    public function getClientsGroup($client_id){
        $group = Group::where('client_id',$client_id)->get();
        return response()->json($group,200);

    }
    public function updateGroup(Request $request,$group_id){
        $group = Group::where('id',$group_id)->first();
        $group->group_name = $request->group_name;
        $group->client_id = $request->client_id;
        $group->customer_email = $request->customer_email;
        $group->description = $request->description;
        $group->save();
        return response()->json($group,201);
    }
    public function removeGroup($group_id){
        $group = Group::where('id',$group_id)->first();
        $group->delete();
        return response()->json(['status'=>'Deleted Group'],200);
    }
    public function removeMultipleData(Request $request){
        $groupInfo = Group::where('id',$request->group_id)->first();
        $groupData = $groupInfo->customer_email;
        $custEmail = $request->customer_email;
        $result=array_values(array_diff($groupData,$custEmail));
        Group::where('id',$request->group_id)->update([
            'customer_email'=>$result,
        ]);
        return response()->json(['Group Updated'=>$result],200);
    }
}
