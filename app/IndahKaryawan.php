<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndahKaryawan extends Model
{
    protected $connection = 'mysql4';
    protected $table = 'indah_karyawan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'jabatan',
        'nama',    
        'kuota_like',
        'kuota_dislike', 
        'nik',   
    ];

}
