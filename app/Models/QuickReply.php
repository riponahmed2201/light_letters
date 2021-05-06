<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickReply extends Model
{
    protected $table = 'quick_replies';
    protected $fillable = [
        'id',
        'direct_mail_id',
        'reply'
    ];
    use HasFactory;
}
