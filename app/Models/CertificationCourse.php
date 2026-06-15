<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationCourse extends Model
{
    use HasFactory;

    protected $table = 'certification_courses';

    protected $guarded = [];
}
