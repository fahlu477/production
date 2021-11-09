<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineToTarget extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'rework_ltarget';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'tgl_input', // tgl_input                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
        'tgl_pengerjaan', // tgl_pengerjaan
        'tgl_pengerjaan2', // tgl_pengerjaan2
        'id_line', // line id
        'no_wo', // nomor wo
        'order_quantity', // order quantity
        'target_wo', // target wo
        'proses', // proses
        'detail_id', // detail_id
        'spv_app', //status app spv
        'spv_name', // spv yang app
        'created_by', // orang yang membuat
        'edited_by' //orang yang mengedit
    ];

    public function masterline()
    {
        return $this->belongsTo('App\MasterLine','id');
    }

    public function detail()
    {
        return $this->hasMany('App\LineDetail', 'target_id');
    }
}
