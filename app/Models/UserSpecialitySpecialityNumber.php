<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpecialitySpecialityNumber extends Model
{
    use HasFactory;

    protected $table = 'user_speciality_speciality_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'speciality_id',
        'speciality_number_id',
    ];


    public function speciality(){
        return $this->hasOne(UserSpeciality::class, 'id', 'speciality_id');
    }

    public function specialityNumber(){
        return $this->hasOne(UserSpecialityNumber::class, 'id', 'speciality_number_id');
    }
}
