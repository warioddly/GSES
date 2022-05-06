<?php

namespace Database\Seeders;

use App\Models\ExpertisePetitionStatus;
use App\Models\ExpertisePetitionType;
use Illuminate\Database\Seeder;

class ExpertisePetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Тип
        $titles = [
            'Продление срока производства экспертизы',
            'Данная экспертиза не проводится',
            'Отсутствуют требуемые материалы',
            'Не возможность дачи экспертизы',
            'Возврат материалов без исполнения',
        ];
        foreach ($titles as $title) {
            ExpertisePetitionType::create(['title' => $title]);
        }
        // Статус
        $titles = [
            'В работе',
            'Черновик',
            'Отправлен заказчику',
        ];
        foreach ($titles as $title) {
            ExpertisePetitionStatus::create(['title' => $title]);
        }
    }
}
