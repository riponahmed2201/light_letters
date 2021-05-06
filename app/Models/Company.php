<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'id',
        'client_id',
        'org_name',
        'tag_line',
        'email',
        'phone',
        'address',
        'website'];
    use HasFactory;
}
