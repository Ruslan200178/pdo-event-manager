<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedParticipant extends Model
{
    use HasFactory;

    protected $table = 'selected_participants';

    protected $guarded = [];

    public function proyouth()
    {
        return $this->morphTo();
    }
}
