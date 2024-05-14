<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_moulding',
        'user_id',
        'tanggal',
        'type_moulding',
        'durasi',
        'mulai_tanggal',
        'keterangan'
    ];
}
