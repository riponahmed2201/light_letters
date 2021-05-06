<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientMail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'clientmail';
    protected $fillable = [
        'id',
        'client_id',
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
        'hide_status'
    ];

     protected $casts = [
        'cc' => 'array',
        'quick_reply' => 'array',
        'remainder'=>'array'
    ];
    protected $dates = ['deadline'];
}
