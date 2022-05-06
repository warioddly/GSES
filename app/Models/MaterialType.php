<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaterialType extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'material_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
    public $translatable = ['title'];
    public function materialObjectTypes()
    {
        $this->belongsToMany(MaterialObjectType::class, 'material_type_object_types', 'type_id', 'object_type_id');
    }
}
