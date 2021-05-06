<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remainder extends Model
{
    protected $table = 'remainders';
    protected $fillable = [
        'id',
        'direct_mail_id',
        'remainder'
    ];
    use HasFactory;
}
