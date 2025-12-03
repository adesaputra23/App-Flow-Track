<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';
    public $incrementing = true;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }

}
