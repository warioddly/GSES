<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTypeObjectType extends Model
{
    use HasFactory;

    protected $table = 'material_type_object_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'object_type_id',
        'type_id',
    ];

    public function objectType(){
        return $this->hasOne(MaterialObjectType::class, 'id', 'object_type_id');
    }

    public function type(){
        return $this->hasOne(MaterialType::class, 'id', 'type_id');
    }
}
