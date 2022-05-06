<?php

namespace Database\Seeders;

use App\Models\UserPosition;
use App\Models\UserSpeciality;
use App\Models\UserSpecialityNumber;
use App\Models\UserSpecialitySpecialityNumber;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Должность
        $titles = [
            'EXPERT' => 'Эксперт'
        ];
        foreach ($titles as $code => $title) {
            UserPosition::create(['title' => $title, 'code' => $code]);
        }
        // Наименование специальности высшего профильного образования
        $titles = [
            '23.1' => [
                'Психология',
                'Клиническая психология',
                'Дошкольная педагогика и психология',
                'Педагогика и психология',
                'Специальная психология',
            ],
            '23.2' => [
                'Психология',
                'Клиническая психология',
                'Дошкольная педагогика и психология',
                'Педагогика и психология',
                'Специальная психология',
            ],
            '28.1' => [
                'Филология'
            ],
        ];
        foreach ($titles as $title => $subtitles) {
            $record = UserSpecialityNumber::create(['title' => $title]);
            foreach ($subtitles as $subtitle) {
                $subrecord = UserSpeciality::where(['title' => $subtitle])->first();
                if (!$subrecord) {
                    $subrecord = UserSpeciality::create(['title' => $subtitle]);
                }
                UserSpecialitySpecialityNumber::create(['speciality_id'=>$subrecord->id, 'speciality_number_id' => $record->id]);
            }
        }
    }
}
