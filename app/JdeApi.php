<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JdeApi extends Model
{
    protected $connection = 'mysql2';
    protected $table = "t_v4801c";
    protected $primaryKey = 'F4801_DOCO';

    protected $fillable = [
        'F4801_DOCO', // NO WO
        'F4801_AITM',  // second item 
        'F4801_DL01',  // item description
        'F4801_UORG',  // order quantity
        'F4801_SOQS',  // quantity shipped
        'F4801_DL01',  // no_so
    ];

    public function wobreakdown()
    {
        return $this->hasMany('App\WOBreakDown', 'F560020_DOCO');
    }

}
