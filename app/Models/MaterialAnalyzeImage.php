<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class MaterialAnalyzeImage extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'material_analyze_images';

    public function getModelLabel()
    {
        return $this->material()->value('name').' - '.$this->coefficient.'%';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'search_image_id',
        'coefficient',
        'image_id',
        'size',
        'conclusion',
    ];

    protected $casts = [
        'coefficient' => 'float'
    ];

    public function searchImage(){
        return $this->hasOne(Document::class, 'id', 'search_image_id');
    }

    public function searchMaterial(){
        return $material = Material::query()
            ->leftJoin('material_images', 'materials.file_id', '=', 'material_images.file_id')
            ->where('material_images.image_id', '=', $this->search_image_id)
            ->orWhere('materials.file_id', '=', $this->search_image_id)
            ->select('materials.*');
    }

    public function image(){
        return $this->hasOne(Document::class, 'id', 'image_id');
    }

    public function material(){
        return $material = Material::query()
            ->leftJoin('material_images', 'materials.file_id', '=', 'material_images.file_id')
            ->where('material_images.image_id', '=', $this->image_id)
            ->orWhere('materials.file_id', '=', $this->image_id)
            ->select('materials.*');
    }
}
