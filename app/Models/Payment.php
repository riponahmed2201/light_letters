<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentPackage;
class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'client_id',
        'name',
        'address',
        'city',
        'zip',
        'country',
        'card_number',
        'card_holder_name',
        'expire_date',
        'cvv',
        'type',
        'price',
        'date_of_purchase',
        'date_of_next_renewal'
    ];
    use HasFactory;
    // public function packagePayment(){
    //     return $this->hasMany(PaymentPackage::class,'short_description');
    // }
    public function packagePayment(){
        return $this->hasOne('App\Models\PaymentPackage','package_name','type');
    }
}
