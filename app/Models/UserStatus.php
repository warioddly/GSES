<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserStatus extends Model
{
    use HasFactory, HasTranslations;
    public$translatable = ['title'];
    public $timestamps = false;
}
