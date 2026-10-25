<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadCount extends Model
{
    protected $connection = 'infospare';
    
    protected $fillable = ['count'];
    
    protected $casts = [
        'count' => 'integer',
    ];
}
