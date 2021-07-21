<?php

namespace App\Acme\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFormEntry extends Model
{
    protected $table = 'contact_form_entries';

    protected $fillable = [
        'name', 'email', 'subject', 'message'
    ];

    public function scopeFilter($query, $params)
    {
        return $query;
    }
}
