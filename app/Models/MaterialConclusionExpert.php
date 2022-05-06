<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialConclusionExpert extends Model
{
    use HasFactory;

    protected $table = 'material_conclusion_experts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'conclusion_id',
        'expert_id',
    ];

    public function conclusion(){
        return $this->hasOne(MaterialConclusion::class, 'id', 'conclusion_id');
    }

    public function expert(){
        return $this->hasOne(User::class, 'id', 'expert_id');
    }
}
