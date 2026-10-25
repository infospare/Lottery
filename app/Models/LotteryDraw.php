<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryDraw extends Model
{
    protected $connection = 'infospare';

    protected $table = 'lottery_draws';

    protected $fillable = [
        'lottery_name',
        'draw_code',
        'draw_date',
        'status',
        'description',
        'file_path',
        'original_filename',
        'results',
    ];

    protected $casts = [
        'draw_date' => 'date',
        'results' => 'array',
    ];

    public function getDisplayLabelAttribute(): string
    {
        return "{$this->lottery_name}({$this->draw_code})";
    }

    public function getFormattedDrawDateAttribute(): string
    {
        return $this->draw_date->format('d/m/Y');
    }

    /**
     * Next draw code for a lottery (e.g. DL-69 -> DL-70).
     * Uses the highest numeric suffix among codes like PREFIX-NUMBER.
     */
    public static function nextDrawCodeFor(string $lotteryName): string
    {
        $lotteryName = strtoupper(trim($lotteryName));
        if ($lotteryName === '') {
            return '';
        }

        $codes = static::where('lottery_name', $lotteryName)->pluck('draw_code');

        $bestPrefix = null;
        $bestNumber = null;

        foreach ($codes as $code) {
            $code = trim((string) $code);
            if (!preg_match('/^([A-Za-z]+)\s*[-_]?\s*(\d+)$/', $code, $matches)) {
                continue;
            }

            $prefix = strtoupper($matches[1]);
            $number = (int) $matches[2];

            if ($bestNumber === null || $number > $bestNumber) {
                $bestNumber = $number;
                $bestPrefix = $prefix;
            }
        }

        if ($bestPrefix === null || $bestNumber === null) {
            return '';
        }

        return $bestPrefix . '-' . ($bestNumber + 1);
    }

    public function resolveFilePath(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        $paths = [
            storage_path('app/public/' . $this->file_path),
            public_path('storage/' . $this->file_path),
            public_path($this->file_path),
            public_path('lottery-results/' . basename($this->file_path)),
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
