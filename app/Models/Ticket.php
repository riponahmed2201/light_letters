<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'ticket_id',
        'title',
        'client_id',
        'cc',
        'subject',
        'email',
        'description',
        'date',
        'status',
        'type',
        'comment',
    ];
}
