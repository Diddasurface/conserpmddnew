<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingArea extends Model
{
    use HasFactory;

    protected $table = 'consulting_areas'; 
    protected $fillable = [
        'name',
        'title',
        'description',
        'image_url',
        'logo',
        'tags',
        'status',
    ];
}
