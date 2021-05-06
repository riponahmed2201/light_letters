<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class PaymentPackage extends Model
{
    protected $table = 'payment_packages';
    protected $fillable = [
        'id',
        'package_name',
        'short_description',
        'long_description',
        'price',
        'features'
    ];
    // public function Payment(){
    //     return $this->belongsTo('Payment');
    // }
    protected $casts = [
        'features' => 'array'
    ];
    use HasFactory;
}
