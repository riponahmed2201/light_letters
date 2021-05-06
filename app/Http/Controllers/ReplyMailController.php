<?php

namespace App\Http\Controllers;

use App\Models\ClientReply;
use App\Models\GroupMail;
use App\Models\ReplyMail;
use Illuminate\Http\Request;

class ReplyMailController extends Controller
{
    public function replyMailToClientApi(Request $request){
        $direct_mail_id = $request->direct_mail_id;
        $directMailInfo = directMailInfo($direct_mail_id);
        $mailc = new ClientReply;
        $mail = new ReplyMail;
        $mail->direct_mail_id = $direct_mail_id; //hidden field a asbe
        $mail->receiver = $directMailInfo->sender; //client er mail
        $mail->sender = $directMailInfo->receiver; // customer er mail
        $mail->mail_body = $request->mail_body; //text field theke
        $mail->type = 'client';
        $mail->cc = $directMailInfo->cc;
        $mail->bcc = $directMailInfo->bcc;
        $mail->tag = $directMailInfo->tag;
        $mail->group = $directMailInfo->group;
        $mail->subject = $directMailInfo->subject;
        $mail->read_status = null;
        $mailc->client_mail_id = $direct_mail_id; //hidden field a asbe
        $mailc->receiver = $directMailInfo->sender; //client er mail
        $mailc->sender = $directMailInfo->receiver; // customer er mail
        $mailc->mail_body = $request->mail_body; //text field theke
        $mailc->type = 'client';
        $mailc->cc = $directMailInfo->cc;
        $mailc->bcc = $directMailInfo->bcc;
        $mailc->tag = $directMailInfo->tag;
        $mailc->group = $directMailInfo->group;
        $mailc->subject = $directMailInfo->subject;
        $mailc->read_status = null;
        $mail->save();
        if ($request->hasFile('mail_file')) {
            $file = $request->file('mail_file');
            $fileName = $mail->id.'.'.$request->mail_file->getClientOriginalExtension();
            $path = '/uploads/mail_file/reply_mail/';
            $file->move(public_path($path), $fileName);
            $storeFile = ReplyMail::where('id', $mail->id)->update([
                'mail_file'=> $fileName,
            ]);
            $mailc->mail_file = $fileName;
        }
        $mailc->save();
        return response()->json(['status'=>'Reply Sent','data'=>$mail],201);
    }
    public function replyMailToClient(Request $request){
        $direct_mail_id = $request->direct_mail_id;
        $directMailInfo = directMailInfo($direct_mail_id);
        $mailc = new ClientReply;
        $mail = new ReplyMail;
        $mail->direct_mail_id = $direct_mail_id; //hidden field a asbe
        $mail->receiver = $directMailInfo->sender; //client er mail
        $mail->sender = $directMailInfo->receiver; // customer er mail
        $mail->mail_body = $request->mail_body; //text field theke
        $mail->type = 'client';
        $mail->cc = $directMailInfo->cc;
        $mail->bcc = $directMailInfo->bcc;
        $mail->tag = $directMailInfo->tag;
        $mail->group = $directMailInfo->group;
        $mail->subject = $directMailInfo->subject;
        $mail->read_status = null;
        $mailc->client_mail_id = $direct_mail_id; //hidden field a asbe
        $mailc->receiver = $directMailInfo->sender; //client er mail
        $mailc->sender = $directMailInfo->receiver; // customer er mail
        $mailc->mail_body = $request->mail_body; //text field theke
        $mailc->type = 'client';
        $mailc->cc = $directMailInfo->cc;
        $mailc->bcc = $directMailInfo->bcc;
        $mailc->tag = $directMailInfo->tag;
        $mailc->group = $directMailInfo->group;
        $mailc->subject = $directMailInfo->subject;
        $mailc->read_status = null;
        $mail->save();
        if ($request->hasFile('mail_file')) {
            $file = $request->file('mail_file');
            $fileName = $mail->id.'.'.$request->mail_file->getClientOriginalExtension();
            $path = '/uploads/mail_file/reply_mail/';
            $file->move(public_path($path), $fileName);
            $storeFile = ReplyMail::where('id', $mail->id)->update([
                'mail_file'=> $fileName,
            ]);
            $mailc->mail_file = $fileName;
        }
        $mailc->save();
        return redirect()->back();
    }
    public function replyMailToCustomer(Request $request){
            $client_mail_id = $request->client_mail_id; //hidden field a asbe
            $mail = new ClientReply;
            $mailc = new ReplyMail;

            if(!$client_mail_id) {
                $client_mail_id = $request->group;
                $MailInfo = groupMailInfo($client_mail_id);
                $recv = json_encode($MailInfo->receiver);
                $mail->receiver = $recv;
                $mailc->receiver = $recv;
                $mail->group = $MailInfo->group_id;
                $mailc->group = $MailInfo->group_id;
            }else {
                $MailInfo = clientMailInfo($client_mail_id);
                $mail->receiver = $MailInfo->receiver;
                $mailc->receiver = $MailInfo->receiver;
                $mail->group = $MailInfo->group;
                $mailc->group = $MailInfo->group;
            }

           
            $mail->client_mail_id = $client_mail_id; //hidden field a asbe
            //$mail->receiver = $MailInfo->receiver[0]; //client er mail
            $mail->sender = $MailInfo->sender; // customer er mail
            $mail->mail_body = $request->mail_body; //text field theke
            $mail->type = 'customer';
            $mail->cc = $MailInfo->cc;
            $mail->bcc = $MailInfo->bcc;
            $mail->tag = $MailInfo->tag;
            
            $mail->subject = $MailInfo->subject;
            $mail->read_status = null;
            $mailc->direct_mail_id = $client_mail_id; //hidden field a asbe
            //$mailc->receiver = $MailInfo->receiver[0]; //client er mail
            $mailc->sender = $MailInfo->sender; // customer er mail
            $mailc->mail_body = $request->mail_body; //text field theke
            $mailc->type = 'customer';
            $mailc->cc = $MailInfo->cc;
            $mailc->bcc = $MailInfo->bcc;
            $mailc->tag = $MailInfo->tag;
            
            $mailc->subject = $MailInfo->subject;
            $mailc->read_status = null;
            $mail->save();
            $mailc->save();
            if ($request->hasFile('mail_file')) {
                $file = $request->file('mail_file');
                $fileName = $mail->id.'.'.$request->mail_file->getClientOriginalExtension();
                $path = '/uploads/mail_file/reply_mail/';
                $file->move(public_path($path), $fileName);
                ReplyMail::where('id', $mail->id)->update([
                    'mail_file'=> $fileName,
                ]);
                ClientReply::where('id', $mail->id)->update([
                    'mail_file'=> $fileName,
                ]);
//                $mailc->mail_file = $fileName;
            }
//            $mailc->save();
        return response()->json(['status'=>'Reply Sent','data'=>$mailc],201);
    }
}
