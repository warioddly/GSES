<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MaterialAnalyze extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'material_analyzes';

    public function getModelLabel()
    {
        return $this->material()->value('name').' - '.$this->coefficient.'%';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'search_material_id',
        'search_text',
        'result',
        'material_id',
        'coefficient',
        'conclusion',
    ];

    protected $casts = [
        'coefficient' => 'float'
    ];

    public function search_material(){
        return $this->hasOne(Material::class, 'id', 'search_material_id');
    }

    public function material(){
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}
