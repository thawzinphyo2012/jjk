<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graphic extends Model
{
    protected $fillable = [
        'title',
        'title_mm',
        'category',
        'category_mm',
        'description',
        'description_mm',
        'gradient',
        'image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
