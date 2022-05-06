<?php

namespace Database\Seeders;

use App\Models\MaterialArticle;
use App\Models\MaterialCourtDecision;
use App\Models\MaterialDecisionStatus;
use App\Models\MaterialLanguage;
use App\Models\MaterialObjectType;
use App\Models\MaterialStatus;
use App\Models\MaterialType;
use App\Models\MaterialTypeObjectType;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Язык
        $titles = [
            'ky' => 'Кыргызский',
            'ru' => 'Русский',
            'uz' => 'Узбекский',
            'ar' => 'Арабский',
            'tr' => 'Турецкий',
        ];
        foreach ($titles as $key => $title) {
            MaterialLanguage::create(['code' => $key, 'title' => $title]);
        }
        // Статус материала
        $titles = [
            'В обработке',
            'В производстве',
            'Обработан',
        ];
        foreach ($titles as $title) {
            MaterialStatus::create(['title' => $title]);
        }
        // Блок Решение суда по материалу
        // Статья
        $titles = [
            'Статья 1',
        ];
        foreach ($titles as $title) {
            MaterialArticle::create(['title' => $title]);
        }
        // Решение суда по признанию материала
        $titles = [
            'Захват власти',
            'Нарушение конституционного строя',
            'Религиозный экстремизм',
            'Межрегиональная вражда',
            'Межнациональная вражда',
            'Оскорбление представителя власти',
            'Оскорбление религиозных чувств',
        ];
        foreach ($titles as $title) {
            MaterialCourtDecision::create(['title' => $title]);
        }

        // Статус решение суда
        $titles = [
            'Создан',
            'В обработке',
            'Обработан',
        ];
        foreach ($titles as $title) {
            MaterialDecisionStatus::create(['title' => $title]);
        }

        // Объект экспертизы
        $titles = [
            'Текст',
            'Устный текст',
            'Изображение',
        ];
        foreach ($titles as $title) {
            if (!MaterialObjectType::where('title', $title)->exists())
                MaterialObjectType::create(['title' => $title]);
        }
        // Тип материала
        $titles = [
            'газета',
            'книга',
            'журнал',
            'брошюра',
            'аналитический обзор',
            'статья',
            'заметка',
            'пост в интернете',
            'листовка',
            'личное обращение',
            'плокат',
            'аудиозапись',
            'видеозапись',
            'фонограмма',
            'рисунок ',
            'карикатура ',
            'символ',
            'атрибут',
            'учредительные документы',
            'религиозная литература',
            'документы религиозного содержания',
            'иные документы',
            'иное',
        ];
        foreach ($titles as $title) {
            if (!MaterialType::where('title', $title)->exists())
                MaterialType::create(['title' => $title]);
        }
        //
        $titles = [
            'Текст' => [
                'газета',
                'книга',
                'журнал',
                'брошюра',
                'аналитический обзор',
                'статья',
                'заметка',
                'пост в интернете',
                'листовка',
                'личное обращение',
                'плокат',
                'учредительные документы',
                'религиозная литература',
                'документы религиозного содержания',
                'иные документы',
                'иное',
            ],
            'Устный текст' => [
                'аудиозапись',
                'видеозапись',
                'фонограмма',
                'религиозная литература',
                'иное',
            ],
            'Изображение' => [
                'газета',
                'книга',
                'журнал',
                'брошюра',
                'статья',
                'заметка',
                'пост в интернете',
                'листовка',
                'личное обращение',
                'плокат',
                'рисунок ',
                'карикатура ',
                'символ',
                'учредительные документы',
                'религиозная литература',
                'документы религиозного содержания',
                'иные документы',
                'иное',
            ],
        ];
        foreach ($titles as $title => $subtitles) {
            $record = MaterialObjectType::where(['title'=>$title])->first();
            foreach ($subtitles as $subtitle) {
                $subrecord = MaterialType::where(['title' => $subtitle])->first();
                MaterialTypeObjectType::create(['object_type_id' => $record->id, 'type_id' => $subrecord->id]);
            }
        }
    }
}
