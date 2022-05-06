<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialWordPosition extends Model
{
    use HasFactory;

    protected $table = 'material_word_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'material_word_id',
        'position',
    ];

    protected $casts = [
        'position' => 'integer'
    ];

    public function material_position(){
        $this->belongsTo(MaterialWord::class, 'id', 'material_word_id');
    }
}
