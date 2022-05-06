<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseExpert extends Model
{
    use HasFactory;

    protected $table = 'expertise_experts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'expertise_id',
        'expert_id',
    ];


    public function expertise(){
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function expert(){
        return $this->hasOne(User::class, 'id', 'expert_id');
    }
}
