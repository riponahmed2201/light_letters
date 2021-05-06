<?php

use App\Models\Admin;
use App\Models\ClientMail;
use App\Models\DirectMail;
use App\Models\Group;
use App\Models\GroupMail;
use App\Models\ScheduleMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

function allAdmins(){
    return Admin::all();
}
function oneAdmin($id){
    return Admin::where('id',$id)->first();
}
//----------Mail Data-----------
function directMail($request){
    $receivers = json_decode($request->receiver,true);
    $countRcv = count($receivers);
    //dd($receivers);
    //exit();
    foreach ($receivers as $key => $rcv){

        //dd($rcv);
        $mailc = new ClientMail;
        $mail = new DirectMail;
        $mailc->client_id = $request->client_id;
        $mailc->receiver = $rcv;
        $mailc->sender = $request->sender;
        $mailc->mail_body = $request->mail_body;
        $mailc->type = 'client';
        $mailc->cc =$request->cc;
        $mailc->bcc = $request->bcc;
        $mailc->tag = $request->tag;
        $mailc->group = $request->group;
        $mailc->subject = $request->subject;
        $mailc->quick_reply = $request->quick_reply;
        $mailc->remainder = $request->remainder;
        $mailc->read_status = null;
        if ($request->deadline){
            $mailc->deadline = Carbon::parse($request->deadline)->format('d M Y');
            $mail->deadline = Carbon::parse($request->deadline)->format('d M Y');
        }
//        $mailc->deadline = Carbon::parse($request->deadline)->format('d M Y');
        $mailc->hide_status = $request->hide_status;
        $mailc->reply_status = $request->reply_status;
        $mail->receiver = $rcv;
        $mail->sender = $request->sender;
        $mail->mail_body = $request->mail_body;
        $mail->type = 'customer';
        $mail->cc =$request->cc;
        $mail->bcc = $request->bcc;
        $mail->tag = $request->tag;
        $mail->group = $request->group;
        $mail->subject = $request->subject;
        $mail->quick_reply =$request->quick_reply;
        $mail->remainder =$request->remainder;
        $mail->read_status = null;
        $mail->hide_status = $request->hide_status;
        $mail->reply_status = $request->reply_status;
        $mail->save();
        if ($request->hasFile('mail_file')) {
            if ($countRcv == 1){
                $file = $request->file('mail_file');
                $fileName = $mail->id.'.'. $file->getClientOriginalExtension();
                $path = '/uploads/mail_file/direct_mail/';
                $file->move(public_path($path), $fileName);
            DirectMail::where('id', $mail->id)->update([
                'mail_file' => $fileName,
            ]);
                $mailc->mail_file = $fileName;
            }
            else{
                if ($key == 0){
                    $file = $request->file('mail_file');
                    $fileName = $mail->id. '.' . $file->getClientOriginalExtension();
                    $path = '/uploads/mail_file/direct_mail/';
                    $file->move(public_path($path), $fileName);
                    DirectMail::where('id', $mail->id)->update([
                        'mail_file' => $fileName,
                    ]);
                    $mailc->mail_file = $fileName;
                }
                if ($key >= 1){
                    $storedFile = public_path('/uploads/mail_file/direct_mail/'.$fileName);
                    $fileType = File::extension($storedFile);
                    $fileNewName = $mail->id.'.'.$fileType;
                    $filePath = '/uploads/mail_file/direct_mail/';
                    File::copy(public_path($filePath.$fileName), public_path($filePath.$fileNewName));
                    DirectMail::where('id', $mail->id)->update([
                        'mail_file' => $fileNewName,
                    ]);
                    $mailc->mail_file = $fileName;
                }
            }
        }
        $mailc->save();
    }
    return true;
}
function scheduleMail($request){
    if ($request->receiver){
        $receivers = json_decode($request->receiver,true);
        $countRcv = count($receivers);
        // dd($receivers);
        foreach ($receivers as $key => $rcv) {
            $mail = new ScheduleMail;
            $mail->schedule = Carbon::parse($request->schedule);
            $mail->client_id = $request->client_id;
            $mail->receiver = $rcv;
            $mail->sender = $request->sender;
            $mail->mail_body = $request->mail_body;
            $mail->type = 'customer';
            $mail->cc = $request->cc;
            $mail->bcc = $request->bcc;
            $mail->tag = $request->tag;
            $mail->subject = $request->subject;
            $mail->quick_reply = $request->quick_reply;
            $mail->remainder = $request->remainder;
            $mail->read_status = null;
            if ($request->deadline){
                $mail->deadline = Carbon::parse($request->deadline)->format('d M Y');
            }
//        $mail->deadline = Carbon::parse($request->deadline)->format('d M Y');
            $mail->hide_status = $request->hide_status;
            $mail->reply_status = $request->reply_status;
            $mail->save();
            if ($request->hasFile('mail_file')) {
                if ($countRcv == 1){
                    $file = $request->file('mail_file');
                    $fileName = $mail->id.'.'. $file->getClientOriginalExtension();
                    $path = '/uploads/mail_file/schedule_mail/';
                    $file->move(public_path($path), $fileName);
                    ScheduleMail::where('id', $mail->id)->update([
                        'mail_file' => $fileName,
                    ]);
                }
                else{
                    if ($key == 0){
                        $file = $request->file('mail_file');
                        $fileName = $mail->id. '.' . $file->getClientOriginalExtension();
                        $path = '/uploads/mail_file/schedule_mail/';
                        $file->move(public_path($path), $fileName);
                        ScheduleMail::where('id', $mail->id)->update([
                            'mail_file' => $fileName,
                        ]);
                    }
                    if ($key >= 1){
                        $storedFile = public_path('/uploads/mail_file/schedule_mail/'.$fileName);
                        $fileType = File::extension($storedFile);
                        $fileNewName = $mail->id.'.'.$fileType;
                        $filePath = '/uploads/mail_file/schedule_mail/';
                        File::copy(public_path($filePath.$fileName), public_path($filePath.$fileNewName));
                        ScheduleMail::where('id', $mail->id)->update([
                            'mail_file' => $fileNewName,
                        ]);
                    }
                }
            }
        }
    }
    else{
            $mail = new ScheduleMail;
            $mail->schedule = Carbon::parse($request->schedule);
            $mail->client_id = $request->client_id;
            $mail->group = $request->group;
            $groupInfo = Group::where('id', $request->group)->first();
            $receiver = json_decode(json_encode($groupInfo->customer_email), true);
            $mail->receiver_group = $receiver;
            $mail->sender = $request->sender;
            $mail->mail_body = $request->mail_body;
            $mail->type = 'customer';
            $mail->cc = $request->cc;
            $mail->bcc = $request->bcc;
            $mail->tag = $request->tag;
            $mail->subject = $request->subject;
            $mail->quick_reply = $request->quick_reply;
            $mail->remainder = $request->remainder;
            $mail->read_status = null;
            if ($request->deadline){
                $mail->deadline = Carbon::parse($request->deadline)->format('d M Y');
            }
//        $mail->deadline = Carbon::parse($request->deadline)->format('d M Y');
            $mail->hide_status = $request->hide_status;
            $mail->reply_status = $request->reply_status;
            $mail->save();
            if ($request->hasFile('mail_file')){
                $file = $request->file('mail_file');
                $fileName = $mail->id.'.'. $file->getClientOriginalExtension();
                $path = '/uploads/mail_file/schedule_mail/';
                $file->move(public_path($path), $fileName);
                ScheduleMail::where('id', $mail->id)->update([
                    'mail_file' => $fileName,
                ]);
            }
    }
    return true;
}
function groupMail($request){
    $group_id = $request->group;
    $groupInfo = Group::where('id', $group_id)->first();
    $mailg = new GroupMail;
    // dd($groupInfo);
    $mailg->group_id = $request->group;
    $mailg->client_id = $request->client_id;
    $mailg->receiver = json_decode(json_encode($groupInfo->customer_email),true);
    $mailg->sender = $request->sender;
    $mailg->mail_body = $request->mail_body;
    $mailg->type = 'customer';
    $mailg->cc = $request->cc;
    $mailg->bcc = $request->bcc;
    $mailg->tag = $request->tag;
    $mailg->subject = $request->subject;
    $mailg->quick_reply = $request->quick_reply;
    $mailg->remainder = $request->remainder;
    $mailg->read_status = null;
    if ($request->deadline){
        $mailg->deadline =  Carbon::parse($request->deadline)->format('d M Y');
    }
//    $mailg->deadline =  Carbon::parse($request->deadline)->format('d M Y');
    $mailg->hide_status = $request->hide_status;
    $mailg->reply_status = $request->reply_status;
    $mailg->save();
    if ($request->hasFile('mail_file')) {
        $fileg = $request->file('mail_file');
        $fileNameg = $mailg->id . '.' . $request->mail_file->getClientOriginalExtension();
        $pathg = '/uploads/mail_file/group_mail/';
        $fileg->move(public_path($pathg), $fileNameg);
        GroupMail::where('id', $mailg->id)->update([
            'mail_file' => $fileNameg,
        ]);
    }
    $receiver = json_decode(json_encode($groupInfo->customer_email),true);
    foreach ($receiver as $key => $rcv) {
        $mailcl = new ClientMail;
        $maild = new DirectMail;
        $mailcl->client_id = $request->client_id;
        $mailcl->receiver = $rcv;
        $mailcl->sender = $request->sender;
        $mailcl->mail_body = $request->mail_body;
        $mailcl->type = 'client';
        $mailcl->cc = $request->cc;
        $mailcl->bcc = $request->bcc;
        $mailcl->tag = $request->tag;
        $mailcl->group = $mailg->id;
        $mailcl->subject = $request->subject;
        $mailcl->quick_reply = $request->quick_reply;
        $mailcl->remainder = $request->remainder;
        $mailcl->read_status = null;
        if ($request->deadline) {
            $mailcl->deadline = Carbon::parse($request->deadline)->format('d M Y');
            $maild->deadline =  Carbon::parse($request->deadline)->format('d M Y');
        }
        $mailcl->hide_status = $request->hide_status;
        $mailcl->reply_status = $request->reply_status;
        $maild->receiver = $rcv;
        $maild->sender = $request->sender;
        $maild->mail_body = $request->mail_body;
        $maild->type = 'customer';
        $maild->cc =$request->cc;
        $maild->bcc = $request->bcc;
        $maild->tag = $request->tag;
        $maild->group = $mailg->id;
        $maild->subject = $request->subject;
        $maild->quick_reply = $request->quick_reply;
        $maild->remainder =$request->remainder;
        $maild->read_status = null;
        $maild->hide_status = $request->hide_status;
        $maild->reply_status = $request->reply_status;
        $maild->save();
        if ($request->hasFile('mail_file')) {
            $filed = public_path('/uploads/mail_file/group_mail/'.$fileNameg);
            $fileNamed = $maild->id . '.' . $request->mail_file->getClientOriginalExtension();
            $pathd = '/uploads/mail_file/direct_mail/';
            $oldPath = '/uploads/mail_file/group_mail/';
            $fileType = File::extension($filed);
            $fileNewName = $maild->id.'.'.$fileType;
            File::copy(public_path($oldPath.$fileNameg), public_path($pathd.$fileNewName));
            DirectMail::where('id', $maild->id)->update([
                'mail_file' => $fileNamed,
            ]);
            $mailcl->mail_file = $fileNamed;
        }
        $mailcl->save();
    }
    return true;
}


