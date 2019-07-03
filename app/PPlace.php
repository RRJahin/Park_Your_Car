<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPlace extends Model
{
    // Table Name
    protected $table = 'p_places';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
