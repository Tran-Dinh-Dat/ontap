<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model
{
    protected $table = 'url_short';
    protected $primaryKey = 'id';
    protected $fillable = [
        'url',
        'short'
    ];
}
