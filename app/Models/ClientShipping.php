<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientShipping extends Model
{
    protected $table = 'clientshipping';
    protected $fillable = ['id','billing_id','s_name','s_address','s_city','s_phone','s_country'];
    use HasFactory;
}
