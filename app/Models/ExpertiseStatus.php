<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class ExpertiseStatus extends Model implements Sortable
{
    use SortableTrait;
    use HasTranslations;
    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
    use HasFactory;
    protected $table = 'expertise_status';
    public $translatable = ['title'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'order',
    ];
}
