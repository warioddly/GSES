<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialChildType extends Model
{
    use HasFactory;
    protected $table = 'material_child_types';
    public $translatable = ['title'];
}
