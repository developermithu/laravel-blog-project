<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = FALSE;

    // ekta tag er ekta post & belongsTo hole method name (singular)
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'postID', 'id');
    }
}
