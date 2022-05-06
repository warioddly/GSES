<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MaterialConclusionStatus extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'material_conclusion_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
    public $translatable =['title'];
}
