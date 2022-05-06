<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MaterialDecision extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'material_decisions';

    public function getModelLabel()
    {
        return $this->courtDecision()->value('title');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'material_id',
        'article_id',
        'court_decision_id',
        'comment',
        'date',
        'status_id',
        'creator_id',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

    public function material(){
        return $this->hasOne(Material::class, 'id', 'material_id');
    }

    public function article(){
        return $this->hasOne(MaterialArticle::class, 'id', 'article_id');
    }

    public function courtDecision(){
        return $this->hasOne(MaterialCourtDecision::class, 'id', 'court_decision_id');
    }

    public function status(){
        return $this->hasOne(MaterialDecisionStatus::class, 'id', 'status_id');
    }
    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
