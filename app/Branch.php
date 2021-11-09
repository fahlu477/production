<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'kode_branch',  
        'branchdetail',  
        'nama_branch',  
        'created_at', 
        'updated_at'  
    ];
}
