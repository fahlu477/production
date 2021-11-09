<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndahJPiket extends Model
{
    protected $connection = 'mysql4';
    protected $table = 'indah_jpiket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'day',
        'hari',    
        'petugas1',
        'petugas2',
        'petugas3',
        'petugas4',
        'petugas5',
        'petugas6',
        'petugas7',
        'petugas8',   
        'petugas9',
        'petugas10',
    ];

}
