<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllocationImage extends Model
{
    use HasFactory;

    protected $table = 'allocation_images';

    protected $fillable = [
        'allocation_id',
        'image_path',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class, 'allocation_id');
    }
}
?>
