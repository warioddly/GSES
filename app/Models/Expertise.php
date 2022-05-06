<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Article;
use Panoscape\History\HasHistories;
use Panoscape\History\History;
use PhpParser\Builder\Trait_;

class Expertise extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'expertise';

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
        'number',
        'case_number',
        'reason',
        'decree_reg_number',
        'receipt_date',
        'start_date',
        'expiration_date',
        'contractor_id',
        'cover_id',
        'sequence_id',
        'composition_id',
        'difficulty_id',
        'resolution_id',
        'conclusion_id',
        'comment',
        'questions',
        'status_id',
        'status_reason_id',
        'creator_id',
        'created',
        'subject_id',
        'them',
        'article_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'receipt_date' => 'datetime',
        'start_date' => 'datetime',
        'expiration_date' => 'datetime',
        'created' => 'boolean',
    ];

    public function setReceiptDateAttribute($value)
    {
        if (empty($value)) return;
        $this->attributes['receipt_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getReceiptDateAttribute($value)
    {
        if (empty($value)) return $value;
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setStartDateAttribute($value)
    {
        if (empty($value)) return;
        $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getStartDateAttribute($value)
    {
        if (empty($value)) return $value;
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setExpirationDateAttribute($value)
    {
        if (empty($value)) return;
        $this->attributes['expiration_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getExpirationDateAttribute($value)
    {
        if (empty($value)) return $value;
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }

    public function types()
    {
        return $this->belongsToMany(ExpertiseType::class,
            'expertise_type',
            'expertise_id',
            'type_id');
    }

    public function sequence()
    {
        return $this->hasOne(ExpertiseSequence::class, 'id', 'sequence_id');
    }

    public function composition()
    {
        return $this->hasOne(ExpertiseComposition::class, 'id', 'composition_id');
    }

    public function difficulty()
    {
        return $this->hasOne(ExpertiseDifficulty::class, 'id', 'difficulty_id');
    }

    public function resolution()
    {
        return $this->hasOne(Document::class, 'id', 'resolution_id');
    }

    public function conclusion()
    {
        return $this->hasOne(Document::class, 'id', 'conclusion_id');
    }

    public function status()
    {
        return $this->hasOne(ExpertiseStatus::class, 'id', 'status_id');
    }

    public function status_reason()
    {
        return $this->hasOne(ExpertiseStatusReason::class, 'id', 'status_reason_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function experts()
    {
        return $this->hasManyThrough(User::class, ExpertiseExpert::class, 'expertise_id', 'id', 'id', 'expert_id')->select('users.*');
    }

    public function vir_experts()
    {
        return $this->belongsToMany(User::class, 'expertise_experts', 'expertise_id', 'expert_id');
    }

    public function materials()
    {
        return $this->hasManyThrough(
            Material::class,
            ExpertiseMaterial::class,
            'expertise_id',
            'id',
            'id',
            'material_id')->select('materials.*');
    }

    public function tasks()
    {
        return $this->hasMany(ExpertiseTask::class, 'expertise_id', 'id');
    }

    public function conclusions()
    {
//        return $this->hasManyThrough(
//            MaterialConclusion::class,
//            ExpertiseMaterial::class,
//            'expertise_id',
//            'material_id',
//            'id',
//            'material_id')
//            ->select('material_conclusions.*');
        return MaterialConclusion::query()
            ->join('material_conclusion', 'material_conclusions.id', '=', 'material_conclusion.conclusion_id')
            ->join('expertise_materials', 'material_conclusion.material_id', '=', 'expertise_materials.material_id')
            ->where('expertise_materials.expertise_id', '=', $this->id)
            ->select('material_conclusions.*')->distinct();

    }

    public function petitions()
    {
        return $this->hasMany(ExpertisePetition::class, 'expertise_id', 'id');
    }

    public function decisions()
    {
        return $this->hasMany(ExpertiseDecision::class, 'expertise_id', 'id');
    }

    public function histories()
    {
        $history = History::where(function ($query) {
            $query->where(function ($query) {
                $query->where('model_type', Material::class);
                $query->whereIn('model_id', $this->materials()->pluck('id')->toArray());
            })
                ->orWhere(function ($query) {
                    $query->where('model_type', ExpertiseTask::class);
                    $query->whereIn('model_id', $this->tasks()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', MaterialConclusion::class);
                    $query->whereIn('model_id', $this->conclusions()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', ExpertisePetition::class);
                    $query->whereIn('model_id', $this->petitions()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', ExpertiseDecision::class);
                    $query->whereIn('model_id', $this->decisions()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) {
                    $query->where('model_type', Expertise::class);
                    $query->whereIn('model_id', [$this->id]);
                });
        });

        return $history;
    }

    public function assignExperts($experts = [])
    {
        $assignedExperts = $this->hasMany(ExpertiseExpert::class, 'expertise_id', 'id')->pluck('expert_id')->all();
        foreach ($assignedExperts as $assigned_id) {
            if (!in_array($assigned_id, $experts)) {
                Expertise::find($assigned_id)->delete();
            }
        }
        foreach ($experts as $expert_id) {
            if (!in_array($expert_id, $assignedExperts)) {
                ExpertiseExpert::create([
                    'expertise_id' => $this->id,
                    'expert_id' => $expert_id
                ]);
            }
        }
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(ExpertiseArticle::class, 'article_id');
    }
}
