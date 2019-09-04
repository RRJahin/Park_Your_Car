<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PSpot extends Model
{
    // Table Name
    protected $table = 'p_spots';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    //public $timestamps = true;
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
