<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DirectMail;


class Client extends Model
{
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'profile_picture',
        'status',
        'company',
        'email',
        'activation_status',
        'password',
        'role',
        'admin_id',
        'company_address',
        'company_reg_no',
        'company_bit_no',
        'company_contact_person',
        'contact_person_designation',
        'number_of_employee',
        ];
    use HasFactory;
//    public function clientInfo(){
//        return $this->belongsTo('DirectMail');
//    }
}



