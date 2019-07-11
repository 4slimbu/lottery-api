<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'content'];


    public function scopeFilter($query, $params)
    {
        if (!empty($params['title'])) {
            $query = $query->where(function($q) use ($params) {
                $q->where('title', 'LIKE', '%' . $params['name'] . '%');
            });
        }

        return $query;
    }

}
