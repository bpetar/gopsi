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
     * Get the clients for the author.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Get the archived clients for the author.
     */
    public function archived()
    {
        return $this->belongsToMany('App\User')->wherePivot('archived', 1);
    }

    /**
     * Get the active clients for the author.
     */
    public function active()
    {
        return $this->belongsToMany('App\User')->wherePivot('archived', 0);
    }

}
