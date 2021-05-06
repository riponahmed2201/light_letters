<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Customer;
use Illuminate\Database\Eloquent\SoftDeletes;
class DirectMail extends Model
{
    use SoftDeletes;
    protected $table = 'directmail';
    protected $fillable = [
        'id',
        'receiver',
        'sender',
        'mail_body',
        'type',
        'cc',
        'bcc',
        'tag',
        'group',
        'subject',
        'quick_reply',
        'remainder',
        'deadline',
        'read_status',
        'mail_file',
        'hide_status',
        'reply_status'
    ];
    use HasFactory;
//    public function clientData(){
//        return $this->hasMany(Client::class,'email');
//    }
//    public function customerData(){
//        return $this->hasMany(CustomerAuth::class,'email');
//    }
    public function clientDataAsSender(){
        return $this->hasOne('App\Models\Client','email','sender');
    }
    public function clientDataAsReceiver(){
        return $this->hasOne('App\Models\Client','email','receiver');
    }
    public function customerDataAsReceiver(){
        return $this->hasOne('App\Models\Customer','email','receiver');
    }
    public function customerDataAsSender(){
        return $this->hasOne('App\Models\Customer','email','sender');
    }


     protected $casts = [
     'cc' => 'array',
     'quick_reply' => 'array',
     'remainder'=>'array'

];
 protected $dates = ['deadline'];
}
