<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';

    protected $fillable = [
        'page_id', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image', 'twitter_title', 'twitter_description', 'twitter_image'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeFilter($query, $params)
    {
        return $query;
    }
}
