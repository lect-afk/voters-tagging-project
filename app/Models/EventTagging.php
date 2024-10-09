<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTagging extends Model
{
    use HasFactory;

    protected $table = 'events_tagging';

    protected $fillable = [
        'profile_id',
        'event_id'
    ];

    /**
     * Get the profile that owns the event tagging.
     */
    public function votersProfiles()
    {
        return $this->belongsToMany(VotersProfile::class, 'events_tagging', 'event_id', 'profile_id');
    }
}
