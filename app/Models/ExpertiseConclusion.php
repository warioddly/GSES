<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertiseConclusion extends Model
{
    use HasFactory;
    protected $table = 'expertise_conclusions';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'expertise_id',
        'document_id',
    ];

    public function expertise() {
        return $this->hasOne(Expertise::class, 'id', 'expertise_id');
    }

    public function document() {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

}
