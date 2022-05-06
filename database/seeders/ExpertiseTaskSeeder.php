<?php

namespace Database\Seeders;

use App\Models\ExpertiseTaskStatus;
use Illuminate\Database\Seeder;

class ExpertiseTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Степень сложности
        $titles = [
            'Создан',
            'В обработке',
            'Обработан',
        ];
        foreach ($titles as $title) {
            ExpertiseTaskStatus::create(['title' => $title]);
        }
    }
}
