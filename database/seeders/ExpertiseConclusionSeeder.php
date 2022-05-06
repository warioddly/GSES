<?php

namespace Database\Seeders;

use App\Models\MaterialConclusionStatus;
use Illuminate\Database\Seeder;

class MaterialConclusionSeeder extends Seeder
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
            'Создан',
            'В обработке',
            'Обработан',
        ];
        foreach ($titles as $title) {
            MaterialConclusionStatus::create(['title' => $title]);
        }
    }
}
