<?php

namespace App\Http\Controllers;

use App\Models\ClientReply;
use App\Models\Group;
use App\Models\GroupMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupMailController extends Controller
{
    public function getGroupMailByClient($client_id){
//        $groupInfo = GroupMail::where('client_id',$client_id)->get();
        $groMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')->get();
        $mailCount = count($groMail);
        return response()->json($groMail,200);
    }
    public function specificGroupMail($group_mail_id){
        //$groupMailInfo = GroupMail::where('id',$group_mail_id)->first();
        $groupMailInfo = DB::table('group_mails as gm')
                            ->select('gm.*', 'g.group_name')
                            ->join('groups as g','g.id','=','gm.group_id')
                            ->where('gm.id', $group_mail_id)
                            ->first();
        //$allReply= ClientReply::where('client_mail_id',$group_mail_id)->orderBy('id', 'ASC')->get();
        $allReply = DB::table('replymail')
                       ->where('group',$group_mail_id)
                       ->get();
        //dd($allReply);
        //$replyMail = ClientReply::where('client_mail_id', $client_mail_id)->orderBy('id', 'ASC')->get();
        $customerInfo = DB::table('clientreply')
        ->join('customers','clientreply.sender','=','customers.email')
        ->select('customers.first_name','customers.last_name','customers.profile_picture')
        ->where('clientreply.group','=',$group_mail_id)->first();
        return response()->json(['mail_details'=>$groupMailInfo,'all_reply'=>$allReply,'customer_info'=>$customerInfo],200);
    }
}
