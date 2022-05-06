<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class SubjectNickname extends Model
{
    use HasFactory, HasHistories;

    protected $fillable = [
        'nickname',
        'user_id',
        'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getModelLabel()
    {
        return $this->display_name;
    }
}
