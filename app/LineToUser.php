<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineToUser extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'rework_luser';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_line', // id Line                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
        'id_user', // id Anggota
        'branch', // branch
        'branch_detail', // branch detail
        'created_by', // Orang yang menambahkan
        'edited_by' // Orang yang mengedit
    ];
    
    public function masterline()
    {
        return $this->belongsTo('App\MasterLine','id');
        // note: we can also inlcude Mobile model like: 'App\Mobile'
    }
}
