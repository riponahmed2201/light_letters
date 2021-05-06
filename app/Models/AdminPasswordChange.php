<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPasswordChange extends Model
{

    protected $table = 'admin_password_changes';
    protected $fillable = [
        'admin_id',
        'email',
        'request_status',
        'verification',
        'confirmation'
    ];
    use HasFactory;
}
