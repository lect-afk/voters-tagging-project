<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['fullname', 'position', 'city', 'district', 'province'];

    public function cities()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function districts()
    {
        return $this->belongsTo(LegislativeDistrict::class, 'district', 'id');
    }

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function candidateTaggings()
    {
        return $this->hasMany(CandidateTagging::class, 'candidate_id');
    }
}
