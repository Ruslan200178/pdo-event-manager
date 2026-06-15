<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProYouthVideo extends Model
{
    use HasFactory;

    protected $table = 'proyouth_video_competition';

    protected $guarded = [];

    public function selection()
    {
        return $this->morphOne(SelectedParticipant::class, 'proyouth');
    }
}
