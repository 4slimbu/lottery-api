<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_primary', 'post_id', 'user_id', 'url'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}