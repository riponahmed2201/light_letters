<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMail extends Model
{
    protected $table = 'schedulemail';
    protected $fillable = [
        'id',
        'client_id',
        'receiver',
        'receiver_group',
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
        'file_name',
        'reply_status',
        'hide_status',
        'schedule'
    ];
    protected $casts = [
    'cc' => 'array',
     'quick_reply' => 'array',
     'remainder'=>'array',
        'receiver_group'=>'array'
    ];
    protected $dates = ['deadline'];
    /**
     * @var mixed
     */
    private $tag;
    use HasFactory;
}
