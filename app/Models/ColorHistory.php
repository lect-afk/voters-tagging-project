<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorHistory extends Model
{
    use HasFactory;

    protected $table = 'color_history';

    protected $fillable = [
        'profile_id',
        'old_tag',
        'new_tag',
        'remarks',
        'notes',
    ];

    public function profile()
    {
        return $this->belongsTo(VotersProfile::class, 'profile_id');
    }
}
