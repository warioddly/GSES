<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class ExpertiseTask extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'expertise_tasks';

    public function getModelLabel()
    {
        return $this->task;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'task',
        'comment',
        'status_id',
        'expertise_id',
        'creator_id',
        'date_start',
        'date_end',
    ];
    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
    ];

    public function status()
    {
        return $this->hasOne(ExpertiseTaskStatus::class, 'id', 'status_id');
    }

    public function expertise()
    {
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

//    public function experts(){
//        return $this->hasManyThrough(
//            User::class,
//            ExpertiseTaskExpert::class,
//            'task_id',
//            'id',
//            'id',
//            'expert_id');
//    }
    public function experts()
    {
        return $this->belongsToMany(
            User::class, 'expertise_task_experts', 'task_id', 'expert_id');
    }
}
