<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class ExpertiseDecision extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'expertise_decisions';

    public function getModelLabel()
    {
        return $this->file()->value('name');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'expertise_id',
        'court_id',
        'court_name_id',
        'date',
        'file_id',
        'creator_id',
        'comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];


    public function expertise(){
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function court(){
        return $this->hasOne(ExpertiseCourt::class, 'id', 'court_id');
    }

    public function courtName(){
        return $this->hasOne(ExpertiseCourtName::class, 'id', 'court_name_id');
    }

    public function file(){
        return $this->hasOne(Document::class, 'id', 'file_id');
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
