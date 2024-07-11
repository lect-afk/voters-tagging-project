<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purok extends Model
{
    use HasFactory;
    protected $table = 'purok';
    protected $fillable = ['name', 'barangay'];

    public function barangays()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function sitios()
    {
        return $this->hasMany(Sitio::class);
    }

    public function votersProfiles()
    {
        return $this->hasMany(VotersProfile::class);
    }
}

