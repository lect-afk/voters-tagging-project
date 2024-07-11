<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    use HasFactory;
    protected $table = 'sitio';
    protected $fillable = ['name', 'barangay', 'purok'];

    public function barangays()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function puroks()
    {
        return $this->belongsTo(Purok::class, 'purok', 'id');
    }

    public function votersProfile()
    {
        return $this->hasMany(VotersProfile::class);
    }
}

