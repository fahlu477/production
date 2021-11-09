<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterLine extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'rework_line';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'string1',  // kode Line   
        'string2',  // nama Line   
        'branch',  // branch   
        'branch_detail'  // branch_detail
    ];

    public function luser()
    {
        return $this->hasMany('App\LineToUser', 'id_line');
    }

    public function ltarget()
    {
        return $this->hasMany('App\LineToTarget', 'id_line');
    }
}
