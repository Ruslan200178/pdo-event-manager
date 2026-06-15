<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalProductivityCompetition extends Model
{
    use HasFactory;

    protected $table = 'national_productivity_competitions';

    protected $guarded = [];

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class, 'program_id')->where('program_type', 'national_productivity');
    }
}
