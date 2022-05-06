<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MarkerBlackWord extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'marker_black_words';

    public function getModelLabel()
    {
        return $this->word;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'terminology_id',
        'word',
        'declension',
        'language_id',
        'comment',
        'status_id',
        'creator_id',
    ];


    public function terminology(){
        return $this->hasOne(MarkerTerminology::class, 'id', 'terminology_id');
    }

    public function language(){
        return $this->hasOne(MaterialLanguage::class, 'id', 'language_id');
    }

    public function status(){
        return $this->hasOne(MarkerStatus::class, 'id', 'status_id');
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
