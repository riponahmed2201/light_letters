<?php

function allClient(){
    return \App\Models\Client::all();
}
function oneClient($id){
    return \App\Models\Client::where('id',$id)->first();
}
function allMailClient($id){
    return \App\Models\ClientMail::where('client_id',$id)->get();
}
function clientMailInfo($id){
    return \App\Models\ClientMail::where('id',$id)->first();
}
function groupMailInfo($id){
    return \App\Models\GroupMail::where('id',$id)->first();
}
function allClientReply($id){
    return  \App\Models\ClientReply::where('client_mail_id',$id)->get();
}
function companyDetail($id){
    return \App\Models\Company::where('id',$id)->first();
}

//--------------Reply Mail Data--------[ Client Customer Both ]
function replyMail($request){
    $data = $request->name;
    return response()->json(['you_are'=>$data],200);
}
