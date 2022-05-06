<?php

namespace Database\Seeders;

use App\Models\DocumentTemplateStatus;
use Illuminate\Database\Seeder;

class DocumentTemplateSeeder extends Seeder
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
            'Актуален',
            'Не актуален',
        ];
        foreach ($titles as $title) {
            DocumentTemplateStatus::create(['title' => $title]);
        }
    }
}
