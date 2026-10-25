<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubscriberCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/Subscribers-import.csv');

        if (!is_readable($path)) {
            $path = 'C:\\Users\\usr\\Desktop\\Subscribers.csv';
        }

        if (!is_readable($path)) {
            $this->command?->error("CSV not found: {$path}");
            return;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->command?->error('Could not open CSV.');
            return;
        }

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return;
        }

        $header = array_map(static function ($h) {
            $h = strtolower(trim((string) $h));
            return str_replace([' ', '-'], '_', $h);
        }, $header);

        $created = 0;
        $updated = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row, static fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            $data = [];
            foreach ($header as $i => $column) {
                if ($column === '') {
                    continue;
                }
                $data[$column] = isset($row[$i]) ? trim((string) $row[$i]) : '';
            }

            $name = $data['subscriber_name'] ?? $data['subscribername'] ?? '';
            $key = $data['registration_key'] ?? '';
            $registrationId = $data['registration_id'] ?? '';
            $expiryRaw = $data['expiry_date'] ?? '';
            $phone = $data['phone'] ?? '';

            if ($name === '' || $key === '' || $expiryRaw === '') {
                $skipped++;
                continue;
            }

            try {
                $expiry = Carbon::createFromFormat('d/m/Y', $expiryRaw)->format('Y-m-d');
            } catch (\Throwable $e) {
                try {
                    $expiry = Carbon::parse($expiryRaw)->format('Y-m-d');
                } catch (\Throwable $e2) {
                    $skipped++;
                    continue;
                }
            }

            $payload = [
                'subscriber_name' => $name,
                'phone' => $phone !== '' ? $phone : null,
                'registration_id' => $registrationId !== '' ? $registrationId : null,
                'registration_key' => $key,
                'expiry_date' => $expiry,
            ];

            $existing = Subscriber::where('registration_key', $key)->first();
            if ($existing) {
                $existing->update($payload);
                $updated++;
            } else {
                Subscriber::create($payload);
                $created++;
            }
        }

        fclose($handle);

        $this->command?->info("Subscribers import done. Created: {$created}, Updated: {$updated}, Skipped: {$skipped}");
    }
}
