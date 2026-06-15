<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $table = 'gallery_images';

    protected $guarded = [];

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id')->where('gallery_images.program_type', 'training');
    }
}
