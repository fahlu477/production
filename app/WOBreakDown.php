<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WOBreakDown extends Model
{
    protected $connection = 'mysql2';
    protected $table = "t_v560020a";

    protected $fillable = [
        'F560020_DOCO', // NO WO
        'F560020_SEG3', // Country
        'F560020_SEG4', // Colour
        'F560020_SIZE55', // Size
        'F560020_DSC1', // Description
    ];

    public function wo()
    {
        return $this->belongsTo('App\JdeApi','F4801_DOCO');
        // note: we can also inlcude Mobile model like: 'App\Mobile'
    }
}
