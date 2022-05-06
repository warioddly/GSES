<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseTaskExpert extends Model
{
    use HasFactory;

    protected $table = 'expertise_task_experts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'task_id',
        'expert_id',
    ];


    public function task(){
        return $this->hasOne(ExpertiseTask::class, 'id', 'task_id');
    }

    public function expert(){
        return $this->hasOne(User::class, 'id', 'expert_id');
    }
}
