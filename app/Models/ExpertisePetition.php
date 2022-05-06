<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class ExpertisePetition extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'expertise_petitions';

    public function getModelLabel()
    {
        return $this->reason;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'expertise_id',
        'expert_id',
        'reason',
        'type_id',
        'scan_id',
        'status_id',
        'creator_id',
    ];


    public function expertise(){
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function expert(){
        return $this->hasOne(User::class, 'id', 'expert_id');
    }

    public function type(){
        return $this->hasOne(ExpertisePetitionType::class, 'id', 'type_id');
    }

    public function scan(){
        return $this->hasOne(Document::class, 'id', 'scan_id');
    }

    public function status(){
        return $this->hasOne(ExpertisePetitionStatus::class, 'id', 'status_id');
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
