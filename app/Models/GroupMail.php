<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupMail extends Model
{
    protected $table = 'group_mails';
    protected $fillable = [
        'id',
        'group_id',
        'client_id',
        'receiver',
        'sender',
        'mail_body',
        'type',
        'cc',
        'bcc',
        'tag',
        'subject',
        'quick_reply',
        'remainder',
        'deadline',
        'read_status',
        'mail_file',
        'hide_status',
        'close_cause',
        'mail_close'
    ];

    protected $casts = [
    'cc' => 'array',
     'quick_reply' => 'array',
     'remainder'=>'array',
        'receiver'=>'array'
];
 protected $dates = ['deadline'];
    use HasFactory;
    use SoftDeletes;
}
