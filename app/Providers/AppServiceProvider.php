<?php

namespace App\Providers;
use App\Models\Client;
use App\Models\Customer;
use App\Models\DirectMail;
use App\Models\PasswordChange;
use App\Models\QuickReply;
use App\Models\ReplyMail;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //public function boot(Router $router)

    public function boot(Router $router)
    {
//
//        if (env('APP_ENV') !== 'local') {
//            $urlGenerator->forceScheme('https');
//        }
        //---------------------------------------------------------------------------------------------
        $router->bind('id',function($id){ // route:  /reports/{id}
            $this->mailDetails($id);
        });
//        app()->bind('yoo',function ($id){
//            return DirectMail::where('id',$id)->first();
//        });
        //---------------------------------------------------------------------------------------------
        View::composer('*', function ($view){
            $directMail = DB::table('directmail')
                ->join('clients','directmail.sender','=','clients.email')
                ->select('clients.name','clients.profile_picture','directmail.*')
                ->where('directmail.type','=','customer')
                ->where('directmail.receiver','=',session('email'))
                ->where('deleted_at','=',null)
                ->orderBy('id','DESC')
                ->get();
            $view->with('customerInfo', Customer::where('id','=',session('customer_id'))->first());
            $view->with('passInfo',PasswordChange::where('customer_id',session('customer_id'))->first());
            $view->with('allDirectMail',$directMail);
            $view->with('directMailCount', DirectMail::where('type','=','customer')->where('receiver','=',session('email'))->count());
        });
    }
    //-----------------------------NEW SUB METHOD----------------------------------------------------------------
    public function mailDetails($id){
        $mailDetails = DirectMail::where('id',$id)->first();
        $replyMail = ReplyMail::where('direct_mail_id', $id)->orderBy('id','ASC')->get();
        $clientInfo = DB::table('directmail')
            ->join('clients','directmail.sender','=','clients.email')
            ->select('clients.name','clients.email','clients.profile_picture')
            ->where('clients.email','=',$mailDetails->sender)
            ->first();
//        $quickReply = DB::table('directmail')
//            ->join('quick_replies','directmail.id','=','quick_replies.direct_mail_id')
//            ->where('directmail.id',$id)
//            ->select('quick_replies.reply')->get();
        $quickReply = json_decode($mailDetails->quick_reply,true);
        $cc = json_decode($mailDetails->cc,true);
//$replyFile = round(filesize(public_path('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file))/1024);
        $file = public_path('/uploads/mail_file/direct_mail/'.$mailDetails->mail_file);
        $size = filesize($file) ;
        $fileType = filetype($file);
        $fileSize = round($size/1024);
//        $quickReply = $quickReply[0];
//        $reminder = DB::table('directmail')
//            ->join('remainders','directmail.id','=','remainders.direct_mail_id')
//            ->where('directmail.id',$id)
//            ->select('remainders.remainder')->get();
        $reminder = json_decode($mailDetails->remainder,true);

        View::composer('home.msg_box',function ($view) use ($id,$mailDetails,$replyMail,$clientInfo,$quickReply,$reminder,$cc,$fileSize,$fileType){
            $view->with('mailDetails',$mailDetails);
            $view->with('replyMail',$replyMail);
            $view->with('clientInfo',$clientInfo);
            $view->with('quickReply',$quickReply);
            $view->with('reminder',$reminder);
            $view->with('cc',$cc);
            $view->with('fileSize',$fileSize);
            $view->with('fileType',$fileType);
            $view->with('replyMailCount',ReplyMail::where('direct_mail_id', $id)->count());
        });
    }
}
