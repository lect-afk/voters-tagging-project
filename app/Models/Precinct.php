<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precinct extends Model
{
    use HasFactory;
    protected $table = 'precinct';
    protected $fillable = ['number','barangay'];

    public function votersProfiles()
    {
        return $this->hasMany(VotersProfile::class);
    }

    public function barangays()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'precinct');
    }
}

