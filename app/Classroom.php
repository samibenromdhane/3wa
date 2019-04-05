<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = 
    [
        'tables', 'computers', 'title'
    ];

    public function students()
	{
       return $this->hasMany('App\Student','classroom_id','id');
  	}
}
