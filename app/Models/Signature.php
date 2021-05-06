<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'signatures';
    protected $fillable = [
        'id',
        'signature',
        'client_id',
        'name',
        'designation',
        'phone',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'website'
    ];
    use HasFactory;
}
