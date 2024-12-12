<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'group';
    protected $fillable = ['name'];

    public function votersProfiles()
    {
        return $this->belongsToMany(VotersProfile::class, 'voters_group', 'group_id', 'voter_id');
    }

    public function groupTaggings()
    {
        return $this->hasMany(GroupTagging::class, 'group_id');
    }
}

