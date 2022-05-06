<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Report extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'reports';

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
        'description',
        'query',
        'template',
        'status_id',
    ];

    public function status() {
        return $this->hasOne(ReportStatus::class, 'id', 'status_id');
    }
}
