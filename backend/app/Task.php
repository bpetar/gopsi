<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
    	'title',
    	'description',
        'author_id',
        'client_id',
        'status',
        'image',
        'client_notes',
        'repeat',
        'counter'
    ];

    
    /**
     * Get the author that wrote the article.
     */
    public function author()
    {
        return $this->belongsTo('App\Author');
    }
}
