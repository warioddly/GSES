<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Entity extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'entities';

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
        'name',
        'address',
        'phone',
        'email',
        'site',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function forbidden(){
        return $this->hasMany(EntityForbidden::class, 'entity_id', 'id');
    }
}
