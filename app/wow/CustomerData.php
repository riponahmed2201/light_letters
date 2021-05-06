<?php

use App\Models\DirectMail;
use Illuminate\Support\Facades\DB;

function topCustomer(){
    $data = DirectMail::select('receiver')
    ->groupBy('receiver')
    ->orderByRaw('COUNT(*) DESC')->pluck('receiver')
    ->take(3);
    $cust = collect($data);
    foreach ($cust as $c){
        $res[] = \App\Models\Customer::where('email','=',$c)->first();
    }
    return $res;
}
function allCustomer(){
    // $res = \App\Models\Customer::where('deleted_at','=',null)->get();
    $res = DB::table('customers')->whereNull('deleted_at')->get();
    return $res;
}
function oneCustomer($id){
    return \App\Models\Customer::where('id',$id)->first();
}
function oneReply($id){
    return \App\Models\ReplyMail::find($id);
}
function allMailCust($mail){
    return DirectMail::where('receiver','=',$mail)->get();
}
function replyFileSize($id){
    $replyDetails = \App\Models\ReplyMail::find($id);
    $file = public_path('/uploads/mail_file/direct_mail/'.$replyDetails->mail_file);
//    $size = $file->getSize();
    $size = filesize($file);
    $repSize = round($size/1024);
    return $repSize;
}
// for msg-box-------------------------------------------------------------------------------//
function readStatusUpdate($id){
    \App\Models\ClientMail::where('id', $id)->update([
        'read_status'=>'read',
    ]);
    return directMailInfo($id)->update([
        'read_status'=>'read',
    ]);
}
function directMailInfo($id){
    return \App\Models\DirectMail::where('id',$id)->first();
}
function allReplyMail($id){
    return  \App\Models\ReplyMail::where('direct_mail_id',$id)->orderBy('id','ASC')->get();
}
function clientDetails($id){
    $mail = directMailInfo($id);
    return DB::table('directmail')
        ->join('clients','directmail.sender','=','clients.email')
        ->select('clients.name','clients.email','clients.profile_picture')
        ->where('clients.email','=',$mail->sender)
        ->first();
}
function quickReply($id){
    $mail = directMailInfo($id);
    return json_decode(json_encode($mail->quick_reply),true);

}
function mailReminder($id){
    $mail = directMailInfo($id);
    return json_decode(json_encode($mail->remainder),true);
}
function mailFileSize($id){
    $mail = directMailInfo($id);
    $file = public_path('/uploads/mail_file/direct_mail/'.$mail->mail_file);
    $size = filesize($file) ;
    return round($size/1024);
}
function ccList($id){
    $mail = directMailInfo($id);
    return json_decode(json_encode($mail->cc),true);


}
