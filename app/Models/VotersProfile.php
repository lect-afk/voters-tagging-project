<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotersProfile extends Model
{
    use HasFactory;
    protected $table = 'voters_profile';
    protected $fillable = [
        'firstname', 'middlename', 'lastname', 
        'sitio', 'purok', 'barangay', 'precinct','leader'
    ];

    public function sitios()
    {
        return $this->belongsTo(Sitio::class, 'sitio', 'id');
    }

    public function puroks()
    {
        return $this->belongsTo(Purok::class, 'purok', 'id');
    }

    public function barangays()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function precincts()
    {
        return $this->belongsTo(Precinct::class, 'precinct', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'voters_group', 'voter_id', 'group_id');
    }

    public function predecessors()
    {
        return $this->hasMany(Tagging::class, 'predecessor');
    }

    public function successors()
    {
        return $this->hasMany(Tagging::class, 'successor');
    }
}

