<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;
    protected $table = 'barangay';
    protected $fillable = ['name','city'];

    public function puroks()
    {
        return $this->hasMany(Purok::class, 'barangay', 'id');
    }

    public function sitios()
    {
        return $this->hasMany(Sitio::class);
    }

    public function votersProfiles()
    {
        return $this->hasMany(VotersProfile::class);
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function precincts()
    {
        return $this->hasMany(Precinct::class);
    }
}

