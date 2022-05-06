<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class ExpertiseArticle extends Model
{
    use HasFactory, HasHistories;

    protected $fillable = [
        'title',
    ];
    public function expertises()
    {
        return $this->hasMany(Expertise::class,'article_id');
    }

    public function getModelLabel()
    {
        return $this->title;
    }
}
