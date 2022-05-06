<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkerWordDeclension extends Model
{
    use HasFactory;

    protected $table = 'marker_word_declensions';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'word_id',
        'declension_id',
    ];


    public function word(){
        return $this->hasOne(MarkerWord::class, 'id', 'word_id');
    }

    public function declension(){
        return $this->hasOne(MarkerWord::class, 'id', 'declension_id');
    }
}
