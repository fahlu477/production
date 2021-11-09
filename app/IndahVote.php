<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndahVote extends Model
{
    protected $connection = 'mysql4';
    protected $table = 'indah_Vote';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nik',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
        'like', 
        'dislike',
        'nama',
        'bagian', 
        'created_by', // Orang yang menambahkan
        'edited_by', // Orang yang mengedit 
        'tgl_vote',
        'bulan',
        'created_nik'// nik petugas yang vote
    ];

   // public function getkaryawan(){
    //    return $this->belongsTo('App\user', 'nik', 'nik');
  //  }

}