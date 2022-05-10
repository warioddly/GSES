<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialChildObjectType extends Model
{
    use HasFactory;
    protected $table = 'material_child_object_types';
    public $translatable =['title'];
}
