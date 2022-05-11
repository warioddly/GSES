<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaterialChildType extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title'];
    protected $table = 'material_child_types';
    protected $guarded = false;
}
