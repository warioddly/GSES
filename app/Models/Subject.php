<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Panoscape\History\HasHistories;

class Subject extends Model
{
    use HasFactory, HasHistories;

    protected $fillable = [
        'subject_case',
        'note',
        'user_id'
    ];

    public function getModelLabel()
    {
        return $this->subject_case;
    }

    public function nicknames()
    {
        return $this->hasMany(SubjectNickname::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expertises(): BelongsToMany
    {
        return $this->belongsToMany(Expertise::class);
    }
}
