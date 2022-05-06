<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExpertiseCourtName extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'expertise_court_names';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'court_id',
    ];


    public function court(){
        return $this->belongsTo(ExpertiseCourt::class, 'court_id');
    }
    public $translatable =['title'];
}
