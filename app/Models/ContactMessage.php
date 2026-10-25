<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $connection = 'infospare';
    
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];
}
