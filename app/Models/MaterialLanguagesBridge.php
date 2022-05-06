<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLanguagesBridge extends Model
{
    use HasFactory;
    protected $table = 'material_languages_bridges';
    protected $fillable = [
        'material_language_id',
        'material_id'
    ];
}
