<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'purpose',
        'division_name',
        'program_type',
        'participants_count',
    ];

    // Relationship to allocation images
    public function images()
    {
        return $this->hasMany(\App\Models\AllocationImage::class, 'allocation_id');
    }
}
?>
