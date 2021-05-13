<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Author extends Model
{
    //
    
    /**
     * Get the articles for the author.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Get the user for the author.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
