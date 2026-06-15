<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProYouthProposal extends Model
{
    use HasFactory;

    protected $table = 'proyouth_project_proposal';

    protected $guarded = [];

    public function selection()
    {
        return $this->morphOne(SelectedParticipant::class, 'proyouth');
    }
}
