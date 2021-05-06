<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DirectMail;
use App\Models\Customer;
use App\Models\ReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;


class HomeController extends Controller
{
    //////////////////////welcome page //////////////////////
    public function welcome()
    {
        return view('welcome');
    }
    public function sign_up()
    {
        return view('sign_up');
    }
    public function forgetp()
    {
        return view('forgetp');
    }

    ////////////////////
    public function home()
    {
        // echo url('');
        // die();
        // foreach ($allDirectMail as $email) {

        // }
        $currentURL =  url()->current();
        $slugs = explode('/', $currentURL);
        $lastSlug = end($slugs);
       return view('home.dashboard', ['lastSlug' => $lastSlug]);

    }
    public function outbox()
    {
        $currentURL =  url()->current();
        $slugs = explode('/', $currentURL);
        $lastSlug = end($slugs);
        return view('home.outbox', ['lastSlug' => $lastSlug]);
    }
    public function sent()
    {
        $currentURL =  url()->current();
        $slugs = explode('/', $currentURL);
        $lastSlug = end($slugs);
        return view('home.sent', ['lastSlug' => $lastSlug]);
    }
    public function profile()
    {
        $currentURL =  url()->current();
        $slugs = explode('/', $currentURL);
        $lastSlug = end($slugs);
        return view('home.profile', ['lastSlug' => $lastSlug]);
    }
    // inbox+sent clicked message details page
    public function msg_box($direct_mail_id)
    {
        readStatusUpdate($direct_mail_id);

         //customer details info get
        $customer_id = session()->get('customer_id');
        $customerDetailsInfo = Customer::findOrFail($customer_id);


        $mailDetails = directMailInfo($direct_mail_id);
        $replyMail = allReplyMail($direct_mail_id);
        $latestReply = ReplyMail::where('direct_mail_id',$direct_mail_id)->orderBy('id','DESC')->take(2)->get();
        $reversed_latestReply = $latestReply->reverse();
        $clientInfo = clientDetails($direct_mail_id);
        $quickReply = $mailDetails->quick_reply ? quickReply($direct_mail_id) : null;
        $reminder = $mailDetails->remainder ? mailReminder($direct_mail_id) : null;
        $cc = $mailDetails->cc ? ccList($direct_mail_id) : null;
        $fileSize = $mailDetails->mail_file ? mailFileSize($direct_mail_id) : null;
        $replyMailCount = allReplyMail($direct_mail_id)->count();
//        return response()->json([
//            'mailDetails'=>$mailDetails,
//            'replyMail'=>$replyMail,
//            'clientInfo'=>$clientInfo,
//            'quickReply'=>$quickReply,
//            'reminder'=>$reminder,
//            'cc'=>$cc,
//            'fileSize'=>$fileSize,
//            'replyMailCount'=>$replyMailCount,
//            'reversed_latestReply'=>$reversed_latestReply
//        ],200);
        return view('home.msg_box',compact('customerDetailsInfo','mailDetails','replyMail','clientInfo','quickReply','reminder','cc','fileSize','replyMailCount','reversed_latestReply'));
    }
     // outbox clicked message details page
    public function outbox_details()
    {
        return view('home.outbox_details');
    }
    public function policy()
    {
        return view('home.policy');
    }
    public function faq()
    {
        return view('home.faq');
    }
    public function logout()
    {
        return redirect(url('welcome'));
    }
    public function testClient(){
        $directMail = DirectMail::where('type','=','customer')->orderBy('id','DESC')->get();
        $client = DB::table('directmail')
        ->join('clients','directmail.sender','=','clients.email')
        ->select('clients.name','clients.profile_picture','directmail.*')
            ->where('directmail.type','=','customer')
            ->orderBy('id','DESC')
            ->get();
        return response()->json($client,200);
    }

    public function getRemainderReply(Request $request,$id){
        $res = DB::table('directmail')
        ->join('remainders','directmail.id','=','remainders.direct_mail_id')
        ->join('quick_replies','directmail.id','=','quick_replies.direct_mail_id')
        ->where('directmail.id',$request->id)
        ->select('remainders.remainder','quick_replies.reply')->get();
        return response()->json($res,200);
    }
    // search form works
    public function search(Request $request)
    {
       // $query = $request->get('query');
        $allDirectMail = DirectMail::where('sender','like','%'.$request->search.'%')
            ->orWhere('tag', 'like','%'.$request->search.'%')
            ->orWhere('subject', 'like','%'.$request->search.'%')
            ->orWhere('mail_body', 'like','%'.$request->search.'%')
            ->get();
//        return redirect()->back()->with('allDirectMail',$allDirectMail);
        return response()->json($allDirectMail,200);
    }
}
