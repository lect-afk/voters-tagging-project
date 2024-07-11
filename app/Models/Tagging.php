<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagging extends Model
{
    use HasFactory;
    protected $table = 'tagging';
    protected $fillable = ['predecessor','successor','tier_level','team'];

    public function predecessors()
    {
        return $this->belongsTo(VotersProfile::class, 'predecessor');
    }

    public function successors()
    {
        return $this->belongsTo(VotersProfile::class, 'successor');
    }
}
