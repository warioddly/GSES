<?php

namespace Database\Seeders;

use App\Models\ContractorOrgan;
use App\Models\ContractorType;
use Illuminate\Database\Seeder;

class ContractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Кем назначена экспертиза
        $titles = [
            'Орган',
            'Физическое лицо',
        ];
        foreach ($titles as $title) {
            ContractorType::create(['title' => $title]);
        }

        // Наименование органа, учреждения
        $titles = [
            'МВД',
            'ГКНБ',
            'ГСИН',
            'Верховный суд',
            'Местный суд',
            'ГСБЭП',
            'ГТС',
            'Военная прокуратура',
            'Физическое лицо',
        ];
        foreach ($titles as $title) {
            ContractorOrgan::create(['title' => $title]);
        }
    }
}
