<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class Contractor extends Model
{
    use HasFactory, HasHistories;

    protected $table = 'contractors';

    public function getModelLabel()
    {
        return "$this->last_name $this->name $this->middle_name";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type_id',
        'organ_id',
        'sub_organ',
        'last_name',
        'name',
        'middle_name',
        'position',
        'phone',
        'email',
        'cover',
        'region_id',
        'district_id',
        'creator_id',
    ];

    public function getTitleAttribute()
    {
        return $this->last_name . ' ' . $this->name . ' ' . $this->middle_name;
    }

    public function type()
    {
        return $this->hasOne(ContractorType::class, 'id', 'type_id');
    }

    public function organ()
    {
        return $this->hasOne(ContractorOrgan::class, 'id', 'organ_id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function getVirFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->name . ' ' . $this->middle_name;
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function expertise()
    {
        return $this->hasMany(Expertise::class, 'contractor_id');
    }
}
