<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExpertiseDifficulty extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'expertise_difficulties';

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