function groupScheduleUpdate($request){
    $group_id = $request->group;
    $groupInfo = Group::where('id', $group_id)->first();
    $mailg = new GroupMail;
    $mailg->group_id = $request->group;
    $mailg->client_id = $request->client_id;
    $mailg->receiver = json_decode(json_encode($groupInfo->customer_email),true);
    $mailg->sender = $request->sender;
    $mailg->mail_body = $request->mail_body;
    $mailg->type = 'customer';
    $mailg->cc = json_decode(json_encode($request->cc),true);
    $mailg->bcc = $request->bcc;
    $mailg->tag = $request->tag;
    $mailg->subject = $request->subject;
    $mailg->quick_reply = json_decode(json_encode($request->quick_reply),true);
    $mailg->remainder = json_decode(json_encode($request->remainder),true);
    $mailg->read_status = null;
    if ($request->deadline){
        $mailg->deadline =  Carbon::parse($request->deadline)->format('d M Y');
    }
    $mailg->hide_status = $request->hide_status;
    $mailg->reply_status = $request->reply_status;
    $mailg->save();
    if ($request->mail_file) {
        $file = public_path('/uploads/mail_file/schedule_mail/' . $request->mail_file);
        $oldname = $request->mail_file;
        $fileType = File::extension($file);
        $fileName = $mailg->id.'.'.$fileType;
        $schedule_path = '/uploads/mail_file/schedule_mail/';
        $path = '/uploads/mail_file/group_mail/';
        File::move(public_path($schedule_path.$oldname),public_path($path.$fileName));
        GroupMail::where('id', $mailg->id)->update([
            'mail_file' => $fileName,
        ]);
//        unlink($schedule_path);
    }
    $receiver = json_decode(json_encode($groupInfo->customer_email),true);
    foreach ($receiver as $rcv) {
        $mailcl = new ClientMail;
        $maild = new DirectMail;
        $mailcl->client_id = $request->client_id;
        $mailcl->receiver = $rcv;
        $mailcl->sender = $request->sender;
        $mailcl->mail_body = $request->mail_body;
        $mailcl->type = 'client';
        $mailcl->cc = json_decode(json_encode($request->cc),true);
        $mailcl->bcc = $request->bcc;
        $mailcl->tag = $request->tag;
        $mailcl->group = $mailg->id;
        $mailcl->subject = $request->subject;
        $mailcl->quick_reply = json_decode(json_encode($request->quick_reply),true);
        $mailcl->remainder = json_decode(json_encode($request->remainder),true);
        $mailcl->read_status = null;
        if ($request->deadline){
            $mailcl->deadline =  Carbon::parse($request->deadline)->format('d M Y');
            $maild->deadline =  Carbon::parse($request->deadline)->format('d M Y');
        }
        $mailcl->hide_status = $request->hide_status;
        $mailcl->reply_status = $request->reply_status;
        $maild->receiver = $rcv;
        $maild->sender = $request->sender;
        $maild->mail_body = $request->mail_body;
        $maild->type = 'customer';
        $maild->cc =json_decode(json_encode($request->cc),true);
        $maild->bcc = $request->bcc;
        $maild->tag = $request->tag;
        $maild->group = $mailg->id;
        $maild->subject = $request->subject;
        $maild->quick_reply = json_decode(json_encode($request->quick_reply),true);
        $maild->remainder =json_decode(json_encode($request->remainder),true);
        $maild->read_status = null;
        $maild->hide_status = $request->hide_status;
        $maild->reply_status = $request->reply_status;
        $maild->save();
        $mailcl->save();
        if ($request->mail_file) {
            $file = public_path('/uploads/mail_file/group_mail/'.$fileName);
            $oldname = $fileName;
            $fileType = File::extension($file);
            $fileNameNew = $maild->id.'.'.$fileType;
            $schedule_path = '/uploads/mail_file/group_mail/';
            $path = '/uploads/mail_file/direct_mail/';
            File::copy(public_path($schedule_path.$oldname),public_path($path.$fileNameNew));
            DirectMail::where('id', $maild->id)->update([
                'mail_file' => $fileNameNew,
            ]);
            ClientMail::where('id', $maild->id)->update([
                'mail_file' => $fileNameNew,
            ]);
        }
    }
    return response()->json(['Group Schedule mail Sent'],200);
}

