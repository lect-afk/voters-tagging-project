<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    protected $fillable = ['name','district','province'];

    public function barangays()
    {
        return $this->hasMany(Barangay::class);
    }

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function districts()
    {
        return $this->belongsTo(LegislativeDistrict::class, 'district', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'city');
    }
}
