<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExpertiseStatusReason extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'expertise_status_reasons';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'status_id',
    ];

    public function status(){
        return $this->hasOne(ExpertiseStatus::class, 'id', 'status_id');
    }
    public $translatable =['title'];
}
