<?php

namespace App\Http\Controllers;

use App\Models\ClientMail;
use App\Models\ClientReply;
use App\Models\DirectMail;
use App\Models\GroupMail;
use App\Models\ReplyMail;
use http\Env\Response;
use Illuminate\Http\Request;

class MailDeletionController extends Controller
{
    //---------------Delete mail for Customer----------------------------------------------------
    public function removeReplyAsCustomer($reply_mail_id){
        $customerReply = oneReply($reply_mail_id)->delete();
        return redirect()->back()->with('delete-notify','Reply Deleted!');
    }
    public function removeReplyAsCustomerApi($reply_mail_id){
        $customerReply = oneReply($reply_mail_id)->delete();
//        $customerReply->delete();
        if ($customerReply){
            return response()->json(['status'=>'Reply Deleted!'],200);
        }
        else{
            return response()->json(['status'=>'Reply Not Deleted!'],200);
        }

    }
    public function removeDirectMail($direct_mail_id){
        $directMail = directMailInfo($direct_mail_id);
        $replyMail = allReplyMail($direct_mail_id);
        foreach ($replyMail as $reply){
            if ($reply != null) {
                $reply->delete();
            }
        }
        if ($directMail != null) {
            $directMail->delete();
        }
        return redirect('/home')->with('mail-delete-notify','Mail Deleted!');
    }
    public function removeDirectMailApi($direct_mail_id){
        $directMail = directMailInfo($direct_mail_id);
        $replyMail = allReplyMail($direct_mail_id);
        foreach ($replyMail as $reply){
            if ($reply != null) {
                $reply->delete();
            }
        }
        if ($directMail != null) {
            $directMail->delete();
        }
        return response()->json(['status'=>'Mail Deleted!','D'=>$directMail,'R'=>$replyMail],200);
    }
    public function removeAllMail($customer_id){
        $customer = oneCustomer($customer_id);
        $directMail = allMailCust($customer->email);
        foreach ($directMail as $direct){
            $replyMail = allReplyMail($direct->id);
            foreach ($replyMail as $reply){
                $reply->delete();
            }
        }
        $directMail->delete();
        return redirect('/home/')->with('all-mail-delete-notify','All Mail Deleted!');

    }
    public function removeAllCustomerMailApi($customer_id){
        $customer = oneCustomer($customer_id);
        $rcv = $customer->email;
        $directMail = DirectMail::where('receiver',$rcv)->get();
        foreach ($directMail as $direct){
            $replyMail = allReplyMail($direct->id);
            foreach ($replyMail as $reply){
                $reply->delete();
            }
            $direct->delete();
        }
        return response()->json(['status'=>'All Mail DELETED with all replies!'],200);
    }
    //---------------Delete mail for Client----------------------------------------------------
    public function removeClientMail($client_id){
        $directMail = ClientMail::where('client_id',$client_id)->get();
        $groupMail = GroupMail::where('client_id',$client_id)->get();
        foreach ($directMail as $direct){
            $replyMail = allClientReply($direct->id);
            foreach ($replyMail as $reply){
                $reply->delete();
            }
            $direct->delete();
        }
        foreach ($groupMail as $gm){
            $grpID = $gm->id;
            $repMail = ClientReply::where('group',$grpID)->get();
            foreach ($repMail as $rm){
                $rm->delete();
            }
            $gm->delete();
        }
        return response()->json(['status'=>'All Mail Deleted with all replies!'],200);
    }
    public function removeOneClientMail($client_mail_id,$group_mail_id){
        if ($group_mail_id != 0){
            $this->removeGroupMail($group_mail_id);
            return response()->json(['status'=>'Mail Deleted!'],200);
        }
        else{
            $directMail = clientMailInfo($client_mail_id);
            $replyMail = allClientReply($client_mail_id);
            foreach ($replyMail as $reply){
                $reply->delete();
            }
            $directMail->delete();
            return response()->json(['status'=>'Mail Deleted!','D'=>$directMail,'R'=>$replyMail],200);
        }
    }
    public function removeClientReply($reply_mail_id){
        $customerReply = ClientReply::where('id',$reply_mail_id)->first();
        $customerReply->delete();
        return response()->json(['status'=>'Reply Deleted!'],200);
    }
    public function removeGroupMail($group_mail_id){
        $groupMailInfo = GroupMail::where('id',$group_mail_id)->first();
        $replyMail = ClientReply::where('group',$group_mail_id)->get();
        foreach ($replyMail as $reply){
            $reply->delete();
        }
        $groupMailInfo->delete();
        return response()->json(['status'=>'Group MaIL Deleted'],200);
    }
}
