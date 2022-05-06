<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserPosition extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'user_positions';
    public $translatable = ['title'];
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
