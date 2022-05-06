<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class EntityForbidden extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'entity_forbiddens';

    public function getModelLabel()
    {
        return $this->name;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'entity_id',
        'date',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function entity(){
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }
}
