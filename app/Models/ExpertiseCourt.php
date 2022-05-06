<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExpertiseCourt extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'expertise_courts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
    public $translatable =['title'];
    public function courtNames()
    {
        return $this->hasMany(ExpertiseCourtName::class, 'court_id');
    }
}
