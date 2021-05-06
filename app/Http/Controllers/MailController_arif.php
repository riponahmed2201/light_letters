<?php

namespace App\Http\Controllers;
use App\Mail\ClientToCustomer;
use App\Mail\ReplyToClient;
use App\Mail\ReplyToCustomer;
use App\Models\Client;
use App\Models\ClientMail;
use App\Models\Customer;
use App\Models\DirectMail;
use App\Models\Group;
use App\Models\GroupMail;
use App\Models\PasswordChange;
use App\Models\QuickReply;
use App\Models\ReplyMail;
use App\Models\ScheduleMail;
use App\Models\ClientReply;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Symfony\Polyfill\Intl\Idn\Info;
use function PHPUnit\Framework\isEmpty;


class MailController extends Controller
{
    public function sendMailToCustomer(Request $request)
    {
        dd($request->input('receiver'));
        exit();
        if ($request->group && $request->schedule == null) {
            $status = groupMail($request);
            return response()->json(['status'=> $status], 201);
        }
        elseif ($request->group == null && $request->schedule) {
            $schStatus = scheduleMail($request);
            return response()->json(['status'=>$schStatus], 201);
        }
        elseif ($request->group && $request->schedule){
            scheduleMail($request);
            return response()->json(['status'=>'Mail Sent'], 201);
        }
        else {
            $data = directMail($request);
            return response()->json(['status'=>$data], 201);
        }
    }
    public function scheduleUpdate($schedule_mail_id)
    {
        $schedule = ScheduleMail::where('id', $schedule_mail_id)->first();
        if ($schedule->group){
            groupScheduleUpdate($schedule);
            $schedule->delete();
            return response()->json(['status'=>'Group Mail Sent'], 200);
        }
        else{
            $mailc = new ClientMail;
            $mail = new DirectMail;
            $mailc->client_id = $schedule->client_id;
            $mailc->receiver = $schedule->receiver;
            $mailc->sender = $schedule->sender;
            $mailc->mail_body = $schedule->mail_body;
            $mailc->type = 'client';
            $mailc->cc = json_decode(json_encode($schedule->cc,true),true);
            $mailc->bcc = $schedule->bcc;
            $mailc->tag = $schedule->tag;
            $mailc->subject = $schedule->subject;
            $mailc->quick_reply = json_decode(json_encode($schedule->quick_reply),true);
            $mailc->remainder = null;
            $mailc->read_status = null;
            $mailc->deadline = $schedule->deadline;
            $mailc->hide_status = $schedule->hide_status;
            $mailc->reply_status = $schedule->reply_status;
            $mail->receiver = $schedule->receiver;
            $mail->sender = $schedule->sender;
            $mail->mail_body = $schedule->mail_body;
            $mail->type = 'customer';
            $mail->cc = json_decode(json_encode($schedule->cc),true);
            $mail->bcc = $schedule->bcc;
            $mail->tag = $schedule->tag;
            $mail->subject = $schedule->subject;
            $mail->quick_reply = json_decode(json_encode($schedule->quick_reply),true);
            $mail->remainder = null;
            $mail->deadline = $schedule->deadline;
            $mail->hide_status = $schedule->hide_status;
            $mail->read_status = null;
            $mail->reply_status = $schedule->reply_status;
            $mail->save();
            $mailc->save();
            if ($schedule->mail_file) {
                $file = public_path('/uploads/mail_file/schedule_mail/' . $schedule->mail_file);
                $oldname = $schedule->mail_file;
                $fileType = File::extension($file);
                $fileName = $mail->id.'.'.$fileType;
                $schedule_path = '/uploads/mail_file/schedule_mail/';
                $path = '/uploads/mail_file/direct_mail/';
                File::move(public_path($schedule_path.$oldname),public_path($path.$fileName));
                DirectMail::where('id', $mail->id)->update([
                    'mail_file' => $fileName,
                ]);
                ClientMail::where('id', $mailc->id)->update([
                    'mail_file' => $fileName,
                ]);
//                unlink($schedule_path);
            }
            if (isset($mail) && isset($mailc)) {
                $schedule->delete();
            }
            return response()->json($mail, 201);
        }
    }

//----------------Retrive Mail to View------------------------------------------------
    public function getAllClientMail($client_id)
    {
//        $clientInfo = oneClient($client_id);
//        $allMail = allMailClient($client_id);
//        $groMail = DB::table('group_mails')
//            ->join('groups','group_mails.group_id','=','groups.id')
//            ->select('groups.group_name','group_mails.*')->get();
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->where('group_mails.deleted_at',null)
            ->orderBy('id', 'DESC')
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->orderBy('id', 'DESC')
            ->get();

        $scheduleMail = DB::table('schedulemail')->where('client_id','=',$client_id)->orderBy('id', 'DESC')->get();
        $sentMails = $groupMail->merge($allMail);
        $mails = $scheduleMail->merge($sentMails);
        // dd($mails);
//        $directCount = count($allMail);
//        $groupCount = count($groupMail);
//        $mailCount = $directCount+$groupCount;
        return response()->json($mails, 200);
    }
    public function clientMailCount($client_id){
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->get();
        $directCount = count($allMail);
        $groupCount = count($groupMail);
        $mailCount = $directCount+$groupCount;
        return response()->json(['total_mail'=>$mailCount],200);
    }

