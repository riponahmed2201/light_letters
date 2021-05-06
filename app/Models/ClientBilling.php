<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBilling extends Model
{
    protected $table = 'clientbilling';
    protected $fillable = ['id','client_id','b_name','b_address','b_city','b_phone','b_country','package','description'];
    use HasFactory;
}
