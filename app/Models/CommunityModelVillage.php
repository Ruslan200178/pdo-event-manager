<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityModelVillage extends Model
{
    use HasFactory;

    protected $table = 'community_model_village';

    protected $casts = [
        'date' => 'datetime',
        'awareness_date' => 'datetime',
        'stakeholder_awareness_date' => 'datetime',
        'launching_date' => 'datetime',
    ];
    protected $fillable = [
        'district_allocation',
        'vote_number',
        'date',
        'amount',
        'purpose',
        'division_name',
        'gn_division',
        'village',
        'contacted_staff',
        'awareness_date',
        'stakeholder_awareness_date',
        'participants_count',
        'launching_date',
        'ceremony_participants_count',
    ];

}