    public function getCustomerMail($customer_id) //Customer mailBox
    {
        $customerInfo = oneCustomer($customer_id);
        $allDirectMail = DB::table('directmail')
            ->join('clients', 'directmail.sender', '=', 'clients.email')
            ->select('clients.name', 'clients.profile_picture', 'directmail.id','directmail.receiver',
            'directmail.sender','directmail.mail_body','directmail.type','directmail.bcc','directmail.tag',
            'directmail.group','directmail.subject','directmail.quick_reply','directmail.remainder',
            'directmail.deadline','directmail.read_status','directmail.mail_file','directmail.hide_status',
            'directmail.reply_status','directmail.created_at')
            ->where('directmail.type', '=', 'customer')
            ->where('directmail.receiver', '=', $customerInfo->email)
            ->orderBy('id', 'DESC')
            ->get();

//        $passInfo = PasswordChange::where('customer_id',$customer_id)->first();
        $directMailCount = DirectMail::where('type', '=', 'customer')->where('receiver', '=', $customerInfo->email)->count();
        return response()->json([
            'all_mail' => $allDirectMail,
            'customer_Info' => $customerInfo,
//            'pass_Info'=> $passInfo,
            'directMail_Count' => $directMailCount,
        ], 200);
    }
//    public function customerMailbox(){
//        $allDirectMail = DB::table('directmail')
//            ->join('clients','directmail.sender','=','clients.email')
//            ->select('clients.name','clients.profile_picture','directmail.*')
//            ->where('directmail.type','=','customer')
//            ->where('directmail.receiver','=',session('email'))
//            ->orderBy('id','DESC')
//            ->get();
//        $customerInfo = Customer::where('id','=',session('customer_id'))->first();
//        $passInfo = PasswordChange::where('customer_id',session('customer_id'))->first();
//        $directMailCount = DirectMail::where('type','=','customer')->where('receiver','=',session('email'))->count();
//        return view('home',compact('allDirectMail','customerInfo','passInfo','directMailCount'));
//    }
//    public function getSpecificCustomerMail($id){
//        $customerInfo = Customer::where('id','=',session('customer_id'))->first();
//        $mailDetails = DirectMail::where('id',$id)->first();
//        $replyMail = ReplyMail::where('direct_mail_id', $id)->orderBy('id','ASC')->get();
//        $clientInfo = DB::table('directmail')
//            ->join('clients','directmail.sender','=','clients.email')
//            ->select('clients.name','clients.email','clients.profile_picture')
//            ->where('clients.email','=',$mailDetails->sender)
//            ->first();
//        $quickReply = DB::table('directmail')
//            ->join('quick_replies','directmail.id','=','quick_replies.direct_mail_id')
//            ->where('directmail.id',$id)
//            ->select('quick_replies.reply')->get();
//        $reminder = DB::table('directmail')
//            ->join('remainders','directmail.id','=','remainders.direct_mail_id')
//            ->where('directmail.id',$id)
//            ->select('remainders.remainder')->get();
//        $replyMailCount = ReplyMail::where('direct_mail_id', $id)->count();
//        return view('home.msg_box',compact('mailDetails','replyMail','clientInfo','customerInfo','quickReply','reminder','replyMailCount'));
//    }
    public function getSpecificCustomerMail($direct_mail_id)
    {
        $mailDetails = directMailInfo($direct_mail_id);
        $replyMail = ReplyMail::where('direct_mail_id', $direct_mail_id)->orderBy('id', 'ASC')->get();
        $clientInfo = DB::table('directmail')
            ->join('clients', 'directmail.sender', '=', 'clients.email')
            ->select('clients.name', 'clients.profile_picture')
            ->where('clients.email', '=', $mailDetails->sender)
            ->first();
        $customerInfo = DB::table('directmail')
            ->join('customers', 'directmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture')
            ->where('customers.email', '=', $mailDetails->receiver)
            ->first();
//        $quickReply = DB::table('directmail')
//            ->join('quick_replies','directmail.id','=','quick_replies.direct_mail_id')
//            ->where('directmail.id',$direct_mail_id)
//            ->select('quick_replies.reply')->get();
//        $reminder = DB::table('directmail')
//            ->join('remainders','directmail.id','=','remainders.direct_mail_id')
//            ->where('directmail.id',$direct_mail_id)
//            ->select('remainders.remainder')->get();
        return response()->json([
            'mail_details' => $mailDetails,
            'all_reply_mail' => $replyMail,
            'client_info' => $clientInfo,
            'customer_info'=> $customerInfo
//            'quick_reply'=>$quickReply,
//            'reminder'=>$reminder
        ], 200);
    }
    public function scheduleMailInfo($schedule_mail_id){
        $mailInfo = ScheduleMail::where('id',$schedule_mail_id)->first();
        if ($mailInfo->group != null){
            $customerInfo = [];
            $recevers = $mailInfo->receiver_group;
            foreach ($recevers as $rcv){
                $customerInfo[] = DB::table('schedulemail')
                    ->join('customers',$rcv,'=','customers.email')
                    ->select('customers.first_name','customers.last_name','customers.profile_picture')
                    ->where('schedulemail.id','=',$schedule_mail_id)->first();
            }
            return response()->json([
                'mail_details' => $mailInfo,
                'customer_info' => $customerInfo,
            ], 200);
        }
        else{
            $customerInfo = DB::table('schedulemail')
                ->join('customers','schedulemail.receiver','=','customers.email')
                ->select('customers.first_name','customers.last_name','customers.profile_picture')
                ->where('schedulemail.id','=',$schedule_mail_id)->first();
            return response()->json([
                'mail_details' => $mailInfo,
                'customer_info' => $customerInfo,
            ], 200);
        }
    }

