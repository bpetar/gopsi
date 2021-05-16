<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Airlock\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the authors for the user.
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }

    /**
     * Get is user is author.
     */
    public function isAuthor()
    {
        $author = Author::where('user_id', $this->id)->get();
        return count($author) != 0 ? 'true' : 'false';
    }

    /**
     * Get author model if this user is author.
     */
    public function author()
    {
        $author = Author::where('user_id', $this->id)->get();
        return $author;
    }

    /**
     * Get author model if this user is author.
     */
    public function getClients()
    {
        $author = Author::where('user_id', $this->id)->get();
        return $author->users()->get();
    }
}
