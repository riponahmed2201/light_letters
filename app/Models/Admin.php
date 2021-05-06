<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admins';
    protected $fillable = [
        'id',
        'client_id',
        'name',
        'email',
        'role',
        'profile_picture',
        'password'
    ];
}
