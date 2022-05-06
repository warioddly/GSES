<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaterialLanguage extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable =['title'];
    protected $table = 'material_languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
    ];
}
