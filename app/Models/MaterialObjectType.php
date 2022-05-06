<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaterialObjectType extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'material_object_types';
    public $translatable =['title'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
    public function materialTypes()
    {
        return $this->belongsToMany(MaterialType::class, 'material_type_object_types', 'object_type_id', 'type_id');
    }
}
