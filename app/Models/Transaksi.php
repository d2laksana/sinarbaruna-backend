<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'moulding_id'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}
