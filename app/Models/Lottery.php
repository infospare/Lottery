<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $connection = 'infospare';

    protected $table = 'lotteries';

    protected $fillable = [
        'name',
    ];
}
