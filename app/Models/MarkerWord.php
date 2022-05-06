<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MarkerWord extends Model
{
    use HasFactory, HasHistories;

    public function getModelLabel()
    {
        return $this->word;
    }

    protected $table = 'marker_words';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'word',
        'type_id',
        'word_count',
    ];

    public function type()
    {
        return $this->hasOne(MarkerWordType::class, 'id', 'type_id');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function declensions()
    {
        return $this->belongsToMany(
            MarkerWord::class, MarkerWordDeclension::class,
            'word_id', 'declension_id');
    }

    public function materialWords()
    {
        return $this->hasMany(MaterialWord::class, 'word_id');
    }
}
