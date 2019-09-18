<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Table Name
    protected $table = 'review';
    // Primary Key
    public $primaryKey = 'id';
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
