<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTagging extends Model
{
    use HasFactory;

    protected $table = 'group_tagging';

    protected $fillable = [
        'profile_id',
        'group_id',
        'color_tag',
    ];

    public function profile()
    {
        return $this->belongsTo(VotersProfile::class, 'profile_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
