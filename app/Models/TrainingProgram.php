<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $table = 'training_programs';

    protected $guarded = [];

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class, 'program_id')->where('program_type', 'training');
    }
}
