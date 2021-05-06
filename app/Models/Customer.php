<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DirectMail;
use Illuminate\Database\Eloquent\SoftDeletes;
class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    protected $fillable = ['id',
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_picture',
        'phone',
        'status',
        'group',
        'tag',
        'id_type',
        'nid',
        'ra_type',
        'ra_file',
        'road',
        'house',
        'city',
        'zip',
        'country',
    ];
    use HasFactory;
//    public function customerInfo(){
//        return $this->belongsTo('DirectMail');
//    }
}
