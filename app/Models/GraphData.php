<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphData extends Model
{
    use HasFactory;
    public $table = 'graph_data';
    protected $guarded = false;
}
