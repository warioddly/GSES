<?php

namespace Database\Seeders;

use App\Models\MarkerWordType;
use Illuminate\Database\Seeder;

class MaterialContentAnalyzeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Тип слова
        $titles = [
            'Простое слово',
            'Стоп-слово',
            'Ключевое слово',
        ];
        foreach ($titles as $title) {
            MarkerWordType::create(['title' => $title]);
        }
    }
}
