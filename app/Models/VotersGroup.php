<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotersGroup extends Model
{
    use HasFactory;
    protected $table = 'voters_group';
    protected $fillable = ['group', 'voter'];

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }

    public function votersProfiles()
    {
        return $this->belongsTo(VotersProfile::class);
    }
}