    public function getSpecificClientMail($client_mail_id,$group_mail_id)
    {
        if ($group_mail_id != '0'){
            $mailDetails = groupMailInfo($group_mail_id);
            $replyMail = ClientReply::where('group', $group_mail_id)->orderBy('id', 'ASC')->get();
            $customerInfo = DB::table('clientreply')
                ->join('customers','clientreply.sender','=','customers.email')
                ->select('customers.first_name','customers.last_name','customers.profile_picture')
                ->where('clientreply.group','=',$group_mail_id)->first();
        }
        else{
            $mailDetails = clientMailInfo($client_mail_id);
            $replyMail = ClientReply::where('client_mail_id', $client_mail_id)->orderBy('id', 'ASC')->get();
            $customerInfo = DB::table('clientmail')
                ->join('customers', 'clientmail.receiver', '=', 'customers.email')
                ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture')
                ->where('customers.email', '=', $mailDetails->receiver)
                ->first();
        }
//        $quickReply = DB::table('clientmail')
//            ->join('quick_replies','clientmail.id','=','quick_replies.direct_mail_id')
//            ->where('clientmail.id',$client_mail_id)
//            ->select('quick_replies.reply')->get();
//        $reminder = DB::table('clientmail')
//            ->join('remainders','clientmail.id','=','remainders.direct_mail_id')
//            ->where('clientmail.id',$client_mail_id)
//            ->select('remainders.remainder')->get();
        return response()->json([
            'mail_details' => $mailDetails,
            'all_reply_mail' => $replyMail,
            'customer_info' => $customerInfo,
//            'quick_reply'=>$quickReply,
//            'reminder'=>$reminder
        ], 200);
    }

