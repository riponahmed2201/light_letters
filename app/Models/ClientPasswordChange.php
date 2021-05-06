<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPasswordChange extends Model
{
    protected $table = 'client_password_changes';
    protected $fillable = [
        'client_id',
        'email',
        'request_status',
        'verification',
        'confirmation'
    ];
    use HasFactory;
}
