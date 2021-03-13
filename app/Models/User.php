<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'userid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return  $this->belongsTo('App\Models\Role');  //model path
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post'); //ek user er onk post thakbe
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment'); //ek user er onk comment thakbe
    }

    
    public function replies()
    {
        return $this->hasMany('App\Models\CommentReply');
    }

    // many to many
    public function likedPosts()
    {
        return $this->belongsToMany('App\Models\Post')->withTimestamps();
    }
}