<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareDownloadCount extends Model
{
    protected $connection = 'infospare';
    
    protected $table = 'software_download_counts';
    
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'download_count',
        'size',
        'last_updated',
        'file_path',
        'zip_file_path',
        'image_path',
    ];
    
    protected $casts = [
        'last_updated' => 'date',
        'download_count' => 'integer',
    ];
    
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'software_download_count_id');
    }
    
    public function getAverageRatingAttribute()
    {
        $average = $this->ratings()->avg('rating');
        return $average ? round($average, 1) : 0;
    }
    
    public function getRatingCountAttribute()
    {
        return $this->ratings()->count();
    }
}
