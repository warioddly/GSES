<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Panoscape\History\HasOperations;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasOperations;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'last_name',
        'name',
        'middle_name',
        'position_id',
        'speciality_id',
        'speciality_number_id',
        'academic_degrees',
        'speciality_experience',
        'certificate_file_id',
        'certificate_valid_from',
        'certificate_valid_to',
        'phone',
        'email',
        'password',
        'status_id',
    ];


    public function position()
    {
        return $this->hasOne(UserPosition::class, 'id', 'position_id');
    }

    public function speciality()
    {
        return $this->hasOne(UserSpeciality::class, 'id', 'speciality_id');
    }

    public function specialityNumber()
    {
        return $this->hasOne(UserSpecialityNumber::class, 'id', 'speciality_number_id');
    }

    public function certificateFile()
    {
        return $this->hasOne(Document::class, 'id', 'certificate_file_id');
    }

    public function conclusion()
    {
        return $this->belongsToMany(MaterialConclusion::class, 'material_conclusion_experts', 'expert_id', 'conclusion_id');
    }

    public function expertiseTasks()
    {
        return $this->belongsToMany(
            ExpertiseTask::class, 'expertise_task_experts', 'expert_id', 'task_id');
    }

    public $appends = ['vir_full_name'];

    public function getVirFullNameAttribute()
    {
        $full_name = $this->last_name;
        if ($this->name) {
            $full_name .= ' ' . $this->name;
        }
        if ($this->middle_name) {
            $full_name .= ' ' . $this->middle_name;
        }
        return $full_name;
    }

    public function getInitialAttribute()
    {
        $result = [];

        !$this->name ?: array_push($result, mb_substr($this->name, 0, 1, 'UTF-8'));
        !$this->middle_name ?: array_push($result, mb_substr($this->middle_name, 0, 1, 'UTF-8'));
        array_push($result, $this->last_name);

        return implode('. ', $result);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAccessToExpertise(Expertise $expertise)
    {
        if (is_null($expertise)) {
            return false;
        }
        if ($this->hasRole('Admin') || $this->hasRole('Head of Department')) {
            return true;
        } elseif ($this->hasRole('Expert')) {
            if ($expertise->experts->where('id', $this->id)->count()) {
                return true;
            }
        } else {
            if (!$expertise->experts->count() && $expertise->creator_id == $this->id) {
                return true;
            }
        }
        return false;
    }

    public function hasAccessToMaterial($material, $action)
    {
        if (is_null($material)) {
            return false;
        }
        if ($this->hasRole('Admin') || $this->hasRole('Head of Department')) {
            return true;
        } else {
            $expertises = $material->vir_expertises;
            switch ($action) {
                case 'update':
                    if ($expertises->count() > 0) {
                        foreach ($expertises as $expertise) {
                            if (in_array($this->id, $expertise->experts->toArray())) {
                                return true;//не блокируем он эксперт экспертизы к которому привязан материал
                            }
                        }
                        return false;//блокируем если у материала есть экспертизы, и он не эксперт
                    }
                    return true; //не блокируем если у материала нет экспертизы
                case 'destroy':
                    if ($expertises->count() > 1) {
                        return false;//блокируем если у материала несколько экспертизы
                    } elseif ($expertises->count() == 1) {
                        if ($expertises[0] == $this->id) {
                            return true;//не блокируем если у материала одна экспертиза и является экспертом экспертизы
                        }
                        return false;//если не является экспертом экпертизы
                    }
                    return $material->creator_id == $this->id; //если у материала нет экпертизы и он создатель экспертизы
            }
        }
        return false;//блокируем и иных случиях
    }
}
