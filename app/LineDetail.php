<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineDetail extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'rework_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'target_id', // target_id                   
        'tgl_pengerjaan', // tgl_pengerjaan                
        'no_wo', // NO WO   
        'id_line', // ID Line                    
        'target_wo', // Target WO                     
        'target_terpenuhi', // Target Terpenuhi                     
        'total_check', // Total Check
        'total_reject', // Total Reject                
        'fg', // Finish Good        
        'p_fg',        
        'ip', // Iron Problem  
        'p_ip',            
        'sticker', // Sticker                 
        'p_sticker',   
        'meas', // Meas        
        'p_meas',                
        'trimming', // Trimming
        'p_trimming',                        
        'other', // Other       
        'p_other',               
        'ros', // Run Of Stich       
        'p_ros',                
        'broken', // Broken     
        'p_broken',                   
        'skip', // Skip    
        'p_skip',                   
        'pktw', // Puckering - Twisting       
        'p_pktw',                
        'crooked', // Crooked         
        'p_crooked',              
        'pleated', // Pleated            
        'p_pleated',           
        'htl', // HTL - Label   
        'p_htl',                    
        'button', // Button (HOLE)      
        'p_button',                  
        'print', // Print, Embro        
        'p_print',               
        'shading', // Shading        
        'p_shading',               
        'dof', // Defect on lab   
        'p_dof',                    
        'dirty', // Dirty, oil     
        'p_dirty',                  
        'shiny', // Shiny   
        'p_shiny',                    
        'bs', // Bad Shape         
        'p_bs',              
        'unb', //  UN-Balance      
        'p_unb',              
        'file', // File                
        'string1', // Remark                    
        'edited_by', // orang yang edit                      
        'created_at', //                       
        'updated_at' //                  
    ];

    public function target()
    {
        return $this->belongsTo('App\LineToTarget','id');
    }
}
