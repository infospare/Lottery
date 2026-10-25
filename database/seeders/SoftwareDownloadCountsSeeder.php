<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoftwareDownloadCount;

class SoftwareDownloadCountsSeeder extends Seeder
{
    public function run(): void
    {
        $software = [
            [
                'name' => 'lottery_software',
                'display_name' => 'Lottery Software',
                'description' => 'A Complete Lottery Software with all features included. Daily draws, real-time results, ticket scanning, prize detection, detailed statistics, and much more. Fully Customizable and easy to use. Free Demo Available.',
                'download_count' => 0,
                'size' => '20MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'lottery_software.exe',
                'zip_file_path' => 'lottery_software.zip',
                'image_path' => 'lottery_software.jpg',
            ],
            [
                'name' => 'pharmacy_software',
                'display_name' => 'Pharmacy Software',
                'description' => 'Pharmacy Software',
                'download_count' => 0,
                'size' => '19MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'pharmacy_software.exe',
                'zip_file_path' => 'pharmacy_software.zip',
                'image_path' => 'pharmacy_software.jpg',
            ],
            [
                'name' => 'Library_software',
                'display_name' => 'Library Software',
                'description' => 'Library Software',
                'download_count' => 0,
                'size' => '100MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'Library_software.exe',
                'zip_file_path' => 'Library_software.zip',
                'image_path' => 'Library_software.jpg',
            ],
            [
                'name' => 'textile_software',
                'display_name' => 'Textile Software',
                'description' => 'Textile Software',
                'download_count' => 0,
                'size' => '18.5MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'textile_software.exe',
                'zip_file_path' => 'textile_software.zip',
                'image_path' => 'textile_software.jpg',
            ],
            [
                'name' => 'hardware_shop_software',
                'display_name' => 'Hardware Shop Software',
                'description' => 'Hardware Shop Software',
                'download_count' => 0,
                'size' => '16.5MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'hardware_shop_software.exe',
                'zip_file_path' => 'hardware_shop_software.zip',
                'image_path' => 'hardware_shop_software.jpg',
            ],
            [
                'name' => 'temple_software',
                'display_name' => 'Temple Software',
                'description' => 'Temple Software',
                'download_count' => 0,
                'size' => '12MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'temple_software.exe',
                'zip_file_path' => 'temple_software.zip',
                'image_path' => 'temple_software.jpg',
            ],
            [
                'name' => 'jewellery_software',
                'display_name' => 'Jewellery Software',
                'description' => 'Jewellery Software',
                'download_count' => 0,
                'size' => '25MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'jewellery_software.exe',
                'zip_file_path' => 'jewellery_software.zip',
                'image_path' => 'jewellery_software.jpg',
            ],
            [
                'name' => 'Ayurveda_software',
                'display_name' => 'Ayurveda Software',
                'description' => 'Ayurveda Software',
                'download_count' => 0,
                'size' => '20MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'Ayurveda_software.exe',
                'zip_file_path' => 'Ayurveda_software.zip',
                'image_path' => 'Ayurveda_software.jpg',
            ],
            [
                'name' => 'Mobile_software',
                'display_name' => 'Mobile Shop Software',
                'description' => 'Mobile Shop Software',
                'download_count' => 0,
                'size' => '18MB',
                'last_updated' => '2025-01-01',
                'file_path' => 'Mobile_Shop_software.exe',
                'zip_file_path' => 'Mobile_Shop_software.zip',
                'image_path' => 'Mobile_Shop_software.jpg',
            ],
        ];

        foreach ($software as $item) {
            SoftwareDownloadCount::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
