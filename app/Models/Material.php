<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Jobs\ProcessMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Panoscape\History\HasHistories;
use Panoscape\History\History;
use PhpParser\Comment\Doc;

class Material extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'materials';

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
        'object_type_id',
        'type_id',
        'child_type_id',
        'source',
        'language_id',
        'file_id',
        'file_text',
        'file_text_comment',
        'status_id',
        'creator_id',
    ];

    public function objectType()
    {
        return $this->hasOne(MaterialObjectType::class, 'id', 'object_type_id');
    }

    public function type()
    {
        return $this->hasOne(MaterialType::class, 'id', 'type_id');
    }

    public function language()
    {
        return $this->hasOne(MaterialLanguage::class, 'id', 'language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function file()
    {
        return $this->hasOne(Document::class, 'id', 'file_id');
    }

    public function status()
    {
        return $this->hasOne(MaterialStatus::class, 'id', 'status_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function expertise()
    {
        return $this->hasManyThrough(
            Expertise::class,
            ExpertiseMaterial::class,
            'material_id',
            'id',
            'id',
            'expertise_id')->select('expertise.*');
    }

    public function vir_expertises(): BelongsToMany
    {
        return $this->belongsToMany(Expertise::class, 'expertise_materials', 'material_id', 'expertise_id');
    }
    public function n_expertises()
    {
        return $this->belongsToMany(Expertise::class, 'expertise_materials', 'material_id', 'expertise_id');
    }

    public function conclusions()
    {
        return $this->belongsToMany(
            MaterialConclusion::class,
            'material_conclusion',
            'material_id',
            'conclusion_id');
    }

    public function decisions()
    {
        return $this->hasMany(
            MaterialDecision::class,
            'material_id',
            'id');
    }

    public function analyzes()
    {
        return $this->hasMany(
            MaterialAnalyze::class,
            'search_material_id',
            'id'
        );
    }

    public function words()
    {
        return $this->hasMany(
            MaterialWord::class,
            'material_id',
            'id');
    }

    public function analyzeImages()
    {
        $materialAnalyzeImages = MaterialAnalyzeImage::query()
            ->leftJoin('material_images', 'material_analyze_images.search_image_id', '=', 'material_images.image_id')
            ->where('material_images.file_id', '=', $this->file_id)
            ->orWhere('material_analyze_images.search_image_id', '=', $this->file_id)
            ->select('material_analyze_images.*');
        return $materialAnalyzeImages;
    }

    public function images()
    {
        return $this->belongsToMany(
            Document::class,
            'material_images',
            'file_id',
            'image_id',
            'file_id',
            'id');
    }

    public function histories()
    {
        $history = History::where(function ($query) {
            $query->where(function ($query) {
                $query->where('model_type', Expertise::class);
                $query->whereIn('model_id', $this->expertise()->pluck('id')->toArray());
            })
                ->orWhere(function ($query) {
                    $query->where('model_type', MaterialConclusion::class);
                    $query->whereIn('model_id', $this->conclusions()->select("material_conclusions.*")->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', MaterialDecision::class);
                    $query->whereIn('model_id', $this->decisions()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', Material::class);
                    $query->whereIn('model_id', [$this->id]);
                });
        });

        return $history;
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::created(function (Material $material) {

            if (request()->hasFile('file')) {
                ProcessMaterial::dispatch('created', $material->id, []);
            }

        });

        static::updating(function (Material $material) {
            if (request()->hasFile('file')) {
                $old_images = $material->images()->pluck('material_images.image_id')->all();
                $file = $material->file()->first();
                if ($file && $file->isImage()) {
                    $old_images[] = $file->id;
                }
                ProcessMaterial::dispatch('updating', $material->id, $old_images);
            }
        });

        static::updated(function ($material) {

            if (request()->hasFile('file')) {
                ProcessMaterial::dispatch('updated', $material->id, []);
            }

        });

        static::deleting(function (Material $material) {
            $old_images = $material->images()->pluck('material_images.image_id')->all();
            $file = $material->file()->first();
            if ($file && $file->isImage()) {
                $old_images[] = $file->id;
            }
            ProcessMaterial::dispatch('deleting', $material->id, $old_images);

        });
    }
}