    public function countDirectMail()
    {
        $countMail = DirectMail::withTrashed()->get();  //also with trash
        $count = count($countMail);
        return response()->json(['total_direct_mail' => $count], 200);
    }

    public function countReplyMail($direct_mail_id)
    {
        $specificReplyCount = ReplyMail::where('direct_mail_id', $direct_mail_id)->count();
        return response()->json($specificReplyCount, 200);
    }

    public function countClientReplyMail($client_mail_id)
    {
        $specificReplyCount = ClientReply::where('client_mail_id', $client_mail_id)->count();
        return response()->json($specificReplyCount, 200);
    }

    public function countSpecificClientMail($client_id)
    {
//        $clientInfo = oneClient($client_id);
        $specificClientMail = ClientMail::where('client_id', $client_id)->count();
        return response()->json($specificClientMail, 200);
    }

    public function countSpecificCustomerMail($customer_id)
    {
        $customerMail = oneCustomer($customer_id);
        $specificDirectMail = DirectMail::where('receiver', $customerMail->mail)->count();
        return response()->json($specificDirectMail, 200);
    }

    // -----------Update Read Status--------------------------------------------------------
    public function readStatusUpdateApi($direct_mail_id)
    {
        $mail = directMailInfo($direct_mail_id)->update([
            'read_status' => 'read',
        ]);
        return response()->json(['status' => 'Read status updated'], 201);
//        return redirect()->back();
    }

    public function requiredAction()
    {
        $data = DirectMail::whereNotNull('remainder')->count();
        return response()->json(['Action_Required' => $data], 200);
    }

    public function countInfo()
    {
        $allMail = ClientMail::all()->count();
        $allReply = ClientReply::all()->count();
        $allReplyPer = round( $allReply*0.1,3);
        $total = $allMail + $allReply;
        $openRate = DirectMail::where('read_status', '!=', null)->count();
        $openRatePer = round($openRate*0.1,3) ;

        $responseRate = ReplyMail::select('direct_mail_id')
            ->groupBy('direct_mail_id')
            ->orderByRaw('COUNT(*) DESC')->pluck('direct_mail_id')
            ->count();
        $responseRatePer =round($responseRate*0.1,3);
        $deadline = DirectMail::where('deadline', '<', Carbon::now())->count();
        $deadlinePer =round($deadline*0.1,3);

        $allWeek = DirectMail::select([
            DB::raw('count(id) as mail_sent'),
            DB::raw('week(created_at) as week'),
            DB::raw('month(created_at) as month'),
            DB::raw('year(created_at) as year')
        ])->groupBy(['year','month','week'])
            ->get()->toArray();

        $allMonth = DirectMail::select([
            DB::raw('count(id) as mail_sent'),
            DB::raw('month(created_at) as month'),
            DB::raw('year(created_at) as year')
        ])->groupBy(['year','month'])
            ->get()->toArray();

        return response()->json([
            'sent_mail' => $allMail,
            'total_reply' => $allReplyPer,
            'total_mail_count' => $total,
            'open_rate' => $openRatePer,
            'response_rate' => $responseRatePer,
            'deadline_over' => $deadlinePer,
            'current_week' => $allWeek,
            'current_month' => $allMonth,
        ], 200);
    }
    public function countInfoClient($client_id)
    {
        $clientMail = ClientMail::where('client_id', '=', $client_id)->get();
        $allMail = $clientMail->count();
        $allReply = ClientReply::where('client_mail_id', '=', $clientMail->id)->count();
        $total = $allMail + $allReply;
        $openRate = ClientMail::where('client_id', '=', $client_id)->where('read_status', '!=', null)->count();
        $responseRate = ClientReply::select('client_mail_id')
            ->where('client_mail_id', '=', $clientMail->id)
            ->groupBy('client_mail_id')
            ->orderByRaw('COUNT(*) DESC')->pluck('client_mail_id')
            ->count();
        $deadline = ClientMail::where('client_id', $client_id)->where('deadline', '<', Carbon::now())->count();
        return response()->json([
            'sent_mail' => $allMail,
            'total_reply' => $allReply,
            'total_mail_count' => $total,
            'open_rate' => $openRate,
            'response_rate' => $responseRate,
            'deadline_over' => $deadline,
        ], 200);
    }

