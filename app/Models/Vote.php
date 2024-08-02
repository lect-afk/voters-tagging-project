<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'actual_votes', 'precinct'];

    public function candidates()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function precincts()
    {
        return $this->belongsTo(Precinct::class, 'precinct', 'id');
    }
}
