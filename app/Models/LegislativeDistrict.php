<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegislativeDistrict extends Model
{
    use HasFactory;
    protected $table = 'legislative_district';
    protected $fillable = ['name','province'];

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
