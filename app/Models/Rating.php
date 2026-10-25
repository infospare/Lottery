<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $connection = 'infospare';
    
    protected $fillable = [
        'software_download_count_id',
        'user_identifier',
        'rating',
    ];
    
    protected $casts = [
        'rating' => 'integer',
    ];
    
    public function softwareDownload()
    {
        return $this->belongsTo(SoftwareDownloadCount::class, 'software_download_count_id');
    }
}
