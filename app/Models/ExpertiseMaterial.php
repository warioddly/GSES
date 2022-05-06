<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseMaterial extends Model
{
    use HasFactory;

    protected $table = 'expertise_materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'expertise_id',
        'material_id',
    ];


    public function expertise(){
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function material(){
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}
