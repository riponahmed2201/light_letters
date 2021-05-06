<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientReply extends Model
{
    use SoftDeletes;
    protected $table = 'clientreply';
    protected $fillable = [
        'id',
        'receiver',
        'sender',
        'mail_body',
        'client_mail_id',
        'type',
        'cc',
        'bcc',
        'tag',
        'group',
        'subject',
        'mail_file',
        'read_status',
    ];
     protected $casts = [
    'cc' => 'array',
     'quick_reply' => 'array',
     'remainder'=>'array'

];
    use HasFactory;
}
