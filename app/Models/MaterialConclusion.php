<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MaterialConclusion extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'material_conclusions';

    public function getModelLabel()
    {
        return $this->result;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'file_id',
        'result',
        'status_id',
    ];

    public function materials(){
        return $this->belongsToMany(Material::class, 'material_conclusion',
            'conclusion_id', 'material_id');
    }

//    public function experts(){
//        return $this->hasManyThrough(
//            User::class,
//            MaterialConclusionExpert::class,
//            'conclusion_id',
//            'id',
//            'id',
//            'expert_id');
//    }

    public function options(){
        return $this->belongsToMany(MaterialConclusionOption::class, 'material_conclusion_option', 'conclusion_id','option_id');
    }

    public function experts(){
        return $this->belongsToMany(User::class, 'material_conclusion_experts', 'conclusion_id','expert_id');
    }

    public function file(){
        return $this->hasOne(Document::class, 'id', 'file_id');
    }

    public function status(){
        return $this->hasOne(MaterialConclusionStatus::class, 'id', 'status_id');
    }
}
