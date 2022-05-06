<?php

namespace Database\Seeders;

use App\Models\MarkerStatus;
use App\Models\MarkerTerminology;
use Illuminate\Database\Seeder;

class MarkerBlackWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Терминология
        $titles = [
            'Общая',
            'Специфическая',
        ];
        foreach ($titles as $title) {
            MarkerTerminology::create(['title' => $title]);
        }
        // Статус
        $titles = [
            'Актуален',
            'Не актуален',
        ];
        foreach ($titles as $title) {
            MarkerStatus::create(['title' => $title]);
        }
    }
}
