<?php

namespace App\Acme\Models;

use App\Acme\Traits\JobTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    static public $POST_IMAGES_AWS_PATH = 'loksewa/{userId}/{postId}';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_title',
        'post_body',
        'location_id',
        'category_id',
        'expire_at'
    ];

    protected $with = [
        'media', 'location', 'category', 'comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function myComments()
    {
        return $this->hasMany(Comment::class, 'post_id')
            ->where('user_id', auth()->user()->id);
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'post_id');
    }

}