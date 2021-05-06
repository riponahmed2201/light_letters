<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = [
        'id',
        'client_id',
        'group_name',
        'customer_email',
        'customer_name',
        'description',
    ];
    protected $casts = [
        'customer_email' => 'array',
        'customer_name'=> 'array',
    ];
    use HasFactory;
}
