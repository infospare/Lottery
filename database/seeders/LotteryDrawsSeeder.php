<?php

namespace Database\Seeders;

use App\Models\LotteryDraw;
use Illuminate\Database\Seeder;

class LotteryDrawsSeeder extends Seeder
{
    public function run(): void
    {
        $draws = [
            ['lottery_name' => 'STHREE-SAKTHI', 'draw_code' => 'SS-534', 'draw_date' => '2026-08-25'],
            ['lottery_name' => 'BHAGYATHARA', 'draw_code' => 'BT-68', 'draw_date' => '2026-08-24'],
            ['lottery_name' => 'SAMRUDHI', 'draw_code' => 'SM-69', 'draw_date' => '2026-08-23'],
            ['lottery_name' => 'KARUNYA', 'draw_code' => 'KR-765', 'draw_date' => '2026-08-22'],
            ['lottery_name' => 'SUVARNA KERALAM', 'draw_code' => 'SK-66', 'draw_date' => '2026-08-21'],
            ['lottery_name' => 'KARUNYA PLUS', 'draw_code' => 'KN-637', 'draw_date' => '2026-08-20'],
            ['lottery_name' => 'DHANALEKSHMI', 'draw_code' => 'DL-66', 'draw_date' => '2026-08-19'],
            ['lottery_name' => 'STHREE-SAKTHI', 'draw_code' => 'SS-533', 'draw_date' => '2026-08-18'],
            ['lottery_name' => 'BHAGYATHARA', 'draw_code' => 'BT-67', 'draw_date' => '2026-08-17'],
            ['lottery_name' => 'SAMRUDHI', 'draw_code' => 'SM-68', 'draw_date' => '2026-08-16'],
            ['lottery_name' => 'KARUNYA', 'draw_code' => 'KR-764', 'draw_date' => '2026-08-15'],
            ['lottery_name' => 'SUVARNA KERALAM', 'draw_code' => 'SK-65', 'draw_date' => '2026-08-14'],
            ['lottery_name' => 'KARUNYA PLUS', 'draw_code' => 'KN-636', 'draw_date' => '2026-08-13'],
            ['lottery_name' => 'DHANALEKSHMI', 'draw_code' => 'DL-65', 'draw_date' => '2026-08-12'],
            ['lottery_name' => 'STHREE-SAKTHI', 'draw_code' => 'SS-532', 'draw_date' => '2026-08-11'],
            ['lottery_name' => 'BHAGYATHARA', 'draw_code' => 'BT-66', 'draw_date' => '2026-08-10'],
            ['lottery_name' => 'SAMRUDHI', 'draw_code' => 'SM-67', 'draw_date' => '2026-08-09'],
            ['lottery_name' => 'KARUNYA', 'draw_code' => 'KR-763', 'draw_date' => '2026-08-08'],
            ['lottery_name' => 'SUVARNA KERALAM', 'draw_code' => 'SK-64', 'draw_date' => '2026-08-07'],
            ['lottery_name' => 'KARUNYA PLUS', 'draw_code' => 'KN-635', 'draw_date' => '2026-08-06'],
            ['lottery_name' => 'DHANALEKSHMI', 'draw_code' => 'DL-64', 'draw_date' => '2026-08-05'],
            ['lottery_name' => 'STHREE-SAKTHI', 'draw_code' => 'SS-531', 'draw_date' => '2026-08-04'],
            ['lottery_name' => 'BHAGYATHARA', 'draw_code' => 'BT-65', 'draw_date' => '2026-08-03'],
            ['lottery_name' => 'SAMRUDHI', 'draw_code' => 'SM-66', 'draw_date' => '2026-08-02'],
            ['lottery_name' => 'KARUNYA', 'draw_code' => 'KR-762', 'draw_date' => '2026-08-01'],
        ];

        foreach ($draws as $draw) {
            LotteryDraw::updateOrCreate(
                [
                    'lottery_name' => $draw['lottery_name'],
                    'draw_code' => $draw['draw_code'],
                ],
                [
                    'draw_date' => $draw['draw_date'],
                ]
            );
        }
    }
}
