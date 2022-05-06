<?php

namespace Database\Seeders;

use App\Models\ReportStatus;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Статус
        $titles = [
            'Активный',
            'Не активный',
        ];
        foreach ($titles as $title) {
            ReportStatus::create(['title' => $title]);
        }
    }
}
