<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'kode_role',  
        'nama_role',  
        'created_at', 
        'updated_at'  
    ];
}
