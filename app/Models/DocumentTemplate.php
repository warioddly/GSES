<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class DocumentTemplate extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'document_templates';

    public function getModelLabel()
    {
        return $this->title;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
        'document_id',
        'status_id',
        'creator_id',
    ];

    public function document(){
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

    public function status(){
        return $this->hasOne(DocumentTemplateStatus::class, 'id', 'status_id');
    }

    public function creator(){
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
