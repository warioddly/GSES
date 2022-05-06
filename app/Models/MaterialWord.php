<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialWord extends Model
{
    use HasFactory;

    protected $table = 'material_words';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'material_id',
        'word_id',
        'type_id',
        'frequency',
    ];

    protected $casts = [
        'frequency' => 'integer'
    ];

    public function material() {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }

    public function word() {
        return $this->hasOne(MarkerWord::class, 'id', 'word_id');
    }

    public function type() {
        return $this->hasOne(MarkerWordType::class, 'id', 'type_id');
    }
}
