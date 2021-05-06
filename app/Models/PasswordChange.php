<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordChange extends Model
{
    protected $table = 'password_changes';
    protected $fillable = [
        'customer_id',
        'email',
        'request_status',
        'verification',
        'confirmation'
    ];
    use HasFactory;
}