    public function searchQuickReply($client_id)
    {
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->where('quick_reply', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->where('quick_reply', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $scheduleMail = DB::table('schedulemail')
            ->where('client_id','=',$client_id)
            ->where('quick_reply', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $sentMails = $groupMail->merge($allMail);
        $data = $scheduleMail->merge($sentMails);
//        $data = ClientMail::where('quick_reply', '!=', null)->where('client_id','=',$client_id)->get();
        if ($data) {
            return response()->json(['status' => $data], 200);
        }
        else {
            return response()->json(['status' => 'No data found'], 400);
        }
    }

    public function searchNoReply($client_id)
    {
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->where('reply_status', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->where('reply_status', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $scheduleMail = DB::table('schedulemail')
            ->where('client_id','=',$client_id)
            ->where('reply_status', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $sentMails = $groupMail->merge($allMail);
        $data = $scheduleMail->merge($sentMails);
//        $data = ClientMail::where('reply_status', '=', null)->where('client_id','=',$client_id)->get();
        if ($data) {
            return response()->json(['status' => $data], 200);
        }
        else {
            return response()->json(['status' => 'No data found'], 400);
        }
    }

    public function searchReminder($client_id)
    {
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->where('remainder', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->where('remainder', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $scheduleMail = DB::table('schedulemail')
            ->where('client_id','=',$client_id)
            ->where('remainder', '!=', null)
            ->orderBy('id', 'DESC')
            ->get();
        $sentMails = $groupMail->merge($allMail);
        $data = $scheduleMail->merge($sentMails);
//        $data = ClientMail::where('remainder', '!=', null)->where('client_id','=',$client_id)->get();
        if ($data) {
            return response()->json(['status' => $data], 200);
        }
        else {
            return response()->json(['status' => 'No data found'], 400);
        }
    }
    public function searchDateWise(Request $request,$client_id){
        $searchDate = Carbon::parse($request->date);
//        $data = ClientMail::where('created_at', '=', $searchDate)->where('client_id','=',$client_id)->get();
        $groupMail = DB::table('group_mails')
            ->join('groups','group_mails.group_id','=','groups.id')
            ->select('groups.group_name','group_mails.*')
            ->where('group_mails.client_id','=',$client_id)
            ->where('created_at', '=', $searchDate)
            ->orderBy('id', 'DESC')
            ->get();
        $allMail = DB::table('clientmail')
            ->join('customers', 'clientmail.receiver', '=', 'customers.email')
            ->select('customers.first_name', 'customers.last_name', 'customers.profile_picture', 'clientmail.*')
            ->where('clientmail.client_id', '=', $client_id)
            ->where('clientmail.deleted_at', '=', null)
            ->where('clientmail.group', '=', null)
            ->where('created_at', '=', $searchDate)
            ->orderBy('id', 'DESC')
            ->get();
        $scheduleMail = DB::table('schedulemail')
            ->where('client_id','=',$client_id)
            ->where('created_at', '=', $searchDate)
            ->orderBy('id', 'DESC')
            ->get();
        $sentMails = $groupMail->merge($allMail);
        $data = $scheduleMail->merge($sentMails);
        if ($data) {
            return response()->json(['status' => $data], 200);
        }
        else {
            return response()->json(['status' => 'No data found'], 400);
        }
    }
    public function closeMail($group_mail_id){
        $mailData = ClientMail::where('group',$group_mail_id)->first();
        $directMail = DirectMail::where('group',$group_mail_id)->first();
//       $mailData = clientMailInfo($client_mail_id);
//       $directMail = directMailInfo($client_mail_id);
       $mailData->reply_status = null;
       $directMail->reply_status = null;
        $mailData->save();
        $directMail->save();
       if (isset($directMail) && isset($mailData)){
           return response()->json(['status'=>'Mail Closed'],200);
       }
       else{
           return response()->json(['status'=>'Mail Closing Failed'],400);
       }
    }

    public function respondedClientMail($client_mail_id){
        $mailData = clientMailInfo($client_mail_id);
        $replyStatus = ClientReply::where('client_mail_id',$client_mail_id)->count();
        if ($replyStatus==0){
            return response()->json(['responded'=>0],200);
        }
        else{
            return response()->json(['responded'=>$replyStatus],200);
        }
    }
    public function totalOpen($client_mail_id){
        $mailData = clientMailInfo($client_mail_id);
        if ($mailData->read_status == null){
            return response()->json(['total_open'=>0],200);
        }
        else{
            return response()->json(['total_open'=>1],200);
        }
    }
    //---------Group Mail Report-----------------------------------------
    public function reportGroupMail($group_mail_id){
        $mailData = GroupMail::where('id',$group_mail_id)->first();
        $groupInfo = Group::where('id',$mailData->group_id)->first();
        $responded = ReplyMail::where('group',$group_mail_id)->count();
        $totalOpen = DirectMail::where('group','=',$group_mail_id)->where('read_status','!=',null)->count();
        $totalUnread = DirectMail::where('group','=',$group_mail_id)->where('read_status','=',null)->count();
//        $deadLine = DirectMail::where('group','=',$group_mail_id)->where('deadline','!=',null)->count();
        $deadLine = $mailData->deadline;
//        $remainder = DirectMail::where('group','=',$group_mail_id)->where('remainder','!=',null)->count();
        $remainder = $mailData->remainder;
        $mailDirect = DirectMail::where('group','=',$group_mail_id)->get();
        $customerList = json_decode(json_encode($groupInfo->customer_email),true);
        $responseReceiver = DB::table('replymail')
            ->join('group_mails','group_mails.id','=','replymail.group')
            ->select('replymail.sender')
            ->where('replymail.group','=',$group_mail_id)
            ->get();

        // $cust = collect($responseReceiver);

        return response()->json([
            'group_name'=>$groupInfo->group_name,
            'responded'=>$responded,
            'total_open'=>$totalOpen,
            'total_unread'=>$totalUnread,
            'deadline'=>$deadLine,
            'remainder'=>$remainder,
            'customer_list'=>$customerList,
            'who_responded'=>$responseReceiver
        ],200);
    }
    public function allScheduleMail(){
        $scheduleData = ScheduleMail::all();
        if ($scheduleData){
            return response()->json($scheduleData,200);
        }
        else{
            return response()->json(['no schedule mail available'],200);
        }
    }
    public function clientsSchedule($client_id){
        if (ScheduleMail::where('client_id',$client_id)->get()) {
            $mails = ScheduleMail::where('client_id',$client_id)->get();
            return response()->json($mails,200);
        }
    }
}
