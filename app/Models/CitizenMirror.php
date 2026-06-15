<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenMirror extends Model
{
    use HasFactory;

    protected $table = 'citizen_mirror';

    protected $guarded = [];
}
