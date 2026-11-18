<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_pegawai',
        'nama_pegawai',
        'noHP_pegawai',
        'username',
        'password',
        'role',
    ];

    protected $hidden = ['password'];
}
