<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateTagging extends Model
{
    use HasFactory;

    protected $table = 'candidates_tagging';

    protected $fillable = [
        'profile_id',
        'candidate_id',
        'color_tag',
    ];

    public function profile()
    {
        return $this->belongsTo(VotersProfile::class, 'profile_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }
}
